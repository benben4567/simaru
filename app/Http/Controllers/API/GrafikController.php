<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    public function dashboard()
    {
        # code...
    }

    public function rekap()
    {
        $periode = Periode::where('status', 'buka')->first()->id;
        $bayar_pendaftaran = DB::table('pendaftar')->select('bayar_pendaftaran', DB::raw('COUNT(*) as jumlah'))
            ->where('periode_id', $periode)
            ->groupBy('bayar_pendaftaran')
            ->get()->toArray();

        $bayar_ukt = DB::table('maba')->select('pembayaran', DB::raw('COUNT(*) as jumlah'))
            ->where('periode_id', $periode)
            ->whereNotNull('prodi_lulus')
            ->groupBy('pembayaran')
            ->get()->toArray();

        $gelombang = DB::table('pendaftar')->select('gelombang', DB::raw('COUNT(*) as jumlah'))
            ->where('periode_id', $periode)
            ->groupBy('gelombang')
            ->get()->toArray();

        $jalur_pendaftaran = DB::table('pendaftar')->select('jalur', DB::raw('COUNT(*) as jumlah'))
            ->where('periode_id', $periode)
            ->groupBy('jalur')
            ->get()->toArray();

        $prodi_lulus = DB::table('maba')->select('prodi_lulus', DB::raw('COUNT(*) as jumlah'))
            ->where('periode_id', $periode)
            ->where('prodi_lulus', "!=", null)
            ->groupBy('prodi_lulus')
            ->get()->toArray();

        $prodi_1 = DB::table('pendaftar')->select('prodi_1', DB::raw('COUNT(*) as jumlah'))
            ->where('periode_id', $periode)
            ->groupBy('prodi_1')
            ->get()->toArray();

        $prodi_2 = DB::table('pendaftar')->select('prodi_2', DB::raw('COUNT(*) as jumlah'))
            ->where('periode_id', $periode)
            ->groupBy('prodi_2')
            ->get()->toArray();

        $pendaftaran = [];
        foreach ($bayar_pendaftaran as $byr) {
            if ($byr->bayar_pendaftaran == "sudah") {
                $pendaftaran['sudah'] = $byr->jumlah;
            } else {
                $pendaftaran['belum'] = $byr->jumlah;
            }
        }

        $ukt = [];
        foreach ($bayar_ukt as $byr) {
            ($byr->pembayaran == null ? $ukt['belum'] = $byr->jumlah : $ukt[$byr->pembayaran] = $byr->jumlah);
        }

        $gel = [];
        foreach ($gelombang as $g) {
            $gel['gel' . $g->gelombang] = $g->jumlah;
        }

        $data = [
            'pendaftaran' => $pendaftaran,
            'ukt' => $ukt,
            'gelombang' => $gel,
            'jalur_pendaftaran' => $jalur_pendaftaran,
            'lulus' => $prodi_lulus,
            'prodi1' => $prodi_1,
            'prodi2' => $prodi_2,
        ];

        return ResponseFormatter::success($data, 'Data grafik');
    }
}
