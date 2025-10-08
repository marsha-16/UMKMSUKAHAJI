<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Katalog;

class KatalogController extends Controller
{
    /**
     * Tampilkan daftar katalog
     */
    public function index()
    {
        $katalogs = Katalog::latest()->paginate(5);
        return view('pages.admin.katalog.index', compact('katalogs'));
    }

    /**
     * Simpan katalog baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'nullable|numeric',
            'address'     => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = $request->only(['name','description','price','address','phone']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();

            // gunakan DOCUMENT_ROOT/uploads/katalogs
            $uploadPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/katalogs';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);
            $data['image'] = 'uploads/katalogs/'.$filename;
        }

        Katalog::create($data);

        return redirect()->route('admin.katalog.index')->with('success', 'Katalog berhasil ditambahkan.');
    }

    /**
     * Update katalog
     */
    public function update(Request $request, Katalog $katalog)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'nullable|numeric',
            'address'     => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = $request->only(['name','description','price','address','phone']);

        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($katalog->image && file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$katalog->image)) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/'.$katalog->image);
            }

            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();

            $uploadPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/katalogs';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);
            $data['image'] = 'uploads/katalogs/'.$filename;
        }

        $katalog->update($data);

        return redirect()->route('admin.katalog.index')->with('success', 'Katalog berhasil diupdate.');
    }

    /**
     * Hapus katalog
     */
    public function destroy(Katalog $katalog)
    {
        if ($katalog->image && file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$katalog->image)) {
            unlink($_SERVER['DOCUMENT_ROOT'].'/'.$katalog->image);
        }

        $katalog->delete();

        return redirect()->route('admin.katalog.index')->with('success', 'Katalog berhasil dihapus.');
    }
}
