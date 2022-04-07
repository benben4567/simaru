<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    public function internal()
    {
        $jenis = "Internal";
        return view('pages.rekomendasi', compact('jenis'));
    }

    public function eksternal()
    {
        $jenis = "Eksternal";
        return view('pages.rekomendasi', compact('jenis'));
    }
}
