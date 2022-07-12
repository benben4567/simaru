<?php

namespace App\Http\Controllers\API;

use App\Helpers\Logger;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Maba;
use App\Models\Periode;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidasiController extends Controller
{
    public function index()
    {
        $periode = Periode::where('status', 'buka')->first();
        $data = [];
        for ($i = 1; $i <= 4; $i++) {
            $maba = Maba::select('no_pendaftaran', 'nama', 'gelombang')
                ->where('periode_id', $periode->id)
                ->where('gelombang', $i)
                ->orderBy('no_pendaftaran')
                ->get();
            $data['gelombang_' . $i] = $maba;
        }

        return ResponseFormatter::success($data, 'Data Validasi');
    }

    public function show($id)
    {
        $maba = Maba::where('no_pendaftaran', $id)->first();

        if ($maba) {
            return ResponseFormatter::success($maba, 'Data Pendaftar ditemukan');
        } else {
            return ResponseFormatter::error(null, 'Data Pendaftarn tidak ditemukan', 404);
        }
    }

    public function search(Request $request)
    {
        $substr = substr($request->input('query'), 0, 1);

        $periode = Periode::where('status', 'buka')->first();

        if ($substr == '9') {
            $no = (int) $request->input('query');
            $maba = Maba::select('no_pendaftaran', 'nama', 'gelombang')
                ->where('periode_id', $periode->id)
                ->where('no_pendaftaran', $no)
                ->orderBy('no_pendaftaran')
                ->get();

            if ($maba) {
                return ResponseFormatter::success($maba, 'Data ditemukan');
            } else {
                return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
            }
        } else {
            $keyword = $request->input('query');
            $maba = Maba::select('no_pendaftaran', 'nama', 'gelombang')
                ->where('periode_id', $periode->id)
                ->where('nama', 'LIKE', "%{$keyword}%")
                ->orderBy('no_pendaftaran')
                ->get();

            if ($maba) {
                return ResponseFormatter::success($maba, 'Data ditemukan');
            } else {
                return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
            }
        }
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
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {
            $periode = Periode::where('status', 'buka')->first();

            $prodi_1 = Prodi::where('kode', $request->input('prodi_1'))->first();
            $prodi_2 = Prodi::where('kode', $request->input('prodi_2'))->first();

            switch ($request->input('jalur')) {
                case 'UMUM':
                    $jalur = 'REGULER';
                    break;
                case 'R2/KARYAWAN':
                    $jalur = 'REGSUS';
                    break;
                default:
                    $jalur = $request->input('jalur');
                    break;
            }

            // update or create
            $maba = $periode->maba()->updateOrCreate(
                ['no_pendaftaran' => $request->input('no')],
                [
                    'nama' => strtoupper($request->input('nama')),
                    'telp' => $request->input('nohp'),
                    'prodi_1' => $prodi_1->name,
                    'prodi_2' => $prodi_2->name,
                    'jalur_pendaftaran' => $jalur,
                    'gelombang' => $request->input('gelombang'),
                    'rekomendasi' => $request->input('rekomendasi'),
                    'nama_perekom' => $request->input('nama_perekom'),
                    'telp_perekom' => $request->input('nohp_perekom'),
                    "tgl_validasi" => now()
                ]
            );

            // Logger::info($maba, 'created automatically from Siakad');

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            Logger::error($maba, $e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
