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

    // Kalau guard "admin" → bisa filter umkm_id
    if (auth('admin')->check() && $request->filled('umkm_id')) {
        $pemetaans->where('umkm_id', $request->umkm_id);
    }

    // === Filter berdasarkan status dari dashboard ===
    $status = $request->get('status'); // ambil dari query string
    if ($status && $status !== 'all') {
        $pemetaans->where('status', $status);
    }

    $pemetaans = $pemetaans->latest()->paginate(5);

    // Hitung jumlah status process (khusus user)
    $processCount = 0;
    if ($umkmId) {
        $processCount = Pemetaan::where('umkm_id', $umkmId)
            ->where('status', 'process')
            ->count();
    }

    return view('pages.pemetaan.index', compact('pemetaans', 'processCount', 'status'));
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
                'Servis Elektronik', 'Jasa Sumur Bor', 'Kaligrafi', 'Air Isi Ulang',
                'Jasa Tenaga', 'Refill Parfum', 'Olahraga dan Hiburan', 'Jual Beli Hewan Ternak',
                'Buah-Buahan', 'Home Industri', 'Konter Handphone', 'Accessories'
            ])],
            'marketing' => ['required', Rule::in(['Tunai', 'Online'])],
            'promotion' => ['required', Rule::in(['Whatsapp', 'Facebook', 'Instagram', 'TikTok', 'Shopee', 'Tokopedia', 'Gojek/Grab'])],
            'document' => ['required', Rule::in(['Nomor Induk Berusaha', 'Sertifikat Halal', 'Pangan Industri Rumah Tangga', 'Belum Punya', 'Dalam Proses'])],
            'document_photo' => ['nullable', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $umkm = Auth::user()->umkm;

        if (!$umkm) {
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

        // STORE
        if ($request->hasFile('document_photo')) {
            $uploadPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/documents';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('document_photo');
            $fileName = time().'.'.$file->getClientOriginalExtension();

            $file->move($uploadPath, $fileName);

            $pemetaan->document_photo = 'uploads/documents/'.$fileName;
            $pemetaan->document_original_name = $file->getClientOriginalName(); // ⬅️ simpan nama asli
        } elseif (!$pemetaan->document_photo) {
            $pemetaan->document_photo = 'images/default.png';
        }

        $pemetaan->save();

        return redirect('/pemetaan')->with('success', 'Selamat! Data UMKM Anda telah berhasil dibuat. Silakan bergabung dengan komunitas UMKM kami melalui grup WhatsApp untuk mendapatkan informasi dan dukungan lebih lanjut. Anda dapat menemukan link grup WhatsApp di menu Tentang UMKM.');
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
                'Servis Elektronik', 'Jasa Sumur Bor', 'Kaligrafi', 'Air Isi Ulang',
                'Jasa Tenaga', 'Refill Parfum', 'Olahraga dan Hiburan', 'Jual Beli Hewan Ternak',
                'Buah-Buahan', 'Home Industri', 'Konter Handphone', 'Accessories'
            ])],
            'marketing' => ['required', Rule::in(['Tunai', 'Online'])],
            'promotion' => ['required', Rule::in(['Whatsapp', 'Facebook', 'Instagram', 'TikTok', 'Shopee', 'Tokopedia', 'Gojek/Grab'])],
            'document' => ['required', Rule::in(['Nomor Induk Berusaha', 'Sertifikat Halal', 'Pangan Industri Rumah Tangga', 'Belum Punya', 'Dalam Proses'])],
            'document_photo' => ['nullable', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $umkm = Auth::user()->umkm;

        if (!$umkm) {
            return redirect('/pemetaan')->with('error', 'Akun anda belum terhubung dengan data penduduk manapun');
        }

        $pemetaan = Pemetaan::findOrFail($id);

        $pemetaan->umkm_id = $umkm->id;
        $pemetaan->name = $request->input('name');
        $pemetaan->nik = $request->input('nik');
        $pemetaan->address = $request->input('address');
        $pemetaan->phone = $request->input('phone');
        $pemetaan->business = $request->input('business');
        $pemetaan->marketing = $request->input('marketing');
        $pemetaan->promotion = $request->input('promotion');
        $pemetaan->document = $request->input('document');

        // UPDATE
        if ($request->hasFile('document_photo')) {
            $uploadPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/documents';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // hapus foto lama (kecuali default)
            if ($pemetaan->document_photo && $pemetaan->document_photo !== 'images/default.png') {
                $oldFile = $_SERVER['DOCUMENT_ROOT'].'/'.$pemetaan->document_photo;
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $file = $request->file('document_photo');
            $fileName = time().'.'.$file->getClientOriginalExtension();

            $file->move($uploadPath, $fileName);

            $pemetaan->document_photo = 'uploads/documents/'.$fileName;
            $pemetaan->document_original_name = $file->getClientOriginalName(); // ⬅️ simpan nama asli
        } elseif (!$pemetaan->document_photo) {
            $pemetaan->document_photo = 'images/default.png';
        }

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
