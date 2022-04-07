<?php

namespace App\Http\Controllers;

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
            $maba = Maba::select('no_pendaftaran', 'nama', 'jalur_pendaftaran', 'gelombang', 'tgl_validasi')
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
            if ($request->file('file')) {
                $file = $request->file('file');
                $ext = $file->getClientOriginalExtension();
                $filename = $request->rekomendasi."_surat_rekom_".$request->no.".".$ext;
                $path = Storage::putFileAs('public/rekomendasi', $request->file('file'), $filename);
            } else {
                $path = null;
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
                "file_rekom" => $path,
                "tgl_validasi" => now()
            ]);

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
