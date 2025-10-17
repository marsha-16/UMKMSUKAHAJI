<?php

namespace App\Http\Controllers;

use App\Models\UMKM;
use App\Models\Pemetaan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UmkmController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $umkms = UMKM::when($search, function($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(5)
        ->appends(['search' => $search]); // supaya pagination tetap bawa query search

    return view('pages.umkm.index', compact('umkms'));
}


    public function create()
    {
        return view('pages.umkm.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:100'],
            'address' => ['required', 'max:255'],
        ]);

        try{
        $umkm = UMKM::create($request->all());

        return redirect('/umkm')->with('success', 'Data Penduduk berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data penduduk');
        }
    }

    public function edit($id)
    {
        $umkm = UMKM::findOrFail($id);

        return view('pages.umkm.edit', [
            'umkm' => $umkm,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:100'],
            'address' => ['required', 'max:255'],
        ]);

        try{
        $umkm = UMKM::findOrFail($id);
        $umkm->update($request->all());

        return redirect('/umkm')->with('success', 'Data Penduduk berhasil diperbarui');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal memperbarui data penduduk');
    }
    }

    public function destroy($id)
    {
        try{
        $umkm = UMKM::findOrFail($id);

        $umkm->delete();
        return redirect('/umkm')->with('success', 'Data Penduduk berhasil dihapus');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menghapus data penduduk');
    }
    }
}
