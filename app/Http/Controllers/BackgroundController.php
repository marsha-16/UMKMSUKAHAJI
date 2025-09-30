<?php

namespace App\Http\Controllers;

use App\Models\Background;
use Illuminate\Http\Request;

class BackgroundController extends Controller
{
    public function index()
    {
        $backgrounds = Background::all();
        return view('pages.admin.backgrounds.index', compact('backgrounds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $fileName = time() . '_' . $request->file('image')->getClientOriginalName();

        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/backgrounds';
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $request->file('image')->move($uploadPath, $fileName);

        Background::create([
            'image' => 'uploads/backgrounds/' . $fileName
        ]);

        return redirect()->back()->with('success', 'Background berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $bg = Background::findOrFail($id);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048'
            ]);

            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();

            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/backgrounds';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $request->file('image')->move($uploadPath, $fileName);

            // hapus file lama kalau ada
            if ($bg->image && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $bg->image)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $bg->image);
            }

            // update path baru
            $bg->update([
                'image' => 'uploads/backgrounds/' . $fileName
            ]);
        }

        return redirect()->back()->with('success', 'Background berhasil diupdate');
    }

    public function destroy($id)
    {
        $bg = Background::findOrFail($id);

        // hapus file lama kalau ada
        if ($bg->image && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $bg->image)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $bg->image);
        }

        $bg->delete();

        return redirect()->back()->with('success', 'Background berhasil dihapus');
    }
}
