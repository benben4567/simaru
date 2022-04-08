<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Maba;
use App\Models\Periode;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LolosController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $periode = Periode::where('status', 'buka')->first();
            $maba = Maba::select('no_pendaftaran', 'nama', 'prodi_lulus', 'tgl_lulus')->where('periode_id', $periode->id)->whereNotNull('prodi_lulus')->get();
            return ResponseFormatter::success($maba, "Data User");
        }

        $prodi = Prodi::all();
        return view('pages.lolos', compact('prodi'));
    }

    public function show($no_pendaftaran)
    {
        $maba = Maba::select('id', 'nama', 'prodi_lulus', 'nilai', 'tgl_pendaftaran')->where('no_pendaftaran', $no_pendaftaran)->first();

        if ($maba) {

            if ($maba->prodi_lulus) {
                return ResponseFormatter::error($maba, "Data sudah ada", 409);
            }

            return ResponseFormatter::success($maba, "Data Maba");
        }

        return ResponseFormatter::error(null, "Data tidak ditemukan", 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "no" => 'required',
            "prodi_lolos" => 'required',
            "nilai" => 'required',
            "tgl_daftar" => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {

            $maba = Maba::where("no_pendaftaran", $request->no)->update([
                "prodi_lulus" => $request->prodi_lolos,
                "nilai" => $request->nilai,
                "tgl_pendaftaran" => $request->tgl_daftar,
                "tgl_lulus" => now()
            ]);

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }

    public function edit($no_pendaftaran)
    {
        $maba = Maba::select('no_pendaftaran', 'nama', 'prodi_lulus', 'nilai', 'tgl_pendaftaran')->where('no_pendaftaran', $no_pendaftaran)->first();

        if ($maba) {
            return ResponseFormatter::success($maba, "Data Maba");
        }

        return ResponseFormatter::error(null, "Data tidak ditemukan", 404);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "no" => 'required',
            "prodi_lolos" => 'required',
            "nilai" => 'required',
            "tgl_daftar" => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {

            $maba = Maba::where("no_pendaftaran", $request->no)->update([
                "prodi_lulus" => $request->prodi_lolos,
                "nilai" => $request->nilai,
                "tgl_pendaftaran" => $request->tgl_daftar,
            ]);

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
