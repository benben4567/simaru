<?php

namespace App\Http\Controllers;

use App\Helpers\Logger;
use App\Helpers\ResponseFormatter;
use App\Models\Maba;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $periode = Periode::where('status', 'buka')->first();
            $maba = Maba::select('no_pendaftaran', 'nama', 'prodi_lulus', 'pembayaran', 'tgl_pembayaran')->where('periode_id', $periode->id)->whereNotNull('prodi_lulus')->get();
            return ResponseFormatter::success($maba, "Data Maba");
        }
        return view('pages.pembayaran');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "no" => 'required',
            "pembayaran" => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {

            $maba = Maba::where("no_pendaftaran", $request->no)->first();
            $maba->update([
                "pembayaran" => $request->pembayaran,
                "tgl_pembayaran" => now()
            ]);

            Logger::info($maba, 'updating pembayaran');

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            Logger::error($maba, $e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
