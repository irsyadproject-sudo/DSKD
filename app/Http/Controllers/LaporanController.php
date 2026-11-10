<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * Mencetak laporan aktivitas klinik (periode/kategori).
     * Tanpa parameter cetak -> halaman filter & hasil; dengan cetak=1 -> layout print.
     */
    public function laporan_cetak(Request $request): View
    {
        $data = $this->proses($request);

        if ($request->query('cetak') === '1') {
            return view('laporan.cetak_laporan', $data);
        }

        return view('laporan.index', $data);
    }

    /**
     * Proses filter & kumpulkan data laporan sesuai jenis.
     */
    private function proses(Request $request): array
    {
        $jenis = $request->query('jenis', 'pasien');
        $dari = $request->query('dari');
        $sampai = $request->query('sampai');

        $rows = collect();

        switch ($jenis) {
            case 'pembayaran':
            case 'transaksi':
                $query = Pembayaran::with('pendaftaran.pasien');
                $this->filterPeriode($query, 'tanggal_bayar', $dari, $sampai);
                $rows = $query->get();
                $jenis = 'pembayaran';
                break;

            case 'obat':
                $rows = Obat::with('detailResep')->get();
                break;

            case 'pendaftaran':
                $query = Pendaftaran::with(['pasien', 'jadwalDokter.dokter']);
                $this->filterPeriode($query, 'tanggal_daftar', $dari, $sampai);
                $rows = $query->get();
                break;

            case 'antrean':
                $query = Antrian::with(['pendaftaran.pasien', 'pendaftaran.jadwalDokter.dokter']);
                $this->filterPeriode($query, 'tanggal', $dari, $sampai);
                $rows = $query->get();
                break;

            case 'rekam_medis':
                $query = Pemeriksaan::with(['pasien', 'dokter', 'pemeriksaanTindakan.tindakan', 'resep.detailResep.obat']);
                $this->filterPeriode($query, 'tanggal_periksa', $dari, $sampai);
                $rows = $query->get();
                break;

            case 'pemeriksaan':
                $query = Pemeriksaan::with(['pasien', 'dokter']);
                $this->filterPeriode($query, 'tanggal_periksa', $dari, $sampai);
                $rows = $query->get();
                break;

            case 'dokter':
                $rows = Dokter::all();
                break;

            case 'pasien':
            default:
                $rows = Pasien::latest()->get();
                break;
        }

        return compact('jenis', 'dari', 'sampai', 'rows');
    }

    /**
     * Filter query berdasarkan periode tanggal.
     */
    private function filterPeriode(Builder $query, string $kolom, ?string $dari, ?string $sampai): void
    {
        if ($dari) {
            $query->whereDate($kolom, '>=', $dari);
        }

        if ($sampai) {
            $query->whereDate($kolom, '<=', $sampai);
        }
    }
}