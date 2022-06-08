<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Maba;
use App\Models\Periode;
use Illuminate\Http\Request;

class NimController extends Controller
{
    public function index()
    {
        $periode = Periode::where('status', 'buka')->first();

        $data = [];
        for ($i = 1; $i <= 4; $i++) {
            $maba = Maba::select('no_pendaftaran', 'nama', 'gelombang', 'nim')
                ->where('periode_id', $periode->id)
                ->where('pembayaran', 'lunas')
                ->where('gelombang', $i)
                ->orderBy('nim', 'ASC')
                ->get();
            $data['gelombang_' . $i] = $maba;
        }

        return ResponseFormatter::success($data, 'Data NIM');
    }
}
