<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $prodi = Prodi::all();
            return ResponseFormatter::success($prodi, "Data Program Studi");
        }

        return view('pages.prodi');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {
            $prodi = Prodi::create([
                "name" => $request->nama,
            ]);

            return ResponseFormatter::success($prodi, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {
            $prodi = Prodi::whereId($request->id)->update([
                "name" => $request->nama,
            ]);

            return ResponseFormatter::success($prodi, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
