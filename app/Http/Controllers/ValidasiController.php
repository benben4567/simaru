<?php

namespace App\Http\Controllers;

use App\Helpers\Logger;
use App\Helpers\ResponseFormatter;
use App\Models\Maba;
use App\Models\Periode;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ValidasiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $periode = Periode::where('status', 'buka')->first();
            $maba = Maba::select('no_pendaftaran', 'nama', 'jalur_pendaftaran', 'gelombang', 'tgl_validasi', 'prodi_lulus')
                    ->where('periode_id', $periode->id)
                    ->get();
            return ResponseFormatter::success($maba, "Data User");
        }

        $prodi = Prodi::all();
        return view('pages.validasi', compact('prodi'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "no" => 'required',
            "nama" => 'required',
            "nohp" => 'required',
            "prodi_1" => 'required',
            "prodi_2" => 'required',
            "jalur" => 'required',
            "gelombang" => 'required',
            "rekomendasi" => 'nullable',
            "nama_perekom" => 'nullable',
            "nohp_perekom" => 'nullable',
            "file" => 'nullable|mimes:pdf',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {
            // check if maba is exist
            $maba = Maba::where('no_pendaftaran', $request->no)->count();
            if ($maba) {
                return ResponseFormatter::error(null, "Data maba sudah ada", 409);
            }

            // check if file is exist
            if ($request->file('file')) {
                $file = $request->file('file');
                $ext = $file->getClientOriginalExtension();
                $filename = $request->rekomendasi."_surat_rekom_".$request->no.".".$ext;
                $path = Storage::putFileAs('public/rekomendasi', $request->file('file'), $filename);
            } else {
                $filename = null;
            }

            $periode = Periode::where('status', 'buka')->first();

            $maba = $periode->maba()->create([
                "no_pendaftaran" => $request->no,
                "nama" => strtoupper($request->nama),
                "telp" => $request->nohp,
                "prodi_1" => $request->prodi_1,
                "prodi_2" => $request->prodi_2,
                "jalur_pendaftaran" => $request->jalur,
                "gelombang" => $request->gelombang,
                "rekomendasi" => $request->rekomendasi,
                "nama_perekom" => $request->nama_perekom,
                "telp_perekom" => $request->nohp_perekom,
                "file_rekom" => $filename,
                "tgl_validasi" => now()
            ]);

            Logger::info($maba, 'created');

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            Logger::error($maba, $e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }

    public function show(Request $request)
    {
        $maba = Maba::select('id', 'no_pendaftaran', 'nama', 'telp', 'prodi_1', 'prodi_2', 'jalur_pendaftaran', 'gelombang', 'rekomendasi', 'nama_perekom', 'telp_perekom')
                    ->where('no_pendaftaran', $request->no)
                    ->first();

        if ($maba) {
            return ResponseFormatter::success($maba, "Data Maba");
        }

        return ResponseFormatter::error(null, "Data tidak ditemukan", 404);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "no_pendaftaran" => 'required',
            "nama" => 'required',
            "telp" => 'required',
            "prodi_1" => 'required',
            "prodi_2" => 'required',
            "jalur_pendaftaran" => 'required',
            "gelombang" => 'required',
            "rekomendasi" => 'nullable',
            "nama_perekom" => 'nullable',
            "telp_perekom" => 'nullable',
            "file" => 'nullable|mimes:pdf',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {
            // check if file is exist
            if ($request->file('file')) {
                $file = $request->file('file');
                $ext = $file->getClientOriginalExtension();
                $filename = $request->rekomendasi."_surat_rekom_".$request->no_pendaftaran.".".$ext;
                $path = Storage::putFileAs('public/rekomendasi', $request->file('file'), $filename);
            } else {
                $filename = null;
            }
            $maba = Maba::find($request->id);
            $update = $maba->update([
                "no_pendaftaran" => $request->no_pendaftaran,
                "nama" => strtoupper($request->nama),
                "telp" => $request->telp,
                "prodi_1" => $request->prodi_1,
                "prodi_2" => $request->prodi_2,
                "jalur_pendaftaran" => $request->jalur_pendaftaran,
                "gelombang" => $request->gelombang,
                "rekomendasi" => $request->rekomendasi,
                "nama_perekom" => $request->nama_perekom,
                "telp_perekom" => $request->telp_perekom,
                "file_rekom" => $filename,
            ]);

            Logger::info($maba, 'created');

            return ResponseFormatter::success($update, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            Logger::error($maba, $e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
