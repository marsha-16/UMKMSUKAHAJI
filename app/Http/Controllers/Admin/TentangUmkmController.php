<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TentangUmkm;
use Illuminate\Http\Request;

class TentangUmkmController extends Controller
{
    public function index()
    {
        $tentangs = TentangUmkm::all();
        return view('pages.admin.tentang.index', compact('tentangs'));
    }

    public function create()
    {
        return view('pages.admin.tentang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        TentangUmkm::create($request->all());
        return redirect()->route('admin.tentang.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(TentangUmkm $tentang)
    {
        return view('pages.admin.tentang.edit', compact('tentang'));
    }

    public function update(Request $request, TentangUmkm $tentang)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $tentang->update($request->all());
        return redirect()->route('admin.tentang.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(TentangUmkm $tentang)
    {
        $tentang->delete();
        return redirect()->route('admin.tentang.index')->with('success', 'Data berhasil dihapus');
    }
}
