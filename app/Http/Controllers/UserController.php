<?php

namespace App\Http\Controllers;

use App\Models\UMKM;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Storage;

class UserController extends Controller
{
    public function account_request_view()
    {
        $users = User::where('status', 'submitted')->paginate(5);
        $umkms = UMKM::where('user_id', null)->get();

        return view('pages.account-request.index', [
            'users' => $users,
            'umkms' => $umkms,
        ]);
    }

    public function account_approval(Request $request, $userId)
    {
        $request->validate([
            'for' => ['required', Rule::in(['approve', 'reject', 'activate', 'deactivate'])],
            'umkm_id' => ['nullable', 'exists:u_m_k_m_s,id']
        ]);

        $for = $request->input('for');

        $user = User::findOrFail($userId);
        $user->status = ($for == 'approve' || $for == 'activate') ? 'approved' : 'rejected';
        $user->save();

        $umkmId = $request->input('umkm_id');

        if ($request->has('umkm_id') && isset($umkmId)) {
            UMKM::where('id', $umkmId)->update([
                'user_id' => $user->id,
            ]);
        }

        if ($for == 'activate') {
            return back()->with('success', 'Berhasil mengaktifkan akun');
        } else if ($for == 'deactivate') {
            return back()->with('success', 'Berhasil menonaktifkan akun');
        }

        return back()->with('success', $for == 'approve' ? 'Berhasil menyetujui akun' : 'Berhasil menolak akun');
    }

    public function account_list_view()
    {
        $users = User::where('role_id', 2)->where('status', '!=', 'submitted')->paginate(5);

        return view('pages.account-list.index', [
            'users' => $users,
        ]);
    }

    public function profile_view()
    {
        // cek siapa yang login
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user(); // admin login
        } else {
            $user = Auth::guard('web')->user();   // user biasa login
        }

        return view('pages.profile.index'); 
    }

    public function update_profile(Request $request, $userId)
    {
        if (Auth::guard('admin')->check()) {
            $user = Admin::findOrFail($userId);
        } else {
            $user = User::findOrFail($userId);
        }

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // $user = User::findOrFail($userId);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->hasFile('photo')) {
        // Hapus foto lama
        if ($user->photo && Storage::exists('public/'.$user->photo)) {
            \Storage::delete('public/'.$user->photo);
        }

        $path = $request->file('photo')->store('photos', 'public');
        $user->photo = $path;
        }
        $user->save();

        return redirect('/profile')->with('success', 'Profil berhasil diperbarui');
    }

    public function change_password_view()
    {
        return view('pages.profile.change-password');
    }

    public function change_password(Request $request, $userId)
    {
        $request->validate([
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8',
        ]);

        $user = User::findOrFail($userId);

        $currentPasswordIsValid = Hash::check($request->input('old_password'), $user->password);

        if ($currentPasswordIsValid) {
            $user->password = $request->input('new_password');
            $user->save();

            return back()->with('success', 'Berhasil Mengubah Password');
        }
        return back()->with('error', 'Gagal mengubah password, password lama tidak valid');
    }

    public function markAsRead($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'read_at' => now(),
        ]);

        return redirect('/account-request');
    }
}
