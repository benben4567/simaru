<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ResponseFormatter::error(null, 'Email atau Password salah', 404);
        }

        $token = $user->createToken('ApiToken')->plainTextToken;

        $data = [
            'user'      => $user,
            'token'     => $token
        ];

        return ResponseFormatter::success($data, 'Logged In');
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        auth()->logout();
        return ResponseFormatter::success(null, "Logged out");
    }
}
