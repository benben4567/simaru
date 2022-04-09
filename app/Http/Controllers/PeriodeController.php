<?php

namespace App\Http\Controllers;

use App\Helpers\Logger;
use App\Helpers\ResponseFormatter;
use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $prodi = Periode::all();
            return ResponseFormatter::success($prodi, "Data Program Studi");
        }

        $tahun = Periode::orderBy('tahun', 'desc')->first()->value('tahun');
        return view('pages.periode', compact('tahun'));
    }

    public function store(Request $request)
    {
        try {
            $periode = Periode::create([
                "tahun" => $request->tahun,
                "status" => 'tutup'
            ]);

            return ResponseFormatter::success($periode, "Data berhasil disimpan");

        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), "Terjadi kesalahan di server", 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $periode = Periode::all();

            if (count($periode) == 1) {
                return ResponseFormatter::success($periode, "Periode ini tidak bisa ditutup");
            }

            if ($request->status == 'buka') {
                Periode::query()->update(['status' => 'tutup']);
                $periode = Periode::find($request->id);
                $periode->update(['status' => 'buka']);

                Logger::info($periode, 'updated');

                return ResponseFormatter::success($periode, "Periode");
            } else {
                return ResponseFormatter::success($periode, "Periode");
            }
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), "Terjadi kesalahan di server", 500);
        }
    }
}
