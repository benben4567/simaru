<?php

namespace App\Http\Controllers\API;

use App\Helpers\Logger;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function profile()
    {
        return ResponseFormatter::success(auth()->user(), 'Profile');
    }

    public function password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "old_password" => 'required',
            "password" => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        $user = User::find(auth()->user()->id);

        if (Hash::check($request->old_password, $user->password)) {
            try {

                $user->update([
                    "password" => Hash::make($request->password)
                ]);

                Logger::info($user, 'password updated');

                return ResponseFormatter::success($user, "Data Berhasil Disimpan", 201);
            } catch (\Exception $e) {
                Logger::error($user, $e->getMessage());

                return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
            }
        } else {
            return ResponseFormatter::error(null, "Password lama salah", 422);
        }
    }
}
