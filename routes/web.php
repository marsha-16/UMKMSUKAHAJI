<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\PemetaanController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\User\TentangUmkmController as UserTentangUmkmController;
use App\Http\Controllers\Admin\TentangUmkmController as AdminTentangUmkmController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BackgroundController;


// =================== HALAMAN UTAMA ===================
Route::get('/', function () {
    return view('index');
})->name('home');

// =================== USER AUTH ===================
Route::get('/login', [UserAuthController::class, 'loginForm'])->name('auth.login'); 

Route::post('/login', [UserAuthController::class, 'login'])->name('user.login.submit');

Route::get('/dashboard', function () {
    return view('pages.user.dashboard');
})->middleware('auth:web')->name('user.dashboard');

// USER LOGOUT
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

// Halaman form register
Route::get('/register', [AuthController::class, 'registerView'])->name('register.view');
// Proses submit register
Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register');

// =================== ADMIN AUTH ===================
Route::get('/loginAdmin', [AdminAuthController::class, 'loginForm'])->name('auth.loginAdmin');
Route::post('/loginAdmin', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::get('/dashboardAdmin', function () {
    return view('pages.admin.dashboardAdmin');
})->middleware('auth:admin')->name('admin.dashboard');

// ADMIN LOGOUT
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// =================== NOTIFICATION (Admin & User) ===================
Route::get('/notification', function () {
    return view('pages.notifications');
})->middleware('auth:web,admin');

Route::post('/notification/{id}/read', function ($id) {
    $notification = DB::table('notifications')->where('id', $id);
    $notification->update([
        'read_at'=> DB::raw('CURRENT_TIMESTAMP'),
    ]);

    $dataArray = json_decode($notification->firstOrFail()->data, true);
    if (isset($dataArray['pemetaan_id'])) {
        return redirect('/pemetaan');
    } 
    return back();
})->middleware('auth:web,admin');

// =================== ADMIN ONLY ===================
Route::middleware('auth:admin')->group(function () {
    // UMKM
    Route::get('/umkm', [UmkmController::class, 'index']);
    Route::get('/umkm/create', [UmkmController::class, 'create']);
    Route::post('/umkm', [UmkmController::class, 'store']);
    Route::get('/umkm/{id}', [UmkmController::class, 'edit']);
    Route::put('/umkm/{id}', [UmkmController::class, 'update']);
    Route::delete('/umkm/{id}', [UmkmController::class, 'destroy']);

    // User account management
    Route::get('/account-list', [UserController::class, 'account_list_view']);
    Route::get('/account-request', [UserController::class, 'account_request_view']);
    Route::post('/account-request/approval/{id}', [UserController::class, 'account_approval']);

    // pemetaan status update
    Route::post('/pemetaan/update-status/{id}', [PemetaanController::class, 'update_status']);

    Route::post('/admin/pemetaan/update-status/{id}', [PemetaanController::class, 'update_status'])->name('admin.pemetaan.update_status');

    Route::get('/reports/umkm', [ReportController::class, 'showReportPage'])->name('reports.umkm'); 
    
    Route::post('/pemetaan/{id}/read', [PemetaanController::class, 'markAsRead'])
        ->name('pemetaan.read');

    Route::get('/search', [SearchController::class, 'index'])->name('search');
});

// =================== ADMIN & USER ===================
Route::middleware(['auth:admin,web'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile_view'])->name('profile');
    Route::post('/profile/{id}', [UserController::class, 'update_profile'])->name('profile.update');

    Route::get('/change-password', [UserController::class, 'change_password_view'])->name('password');
    Route::post('/change-password/{id}', [UserController::class, 'change_password'])->name('password.update');

    Route::get('/pemetaan', [PemetaanController::class, 'index'])->name('pemetaan');
});

// =================== USER ONLY ===================
Route::middleware('auth:web')->group(function () {
    Route::get('/pemetaan/create', [PemetaanController::class, 'create']);
    Route::post('/pemetaan', [PemetaanController::class, 'store']);
    Route::get('/pemetaan/{id}', [PemetaanController::class, 'edit']);
    Route::put('/pemetaan/{id}', [PemetaanController::class, 'update']);
    Route::delete('/pemetaan/{id}', [PemetaanController::class, 'destroy']);
});

// =================== DATA UNTUK CHART ===================
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


// =================== DATA UNTUK TENTANG ===================
// Route khusus Admin
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('tentang', AdminTentangUmkmController::class);
});

// Route khusus User (hanya bisa lihat)
Route::middleware('auth:web')->group(function () {
    Route::get('/tentang-umkm', [UserTentangUmkmController::class, 'index'])->name('tentang-umkm');
});

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('backgrounds', BackgroundController::class)->only(['index','store','update','destroy']);
});