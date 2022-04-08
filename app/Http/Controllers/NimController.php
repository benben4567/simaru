<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Maba;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NimController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $periode = Periode::where('status', 'buka')->first();
            $maba = Maba::select('no_pendaftaran', 'nama', 'prodi_lulus', 'gelombang', 'jalur_pendaftaran', 'nim', 'tgl_nim')
                    ->where('periode_id', $periode->id)
                    ->where('pembayaran', 'lunas')
                    ->get();
            return ResponseFormatter::success($maba, "Data Maba");
        }
        return view('pages.nim');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "no" => 'required',
            "nim" => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {

            $maba = Maba::where("no_pendaftaran", $request->no)->update([
                "nim" => $request->nim,
                "tgl_nim" => now()
            ]);

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
