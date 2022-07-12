<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Maba;
use App\Models\Periode;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "no" => 'required',
            "prodi_lolos" => 'required',
            "nilai" => 'nullable',
            "tgl_daftar" => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {

            $prodi_lolos = Prodi::where('kode', $request->input('prodi_lolos'))->first();

            $maba = Maba::where("no_pendaftaran", $request->no)->first();
            $maba->update([
                "prodi_lulus" => $prodi_lolos->name,
                "nilai" => $request->nilai,
                "tgl_pendaftaran" => $request->tgl_daftar,
                "tgl_lulus" => now()
            ]);

            // Logger::info($maba, 'updated to lolos');

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            Logger::error($maba, $e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
