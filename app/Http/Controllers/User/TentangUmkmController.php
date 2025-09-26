<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TentangUmkm;

class TentangUmkmController extends Controller
{
    public function index()
    {
        $tentangs = TentangUmkm::all(); // ambil semua data
        return view('pages.user.tentang.index', compact('tentangs'));
    }
}
