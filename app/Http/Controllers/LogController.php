<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $activity = Log::orderBy('created_at', 'desc')->get();
        return view('pages.log', compact('activity'));
    }
}
