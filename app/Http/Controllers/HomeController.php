<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Maba;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $validasi = Maba::count();
        $lolos = Maba::whereNotNull('prodi_lulus')->count();
        $internal = Maba::where('rekomendasi', 'internal')->count();
        $eksternal = Maba::where('rekomendasi', 'eksternal')->count();

        // Rekom
        $in_belum = Maba::where('rekomendasi', 'internal')->whereNotNull('pembayaran')->whereNull('tgl_pengajuan')->count();
        $in_proses = Maba::where('rekomendasi', 'internal')->whereNotNull('pembayaran')->whereNotNull('tgl_pengajuan')->whereNull('tgl_pencairan')->count();
        $in_selesai = Maba::where('rekomendasi', 'internal')->whereNotNull('tgl_pencairan')->whereNotNull('jenis_pencairan')->count();

        $ek_belum = Maba::where('rekomendasi', 'eksternal')->whereNotNull('pembayaran')->whereNull('tgl_pengajuan')->count();
        $ek_proses = Maba::where('rekomendasi', 'eksternal')->whereNotNull('pembayaran')->whereNotNull('tgl_pengajuan')->whereNull('tgl_pencairan')->count();
        $ek_selesai = Maba::where('rekomendasi', 'eksternal')->whereNotNull('tgl_pencairan')->whereNotNull('jenis_pencairan')->count();

        // NIM

        $nim_belum = Maba::where('pembayaran', 'lunas')->whereNull('nim')->count();
        $nim_sudah = Maba::where('pembayaran', 'lunas')->whereNotNull('nim')->count();

        // Pembayaran

        $belum = Maba::whereNotNull('prodi_lulus')->whereNull('pembayaran')->count();
        $setengah = Maba::whereNotNull('prodi_lulus')->where('pembayaran', 'setengah')->count();
        $lunas = Maba::whereNotNull('prodi_lulus')->where('pembayaran', 'lunas')->count();

        $dashboard = [
            'validasi' => $validasi,
            'lolos' => $lolos,
            'internal' => $internal,
            'eksternal' => $eksternal,
            'in_belum' => $in_belum,
            'in_proses' => $in_proses,
            'in_selesai' => $in_selesai,
            'ek_belum' => $ek_belum,
            'ek_proses' => $ek_proses,
            'ek_proses' => $ek_proses,
            'ek_selesai' => $ek_selesai,
            'nim_belum' => $nim_belum,
            'nim_sudah' => $nim_sudah,
            'belum' => $belum,
            'setengah' => $setengah,
            'lunas' => $lunas,
        ];

        return view('pages.dashboard', compact('dashboard'));
    }

    public function chart()
    {
        $maba = DB::table('maba')->selectRaw('gelombang, count(*) AS jumlah')->groupBy('gelombang')->get()->toArray();
        $prodi = DB::table('maba')->selectRaw('prodi_lulus, count(*) AS jumlah')->whereNotNull('prodi_lulus')->groupBy('prodi_lulus')->get()->toArray();

        $label = Arr::pluck($prodi, 'prodi_lulus');
        $value = Arr::pluck($prodi, 'jumlah');

        $data = [
            'area' => Arr::pluck($maba, 'jumlah'),
            'pie_label' => $label,
            'pie_value' => $value,
        ];

        return ResponseFormatter::success($data, 'Data Chart');
    }
}
