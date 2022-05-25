<?php

namespace App\Http\Controllers;

use App\Helpers\Logger;
use App\Helpers\ResponseFormatter;
use App\Models\Pendaftar;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;

class PendaftarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $periode = Periode::where('status', 'buka')->first();
            $maba = Pendaftar::select('no_pendaftaran', 'nama', 'jalur', 'gelombang', 'bayar_pendaftaran')
                ->where('periode_id', $periode->id)
                ->get();
            return ResponseFormatter::success($maba, "Data Pendaftar");
        }

        return view('pages.pendaftar');
    }

    public function store(Request $request)
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

            // truncate
            DB::table('pendaftar')->truncate();

            // Import
            $periode = Periode::where('status', 'buka')->first();
            $collection = (new FastExcel)->sheet(1)->import(storage_path('app/' . $path), function ($line) use ($periode) {
                return $periode->pendaftar()->create([
                    'no_pendaftaran' => $line['no_pendaftaran'],
                    'nama' => $line['nama'],
                    'prodi_1' => $line['prodi_1'],
                    'prodi_2' => $line['prodi_2'],
                    'gelombang' => $line['gelombang'],
                    'bayar_pendaftaran' => $line['bayar_pendaftaran'],
                    'jalur' => $line['jalur'],
                    'password' => $line['password'],
                ]);
            });

            return ResponseFormatter::success($collection, count($collection) . " Data Berhasil Diimport", 201);

            // get last no_pendaftaran
            // update current data by no_pendaftaran
            // remove record from collection if no_pendaftaran <= last
            // remove duplicate in collection // $unique = $collection->unique('nama');
            // store unique row to database

        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
