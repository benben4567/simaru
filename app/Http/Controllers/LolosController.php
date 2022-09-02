<?php

namespace App\Http\Controllers;

use App\Helpers\Logger;
use App\Helpers\ResponseFormatter;
use App\Models\Maba;
use App\Models\Periode;
use App\Models\Prodi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;

class LolosController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $periode = Periode::where('status', 'buka')->first();
            $maba = Maba::select('no_pendaftaran', 'nama', 'telp', 'prodi_lulus', 'tgl_lulus')->where('periode_id', $periode->id)->whereNotNull('prodi_lulus')->get();
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

            $maba = Maba::where("no_pendaftaran", $request->no)->first();
            $maba->update([
                "prodi_lulus" => $request->prodi_lolos,
                "nilai" => $request->nilai,
                "tgl_pendaftaran" => $request->tgl_daftar,
                "tgl_lulus" => now()
            ]);

            Logger::info($maba, 'updated to lolos');

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            Logger::error($maba, $e->getMessage());
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

            $maba = Maba::where("no_pendaftaran", $request->no)->first();
            $maba->update([
                "prodi_lulus" => $request->prodi_lolos,
                "nilai" => $request->nilai,
                "tgl_pendaftaran" => $request->tgl_daftar,
            ]);
            Logger::info($maba, 'updating lolos');

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {

            Logger::error($maba, $e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'file|required|mimes:xlsx'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Inputan tidak valid', 422);
        }

        try {
            // Uploadfile
            $path = $request->file('file')->store('excel');

            // Import
            $collection = (new FastExcel)->sheet(1)->import(storage_path('app/' . $path), function ($line) {
                return Maba::where("no_pendaftaran", intval(trim($line['no_pendaftaran'])))->update([
                    "prodi_lulus" => $line['prodi_lulus'],
                    "nilai" => intval($line['nilai']),
                    "tgl_pendaftaran" => Carbon::parse($line['tgl_pendaftaran'])->format('Y-m-d'),
                    "tgl_lulus" => now()
                ]);
            });

            return ResponseFormatter::success($collection, "Data Berhasil Diimport", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }

    public function chunkExport()
    {
        $data = Maba::cursor()->filter(function ($maba) {
            return $maba->prodi_lulus != null;
        });

        foreach ($data as $maba) {
            $temp = [
                'No Pendaftaran' => $maba->no_pendaftaran,
                'Nama' => $maba->nama,
                'Peodi Lolos' => $maba->prodi_lulus,
                'Jalur Pendaftaran' => $maba->jalur_pendaftaran,
                'Gelombang' => $maba->gelombang,
                'Tgl Lolos' => $maba->tgl_lulus
            ];
            yield $temp;
        }
    }

    public function export()
    {
        $filename = 'simaru_lolos_' . date('dmY') . ".xlsx";

        return (new FastExcel($this->chunkExport()))->download($filename);
    }
}
