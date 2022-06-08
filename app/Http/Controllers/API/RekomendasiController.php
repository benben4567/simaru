<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Maba;
use App\Models\Periode;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    public function internal(Request $request)
    {
        $status = $request->status;
        $periode = Periode::where('status', 'buka')->first();

        if ($status == 'Selesai') {
            $maba = Maba::select('no_pendaftaran', 'nama')
                ->where('periode_id', $periode->id)
                ->where('rekomendasi', 'internal')
                ->whereNotNull('tgl_pencairan')
                ->orderBy('nama', 'ASC')
                ->get();
        } elseif ($status == 'Proses') {
            $maba = Maba::select('no_pendaftaran', 'nama')
                ->where('periode_id', $periode->id)
                ->where('rekomendasi', 'internal')
                ->whereNotNull('tgl_pembayaran')
                ->whereNotNull('tgl_pengajuan')
                ->whereNull('tgl_pencairan')
                ->orderBy('nama', 'ASC')
                ->get();
        } else {
            $maba = Maba::select('no_pendaftaran', 'nama')
                ->where('periode_id', $periode->id)
                ->where('rekomendasi', 'internal')
                ->whereNotNull('pembayaran')
                ->whereNull('tgl_pengajuan')
                ->orderBy('nama', 'ASC')
                ->get();
        }

        return ResponseFormatter::success($maba, 'Data rekom mahasiswa baru');
    }

    public function eksternal(Request $request)
    {
        $status = $request->status;
        $periode = Periode::where('status', 'buka')->first();

        if ($status == 'Selesai') {
            $maba = Maba::select('no_pendaftaran', 'nama')
                ->where('periode_id', $periode->id)
                ->where('rekomendasi', 'eksternal')
                ->whereNotNull('tgl_pencairan')
                ->orderBy('nama', 'ASC')
                ->get();
        } elseif ($status == 'Proses') {
            $maba = Maba::select('no_pendaftaran', 'nama')
                ->where('periode_id', $periode->id)
                ->where('rekomendasi', 'eksternal')
                ->whereNotNull('tgl_pembayaran')
                ->whereNotNull('tgl_pengajuan')
                ->whereNull('tgl_pencairan')
                ->orderBy('nama', 'ASC')
                ->get();
        } else {
            $maba = Maba::select('no_pendaftaran', 'nama')
                ->where('periode_id', $periode->id)
                ->where('rekomendasi', 'eksternal')
                ->whereNotNull('pembayaran')
                ->whereNull('tgl_pengajuan')
                ->orderBy('nama', 'ASC')
                ->get();
        }

        return ResponseFormatter::success($maba, 'Data rekom mahasiswa baru');
    }
}
