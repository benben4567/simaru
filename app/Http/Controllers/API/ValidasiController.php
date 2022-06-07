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
}
