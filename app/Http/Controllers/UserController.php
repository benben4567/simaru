<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $users = User::all();
            return ResponseFormatter::success($users, "Data User");
        }

        $permissions = Permission::all();
        return view('pages.pengguna', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => 'required',
            "email" => 'required|email',
            "password" => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {
            $user = User::create([
                "name" => $request->nama,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);

            return ResponseFormatter::success($user, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => 'required',
            "email" => 'required|email',
            "status" => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {
            $user = User::whereId($request->id)->update([
                "name" => $request->nama,
                "email" => $request->email,
                "status" => $request->status
            ]);

            return ResponseFormatter::success($user, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }

    public function permission(Request $request)
    {
        $user = User::find($request->id);
        try {
            $user->syncPermissions($request->permissions);

            return ResponseFormatter::success(User::with('permissions')->get(), 'Data Berhasil Disimpan');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }

    public function getPermission($id)
    {
        $user = User::whereId($id)->with("permissions")->first();

        return ResponseFormatter::success($user->permissions, 'Data Akses');
    }

    public function password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password" => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), "Data tidak valid", 422);
        }

        try {
            $user = User::whereId($request->id)->update([
                "password" => Hash::make($request->password)
            ]);

            return ResponseFormatter::success($user, "Data Berhasil Disimpan", 201);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Terjadi Kesalahan di Server');
        }
    }
}
