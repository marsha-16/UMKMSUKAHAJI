<?php

namespace App\Http\Controllers;

use App\Models\Pemetaan;
use App\Notifications\StatusPemetaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PemetaanController extends Controller
{
    public function index(Request $request)
    {
        $umkmId = Auth::user()->umkm->id ?? null;
    
        $pemetaans = Pemetaan::query();
    
        // Kalau role USER → hanya tampilkan aduan miliknya
        if (auth('web')->check() && $umkmId) {
            $pemetaans->where('umkm_id', $umkmId);
        }
    
        // Kalau guard "admin"
        if (auth('admin')->check() && $request->filled('umkm_id')) {
            $pemetaans->where('umkm_id', $request->umkm_id);
        }
    
        $pemetaans = $pemetaans->latest()->paginate(5);
    
        // Hitung jumlah status process
        $processCount = 0;
        if ($umkmId) {
            $processCount = Pemetaan::where('umkm_id', $umkmId)
                ->where('status', 'process')
                ->count();
        }
    
        return view('pages.pemetaan.index', compact('pemetaans', 'processCount'));
    }
    


    public function create()
    {

        $umkm = Auth::user()->umkm;

        if(!$umkm) {
            return redirect('/pemetaan')->with('error', 'Akun anda belum terhubung dengan data penduduk manapun');
        }

        return view('pages.pemetaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'nik' => ['required', 'min:16', 'max:16'],
            'address' => ['required', 'max:255'],
            'phone' => ['nullable', 'max:20'],
            'business' => ['required', Rule::in([
                'Warung Kelontong', 'Makanan dan Minuman', 'Sayur Mayur dan Daging',
                'Pakaian', 'Jajanan Pasar', 'Jasa Fotocopy',
                'Servis Elektronik', 'Jasa Sumur Bor', 'Yang lain'
            ])],
            'marketing' => ['required', Rule::in(['Tunai', 'Online'])],
            'promotion' => ['required', Rule::in(['Whatsapp', 'Facebook', 'Instagram', 'TikTok', 'Shopee', 'Tokopedia', 'Gojek/Grab'])],
            'document' => ['required', Rule::in(['Nomor Induk Berusaha', 'Sertifikat Halal', 'Pangan Industri Rumah Tangga', 'Belum Punya', 'Dalam Proses'])],
        ]);

        $umkm = Auth::user()->umkm;

        if(!$umkm) {
            return redirect('/pemetaan')->with('error', 'Akun anda belum terhubung dengan data penduduk manapun');
        }

        $pemetaan = new Pemetaan();
        $pemetaan->umkm_id = $umkm->id;
        $pemetaan->name = $request->input('name');
        $pemetaan->nik = $request->input('nik');
        $pemetaan->address = $request->input('address');
        $pemetaan->phone = $request->input('phone');
        $pemetaan->business = $request->input('business');
        $pemetaan->marketing = $request->input('marketing');
        $pemetaan->promotion = $request->input('promotion');
        $pemetaan->document = $request->input('document');

        $pemetaan->save();

        return redirect('/pemetaan')->with('success', 'Berhasil Membuat UMKM');
    }

    public function edit($id)
    {
        $umkm = Auth::user()->umkm;
    
        if(!$umkm) {
            return redirect('/pemetaan')->with('error', 'Akun anda belum terhubung dengan data penduduk manapun');
        }
    
        $pemetaan = Pemetaan::findOrFail($id);
    
        // Tambahkan pengecekan status
        if ($pemetaan->status != 'process') {
            return redirect('/pemetaan')->with('error', "Berhasil mengedit data UMKM");
        }
    
        return view('pages.pemetaan.edit', compact('pemetaan'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'nik' => ['required', 'min:16', 'max:16'],
            'address' => ['required', 'max:255'],
            'phone' => ['nullable', 'max:20'],
            'business' => ['required', Rule::in([
                'Warung Kelontong', 'Makanan dan Minuman', 'Sayur Mayur dan Daging',
                'Pakaian', 'Jajanan Pasar', 'Jasa Fotocopy',
                'Servis Elektronik', 'Jasa Sumur Bor', 'Yang lain'
            ])],
            'marketing' => ['required', Rule::in(['Tunai', 'Online'])],
            'promotion' => ['required', Rule::in(['Whatsapp', 'Facebook', 'Instagram', 'TikTok', 'Shopee', 'Tokopedia', 'Gojek/Grab'])],
            'document' => ['required', Rule::in(['Nomor Induk Berusaha', 'Sertifikat Halal', 'Pangan Industri Rumah Tangga', 'Belum Punya', 'Dalam Proses'])],
        ]);

        $umkm = Auth::user()->umkm;

        if(!$umkm) {
            return redirect('/pemetaan')->with('error', 'Akun anda belum terhubung dengan data penduduk manapun');
        }

        $pemetaan = Pemetaan::findOrFail($id);

        if ($pemetaan->status != 'process') {
            return redirect('/pemetaan')->with('error', "Gagal mengubah data UMKM");
        }

        $pemetaan->umkm_id = $umkm->id;
        $pemetaan->name = $request->input('name');
        $pemetaan->nik = $request->input('nik');
        $pemetaan->address = $request->input('address');
        $pemetaan->phone = $request->input('phone');
        $pemetaan->business = $request->input('business');
        $pemetaan->marketing = $request->input('marketing');
        $pemetaan->promotion = $request->input('promotion');
        $pemetaan->document = $request->input('document');

        $pemetaan->save();

        return redirect('/pemetaan')->with('success', 'Berhasil Mengubah UMKM');
    }

    public function destroy($id)
    {
        $umkm = Auth::user()->umkm;

        if(!$umkm) {
            return redirect('/pemetaan')->with('error', 'Akun anda belum terhubung dengan data penduduk manapun');
        }

        $pemetaan = Pemetaan::findOrFail($id);

        if ($pemetaan->status != 'process') {
            return redirect('/pemetaan')->with('error', "Gagal menghapus data UMKM");
        }

        // Hapus record di database
        $pemetaan->delete();

        return redirect('/pemetaan')->with('success', 'Berhasil Menghapus UMKM');
    }

    public function update_status(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in('process', 'approve', 'rejected')],
        ]);

        $umkm = Auth::user()->umkm;
        if(Auth::user()->role_id == \App\Models\Role::ROLE_USER && !$umkm) {
            return redirect('/pemetaan')->with('error', 'Akun anda belum terhubung dengan data penduduk manapun');
        }

        $pemetaan = Pemetaan::findOrFail($id);
        $oldStatus = $pemetaan->status_label;

        $pemetaan->status = $request->input('status');
        $pemetaan->save();

        $newStatus = $pemetaan->status_label;

        User::where('id', $pemetaan->umkm->user_id)
            ->firstOrFail()
            ->notify(new StatusPemetaan($pemetaan, $oldStatus, $newStatus));

        return redirect('/pemetaan')->with('success', 'Berhasil Mengubah Status');
    }

    public function markAsRead($id)
    {
        $pemetaan = Pemetaan::findOrFail($id);
        $pemetaan->status = 'approve'; // contoh ubah status
        $pemetaan->save();

        return redirect('pemetaan')->with('success', 'Pemetaan berhasil ditandai sebagai dibaca.');
    }

}
