<?php

namespace App\Http\Controllers;

use App\Helpers\Logger;
use App\Helpers\ResponseFormatter;
use App\Models\Maba;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RekomendasiController extends Controller
{
    public function internal(Request $request)
    {
        $jenis = "Internal";
        if($request->ajax()) {
            $periode = Periode::where('status', 'buka')->first();
            $maba = Maba::select('no_pendaftaran', 'nama', 'nama_perekom', 'telp_perekom', 'tgl_pengajuan', 'tgl_pencairan', 'jenis_pencairan', 'file_rekom')
                        ->where('periode_id', $periode->id)
                        ->where('rekomendasi','internal')
                        ->whereNotNull('pembayaran')
                        ->get();

            return ResponseFormatter::success($maba, "Data Maba");
        }
        return view('pages.rekomendasi', compact('jenis'));
    }

    public function eksternal(Request $request)
    {
        $jenis = "Eksternal";

        if($request->ajax()) {
            $periode = Periode::where('status', 'buka')->first();
            $maba = Maba::select('no_pendaftaran', 'nama', 'nama_perekom', 'telp_perekom', 'tgl_pengajuan', 'tgl_pencairan', 'jenis_pencairan', 'file_rekom')
                        ->where('periode_id', $periode->id)
                        ->where('rekomendasi','eksternal')
                        ->whereNotNull('pembayaran')
                        ->get();

            return ResponseFormatter::success($maba, "Data Maba");
        }
        return view('pages.rekomendasi', compact('jenis'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "no" => 'required',
            "tgl_pengajuan" => 'required',
            "tgl_pencairan" => 'nullable',
            "jenis" => 'nullable',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {

            $maba = Maba::where("no_pendaftaran", $request->no)->first();
            $maba->update([
                "tgl_pengajuan" => $request->tgl_pengajuan,
                "tgl_pencairan" => $request->tgl_pencairan,
                "jenis_pencairan" => $request->jenis,
            ]);

            Logger::info($maba, 'updating rekomendasi');

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            Logger::error($maba, $e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
