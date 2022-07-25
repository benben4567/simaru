<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class GrafikController extends Controller
{
    public function index()
    {
        return abort(404);

        $periode = Periode::where('status', 'buka')->first()->value('tahun');
        return view('pages.grafik', compact('periode'));
    }

    public function rekap()
    {
        return abort(404);

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

        $pendaftaran = Arr::pluck($bayar_pendaftaran, 'jumlah'); //belum, sudah
        $ukt = Arr::pluck($bayar_ukt, 'jumlah'); //null, lunas, setengah
        $gel = Arr::pluck($gelombang, 'jumlah'); //null, lunas, setengah
        $jalur = Arr::pluck($jalur_pendaftaran, 'jumlah'); //null, lunas, setengah
        $namajalur = Arr::pluck($jalur_pendaftaran, 'jalur'); //null, lunas, setengah
        $prodi = Arr::pluck($prodi_lulus, 'jumlah'); //null, lunas, setengah
        $namaprodi = Arr::pluck($prodi_lulus, 'prodi_lulus'); //null, lunas, setengah
        $prodi1 = Arr::pluck($prodi_1, 'jumlah'); //null, lunas, setengah
        $namaprodi1 = Arr::pluck($prodi_1, 'prodi_1'); //null, lunas, setengah
        $prodi2 = Arr::pluck($prodi_2, 'jumlah'); //null, lunas, setengah
        $namaprodi2 = Arr::pluck($prodi_2, 'prodi_2'); //null, lunas, setengah

        $data = [
            'pendaftaran' => $pendaftaran,
            'ukt' => $ukt,
            'gel' => $gel,
            'namajalur' => $namajalur,
            'jalur' => $jalur,
            'namaprodi' => $namaprodi,
            'prodi' => $prodi,
            'namaprodi1' => $namaprodi1,
            'prodi1' => $prodi1,
            'namaprodi2' => $namaprodi2,
            'prodi2' => $prodi2,
        ];

        return ResponseFormatter::success($data, 'Data grafik');
    }

    public function export()
    {
        return abort(404);

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

        $sheets = new SheetCollection([
            'bayar_pendaftaran' => $bayar_pendaftaran,
            'bayar_ukt' => $bayar_ukt,
            'gelombang' => $gelombang,
            'jalur_pendaftaran' => $jalur_pendaftaran,
            'masuk_prodi' => $prodi_lulus,
            'prodi_pilihan_1' => $prodi_1,
            'prodi_pilihan_2' => $prodi_2
        ]);

        $filename = 'export_simaru_' . date('dmY') . '.xlsx';

        (new FastExcel($sheets))->export('storage/export/' . $filename);

        $filePath = public_path("storage/export/" . $filename);

        $headers = ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        return response()->download($filePath, $filename, $headers);
    }
}
