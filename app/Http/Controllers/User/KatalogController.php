<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Katalog;

class KatalogController extends Controller
{
    // Menampilkan semua katalog untuk user dengan search & filter
    public function index(Request $request)
    {
        $query = Katalog::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $katalogs = $query->latest()->paginate(4)->withQueryString();
        return view('pages.user.katalog.index', compact('katalogs'));
    }

    // Menampilkan detail produk
    public function show($id)
    {
        $katalog = Katalog::findOrFail($id);
        return view('pages.user.katalog.show', compact('katalog'));
    }
}
