<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Maba;
use App\Models\Periode;
use Illuminate\Http\Request;

class ValidasiController extends Controller
{
    public function index()
    {
        $periode = Periode::where('status', 'buka')->first();
        $data = [];
        for ($i = 1; $i <= 4; $i++) {
            $maba = Maba::select('no_pendaftaran', 'nama', 'gelombang')
                ->where('periode_id', $periode->id)
                ->where('gelombang', $i)
                ->orderBy('no_pendaftaran')
                ->get();
            $data['gelombang_' . $i] = $maba;
        }

        return ResponseFormatter::success($data, 'Data Validasi');
    }

    public function show($id)
    {
        $maba = Maba::where('no_pendaftaran', $id)->first();

        if ($maba) {
            return ResponseFormatter::success($maba, 'Data Pendaftar ditemukan');
        } else {
            return ResponseFormatter::error(null, 'Data Pendaftarn tidak ditemukan', 404);
        }
    }

    public function search(Request $request)
    {
        $substr = substr($request->input('query'), 1);

        $periode = Periode::where('status', 'buka')->first();

        if ($substr == '9') {
            $no = (int) $request->input('query');
            $maba = Maba::select('no_pendaftaran', 'nama', 'gelombang')
                ->where('periode_id', $periode->id)
                ->where('no_pendaftaran', $no)
                ->orderBy('no_pendaftaran')
                ->get();

            if ($maba) {
                return ResponseFormatter::success($maba, 'Data ditemukan');
            } else {
                return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
            }
        } else {
            $keyword = $request->input('query');
            $maba = Maba::select('no_pendaftaran', 'nama', 'gelombang')
                ->where('periode_id', $periode->id)
                ->where('name', 'like', "%{$keyword}%")
                ->orderBy('no_pendaftaran')
                ->get();

            if ($maba) {
                return ResponseFormatter::success($maba, 'Data ditemukan');
            } else {
                return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
            }
        }
    }
}
