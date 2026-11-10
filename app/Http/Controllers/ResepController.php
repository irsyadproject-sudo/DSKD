<?php

namespace App\Http\Controllers;

use App\Models\DetailResep;
use App\Models\Obat;
use App\Models\Pemeriksaan;
use App\Models\Resep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ResepController extends Controller
{
    /**
     * Menampilkan data resep (dari dokter yang login).
     */
    public function resep_data(): View
    {
        $dokter = auth()->user()->dokter;

        $resep = Resep::with(['pemeriksaan.pasien', 'detailResep.obat'])
            ->whereHas('pemeriksaan', fn ($q) => $q->where('dokter_id', $dokter->id))
            ->latest()
            ->get();

        return view('resep.index', compact('resep'));
    }

    /**
     * Menambah/menginput resep obat.
     * GET -> tampilkan form, POST -> simpan dan potong stok.
     */
    public function resep_add(Request $request): View|RedirectResponse
    {
        $dokter = auth()->user()->dokter;

        if ($request->isMethod('GET')) {
            $pemeriksaanList = Pemeriksaan::with('pasien')
                ->where('dokter_id', $dokter->id)
                ->latest()
                ->get();

            $obat = Obat::where('status', 'aktif')->get();

            return view('resep.create', compact('pemeriksaanList', 'obat'));
        }

        $data = $request->validate([
            'pemeriksaan_id' => ['required', 'exists:pemeriksaan,id'],
            'obat_id' => ['required', 'exists:obat,id'],
            'qty' => ['required', 'integer', 'min:1'],
            'aturan_pakai' => ['nullable', 'string', 'max:255'],
        ]);

        $obat = Obat::findOrFail($data['obat_id']);

        if ($obat->stok < $data['qty']) {
            return back()->withErrors(['obat_id' => 'Stok obat tidak mencukupi.']);
        }

        $resep = Resep::create([
            'pemeriksaan_id' => $data['pemeriksaan_id'],
            'no_resep' => 'RSP-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
            'tanggal' => now()->toDateString(),
        ]);

        DetailResep::create([
            'resep_id' => $resep->id,
            'obat_id' => $obat->id,
            'aturan_pakai' => $data['aturan_pakai'] ?? null,
            'qty' => $data['qty'],
            'stok_sebelum' => $obat->stok,
            'harga' => $obat->harga,
            'subtotal' => $obat->harga * $data['qty'],
        ]);

        $obat->decrement('stok', $data['qty']);

        return redirect()->route('resep.add')->with('success', 'Resep berhasil disimpan dan stok obat dikurangi.');
    }

    /**
     * Mengubah data resep (kembalikan & potong ulang stok).
     * GET -> tampilkan form, POST/PUT -> perbarui.
     */
    public function resep_edit(Request $request, Resep $resep): View|RedirectResponse
    {
        $dokter = auth()->user()->dokter;

        if ($resep->pemeriksaan?->dokter_id !== $dokter->id) {
            abort(403, 'Anda tidak memiliki akses ke resep ini.');
        }

        if ($request->isMethod('GET')) {
            $resep->load(['pemeriksaan.pasien', 'detailResep.obat']);
            $obat = Obat::where('status', 'aktif')->get();

            return view('resep.edit', compact('resep', 'obat'));
        }

        $data = $request->validate([
            'obat_id' => ['required', 'array', 'min:1'],
            'obat_id.*' => ['exists:obat,id'],
            'qty' => ['required', 'array', 'min:1'],
            'qty.*' => ['integer', 'min:1'],
            'aturan_pakai' => ['nullable', 'array'],
            'aturan_pakai.*' => ['nullable', 'string', 'max:255'],
        ]);

        $detailLama = $resep->detailResep()->with('obat')->get();
        $obatBaru = collect($data['obat_id'])->map(fn ($id) => Obat::find($id));

        foreach ($obatBaru as $i => $obat) {
            $detail = $detailLama->firstWhere('obat_id', $obat->id);
            $tersedia = $detail ? ($obat->stok + $detail->qty) : $obat->stok;

            if ($tersedia < $data['qty'][$i]) {
                return back()->withErrors([
                    "qty.{$i}" => "Stok obat {$obat->nama} tidak mencukupi (tersedia {$tersedia}).",
                ])->withInput();
            }
        }

        DB::transaction(function () use ($resep, $data, $detailLama) {
            foreach ($detailLama as $detail) {
                $detail->obat->increment('stok', $detail->qty);
            }

            $resep->detailResep()->delete();

            foreach ($data['obat_id'] as $i => $obatId) {
                $obat = Obat::findOrFail($obatId);

                $resep->detailResep()->create([
                    'obat_id' => $obat->id,
                    'aturan_pakai' => $data['aturan_pakai'][$i] ?? null,
                    'qty' => $data['qty'][$i],
                    'stok_sebelum' => $obat->stok,
                    'harga' => $obat->harga,
                    'subtotal' => $obat->harga * $data['qty'][$i],
                ]);

                $obat->decrement('stok', $data['qty'][$i]);
            }
        });

        return redirect()->route('resep.data')->with('success', 'Resep berhasil diperbarui dan stok obat disesuaikan.');
    }

    /**
     * Menghapus resep obat beserta detailnya dan kembalikan stok obat.
     */
    public function resep_hapus(Resep $resep): RedirectResponse
    {
        $dokter = auth()->user()->dokter;

        if ($resep->pemeriksaan?->dokter_id !== $dokter->id) {
            abort(403, 'Anda tidak memiliki akses ke resep ini.');
        }

        DB::transaction(function () use ($resep) {
            foreach ($resep->detailResep()->with('obat')->get() as $detail) {
                $detail->obat->increment('stok', $detail->qty);
            }

            $resep->detailResep()->delete();
            $resep->delete();
        });

        return redirect()->route('resep.data')->with('success', 'Resep berhasil dihapus dan stok obat dikembalikan.');
    }

    /**
     * Mencetak lembar resep.
     */
    public function resep_cetak(Resep $resep): View
    {
        $resep->load(['pemeriksaan.pasien', 'pemeriksaan.dokter', 'detailResep.obat']);

        return view('resep.cetak', compact('resep'));
    }
}