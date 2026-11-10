<?php

namespace App\Http\Controllers;

use App\Models\DetailPembayaran;
use App\Models\Dokter;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PembayaranController extends Controller
{
    /**
     * Menampilkan transaksi pembayaran dengan filter dokter & periode.
     */
    public function pembayaran_data(Request $request): View
    {
        $dokterId = $request->query('dokter_id');
        $dari = $request->query('dari');
        $sampai = $request->query('sampai');

        $pembayaran = Pembayaran::with('pendaftaran.pasien')
            ->when($dokterId, function ($query) use ($dokterId) {
                return $query->whereHas('pendaftaran.jadwalDokter', fn ($j) => $j->where('dokter_id', $dokterId));
            })
            ->when($dari, fn ($query) => $query->whereDate('tanggal_bayar', '>=', $dari))
            ->when($sampai, fn ($query) => $query->whereDate('tanggal_bayar', '<=', $sampai))
            ->latest()
            ->paginate(15);

        $dokter = Dokter::where('status', 'aktif')->get();

        return view('pembayaran.index', compact('pembayaran', 'dokter', 'dokterId', 'dari', 'sampai'));
    }

    /**
     * Menambah/memproses transaksi pembayaran.
     * GET -> tampilkan form, POST -> simpan.
     */
    public function pembayaran_add(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            $pendaftaran = Pendaftaran::with('pasien')
                ->where('status', '!=', 'batal')
                ->doesntHave('pembayaran')
                ->latest()
                ->get();

            return view('pembayaran.create', compact('pendaftaran'));
        }

        $data = $request->validate([
            'pendaftaran_id' => ['required', 'exists:pendaftaran,id'],
            'metode_pembayaran' => ['required', 'in:tunai,transfer,e-wallet,kartu_debit,kartu_kredit'],
        ]);

        $pendaftaran = Pendaftaran::findOrFail($data['pendaftaran_id']);

        if ($pendaftaran->pembayaran) {
            return back()->withErrors(['pendaftaran_id' => 'Pendaftaran ini sudah dibayar.']);
        }

        $total = $this->hitungTotal($pendaftaran);

        $pembayaran = Pembayaran::create([
            'pendaftaran_id' => $pendaftaran->id,
            'no_kuitansi' => 'KWN-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
            'tanggal_bayar' => now()->toDateString(),
            'total_tindakan' => $total['total_tindakan'],
            'total_obat' => $total['total_obat'],
            'total_biaya' => $total['total_biaya'],
            'metode_pembayaran' => $data['metode_pembayaran'],
            'status' => 'lunas',
        ]);

        $pemeriksaan = Pemeriksaan::with(['pemeriksaanTindakan.tindakan', 'resep.detailResep.obat'])
            ->where('pendaftaran_id', $pendaftaran->id)
            ->get();

        foreach ($pemeriksaan as $p) {
            foreach ($p->pemeriksaanTindakan as $pt) {
                DetailPembayaran::create([
                    'pembayaran_id' => $pembayaran->id,
                    'tipe' => 'tindakan',
                    'referensi_id' => $pt->tindakan_id,
                    'nama_item' => $pt->tindakan->nama,
                    'qty' => $pt->qty,
                    'harga' => $pt->harga,
                    'subtotal' => $pt->subtotal,
                ]);
            }

            foreach ($p->resep as $r) {
                foreach ($r->detailResep as $dr) {
                    DetailPembayaran::create([
                        'pembayaran_id' => $pembayaran->id,
                        'tipe' => 'obat',
                        'referensi_id' => $dr->obat_id,
                        'nama_item' => $dr->obat->nama,
                        'qty' => $dr->qty,
                        'harga' => $dr->harga,
                        'subtotal' => $dr->subtotal,
                    ]);
                }
            }
        }

        return redirect()->route('pembayaran.data')->with('success', 'Pembayaran berhasil diproses.');
    }

    /**
     * Hitung total biaya dari tindakan & obat pada pendaftaran terkait.
     */
    private function hitungTotal(Pendaftaran $pendaftaran): array
    {
        $pemeriksaan = Pemeriksaan::where('pendaftaran_id', $pendaftaran->id)->get();

        $totalTindakan = $pemeriksaan->sum(fn ($p) => $p->pemeriksaanTindakan->sum('subtotal'));
        $totalObat = $pemeriksaan->sum(fn ($p) => $p->resep->sum(
            fn ($r) => $r->detailResep->sum('subtotal')
        ));

        return [
            'total_tindakan' => $totalTindakan,
            'total_obat' => $totalObat,
            'total_biaya' => $totalTindakan + $totalObat,
        ];
    }

    /**
     * Mengubah data transaksi pembayaran (metode & status).
     * GET -> tampilkan form, POST/PUT -> perbarui.
     */
    public function pembayaran_edit(Request $request, Pembayaran $pembayaran): View|RedirectResponse
    {
        if ($request->isMethod('GET')) {
            $pembayaran->load(['pendaftaran.pasien']);

            return view('pembayaran.edit', compact('pembayaran'));
        }

        $data = $request->validate([
            'metode_pembayaran' => ['required', 'in:tunai,transfer,e-wallet,kartu_debit,kartu_kredit'],
            'status' => ['required', 'in:lunas,batal'],
        ]);

        $pembayaran->update($data);

        return redirect()->route('pembayaran.data')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    /**
     * Menghapus data transaksi pembayaran beserta rinciannya (agar dapat diproses ulang).
     */
    public function pembayaran_hapus(Pembayaran $pembayaran): RedirectResponse
    {
        $pembayaran->detailPembayaran()->delete();
        $pembayaran->delete();

        return redirect()->route('pembayaran.data')->with('success', 'Pembayaran berhasil dihapus.');
    }

    /**
     * Mencetak kuitansi/struk pembayaran.
     */
    public function pembayaran_cetak(Pembayaran $pembayaran): View
    {
        $pembayaran->load(['pendaftaran.pasien', 'detailPembayaran']);

        return view('pembayaran.cetak_struk', compact('pembayaran'));
    }
}