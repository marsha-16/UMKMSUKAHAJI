<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\PemetaanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BackgroundController;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\User\AuthController as UserAuthController;

use App\Http\Controllers\Admin\TentangUmkmController as AdminTentangUmkmController;
use App\Http\Controllers\User\TentangUmkmController as UserTentangUmkmController;

use App\Http\Controllers\Admin\KatalogController as AdminKatalogController;
use App\Http\Controllers\User\KatalogController as UserKatalogController;

use App\Models\Katalog;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $katalogs = Katalog::latest()->take(4)->get();
    return view('index', compact('katalogs'));
})->name('home');


/*
|--------------------------------------------------------------------------
| Halaman Katalog Umum (tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/katalog', function (Request $request) {
    $query = Katalog::query();

    // Reset filter
    if ($request->has('reset')) {
        return redirect('/katalog');
    }

    // Filter pencarian
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    // Filter harga minimum & maksimum
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    $katalogs = $query->latest()->paginate(8)->withQueryString();
    return view('katalog', compact('katalogs'));
})->name('katalog');


/*
|--------------------------------------------------------------------------
| AUTH USER
|--------------------------------------------------------------------------
*/
Route::get('/login', [UserAuthController::class, 'loginForm'])->name('auth.login');
Route::post('/login', [UserAuthController::class, 'login'])->name('user.login.submit');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

// Register
Route::get('/register', [AuthController::class, 'registerView'])->name('register.view');
Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register');

// Dashboard User
Route::get('/dashboard', function () {
    return view('pages.user.dashboard');
})->middleware('auth:web')->name('user.dashboard');


/*
|--------------------------------------------------------------------------
| AUTH ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/loginAdmin', [AdminAuthController::class, 'loginForm'])->name('auth.loginAdmin');
Route::post('/loginAdmin', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Dashboard Admin
Route::get('/dashboardAdmin', function () {
    return view('pages.admin.dashboardAdmin');
})->middleware('auth:admin')->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| NOTIFIKASI (Admin & User)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web,admin')->group(function () {
    Route::get('/notification', fn() => view('pages.notifications'));

    Route::post('/notification/{id}/read', function ($id) {
        $notification = DB::table('notifications')->where('id', $id);
        $notification->update(['read_at' => DB::raw('CURRENT_TIMESTAMP')]);

        $dataArray = json_decode($notification->firstOrFail()->data, true);
        return isset($dataArray['pemetaan_id'])
            ? redirect('/pemetaan')
            : back();
    });
});


/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware('auth:admin')->group(function () {

    // 🔎 Pencarian hanya untuk admin
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // CRUD UMKM
    Route::resource('umkm', UmkmController::class)->except(['show']);

    // Manajemen Akun User
    Route::get('/account-list', [UserController::class, 'account_list_view']);
    Route::get('/account-request', [UserController::class, 'account_request_view']);
    Route::post('/account-request/approval/{id}', [UserController::class, 'account_approval']);

    // Pemetaan
    Route::get('/pemetaan', [PemetaanController::class, 'index'])->name('pemetaan.index');
    Route::post('/pemetaan/update-status/{id}', [PemetaanController::class, 'update_status']);
    Route::post('/admin/pemetaan/update-status/{id}', [PemetaanController::class, 'update_status'])
        ->name('admin.pemetaan.update_status');
    Route::post('/pemetaan/{id}/read', [PemetaanController::class, 'markAsRead'])->name('pemetaan.read');

    // Laporan
    Route::get('/reports/umkm', [ReportController::class, 'showReportPage'])->name('reports.umkm');

    // Tentang UMKM
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('tentang', AdminTentangUmkmController::class);
        Route::resource('backgrounds', BackgroundController::class)->only(['index','store','update','destroy']);
        Route::resource('katalog', AdminKatalogController::class);
    });
});


/*
|--------------------------------------------------------------------------
| ADMIN & USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:admin,web'])->group(function () {
    // Profil
    Route::get('/profile', [UserController::class, 'profile_view'])->name('profile');
    Route::post('/profile/{id}', [UserController::class, 'update_profile'])->name('profile.update');

    // Ubah Password
    Route::get('/change-password', [UserController::class, 'change_password_view'])->name('password');
    Route::post('/change-password/{id}', [UserController::class, 'change_password'])->name('password.update');

    // Halaman Pemetaan (lihat data)
    Route::get('/pemetaan', [PemetaanController::class, 'index'])->name('pemetaan.index');
});


/*
|--------------------------------------------------------------------------
| USER ONLY
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {
    // CRUD Pemetaan User
    Route::resource('pemetaan', PemetaanController::class)->except(['index']);

    // Katalog User
    Route::get('/katalog-user', [UserKatalogController::class, 'index'])->name('katalog.index');
    Route::get('/katalog-user/{id}', [UserKatalogController::class, 'show'])->name('katalog.show');

    // Tentang UMKM (user hanya lihat)
    Route::get('/tentang-umkm', [UserTentangUmkmController::class, 'index'])->name('tentang-umkm');
});


/*
|--------------------------------------------------------------------------
| DATA UNTUK DASHBOARD (Chart & Status)
|--------------------------------------------------------------------------
*/
Route::get('/chart-data', function () {
    $data = DB::table('pemetaans')
        ->select('business', DB::raw('COUNT(*) as total'))
        ->groupBy('business')
        ->pluck('total', 'business');

    return response()->json($data);
})->name('chart.data');

Route::get('/status-counts', function () {
    return response()->json([
        'approve' => DB::table('pemetaans')->where('status', 'approve')->count(),
        'process' => DB::table('pemetaans')->where('status', 'process')->count(),
        'rejected' => DB::table('pemetaans')->where('status', 'rejected')->count(),
    ]);
})->name('status.counts');
