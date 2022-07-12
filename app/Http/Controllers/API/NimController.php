<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Maba;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NimController extends Controller
{
    public function index()
    {
        $periode = Periode::where('status', 'buka')->first();

        $data = [];
        for ($i = 1; $i <= 4; $i++) {
            $maba = Maba::select('no_pendaftaran', 'nama', 'gelombang', 'nim')
                ->where('periode_id', $periode->id)
                ->where('pembayaran', 'lunas')
                ->where('gelombang', $i)
                ->orderBy('nim', 'ASC')
                ->get();
            $data['gelombang_' . $i] = $maba;
        }

        return ResponseFormatter::success($data, 'Data NIM');
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

            $maba = Maba::where("no_pendaftaran", $request->no)->first();
            $maba->update([
                "nim" => $request->nim,
                "tgl_nim" => now()
            ]);

            // Logger::info($maba, 'updating NIM');

            return ResponseFormatter::success($maba, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            Logger::error($maba, $e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
