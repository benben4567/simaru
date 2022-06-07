<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Maba;
use App\Models\Periode;
use Illuminate\Http\Request;

class LolosController extends Controller
{
    public function index(Request $request)
    {
        $prodi = $request->prodi;
        $periode = Periode::where('status', 'buka')->first();
        if ($prodi) {
            $maba = Maba::select('no_pendaftaran', 'nama')
                ->where('periode_id', $periode->id)
                ->where('prodi_lulus', $prodi)
                ->orderBy('nama', 'ASC')
                ->get();
        } else {
            $maba = Maba::select('no_pendaftaran', 'nama')
                ->where('periode_id', $periode->id)
                ->orderBy('nama', 'ASC')
                ->get();
        }

        return ResponseFormatter::success($maba, 'Data pendaftar lolos seleksi');
    }
}
