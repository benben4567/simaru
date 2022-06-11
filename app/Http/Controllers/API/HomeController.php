<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function profile()
    {
        return ResponseFormatter::success(auth()->user(), 'Profile');
    }
}
