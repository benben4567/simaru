<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Maba;
use App\Models\Periode;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $pembayaran = $request->pembayaran;
        $periode = Periode::where('status', 'buka')->first();
        if ($pembayaran == 'Lunas') {
            $maba = Maba::select('no_pendaftaran', 'nama')
                ->where('periode_id', $periode->id)
                ->whereNotNull('prodi_lulus')
                ->where('pembayaran', 'lunas')
                ->orderBy('nama', 'ASC')
                ->get();
        } elseif ($pembayaran == 'Setengah') {
            $maba = Maba::select('no_pendaftaran', 'nama')
                ->where('periode_id', $periode->id)
                ->whereNotNull('prodi_lulus')
                ->where('pembayaran', 'setengah')
                ->orderBy('nama', 'ASC')
                ->get();
        } else {
            $maba = Maba::select('no_pendaftaran', 'nama')
                ->where('periode_id', $periode->id)
                ->whereNotNull('prodi_lulus')
                ->whereNull('pembayaran')
                ->orderBy('nama', 'ASC')
                ->get();
        }

        return ResponseFormatter::success($maba, 'Data pembayaran mahasiswa baru');
    }
}
