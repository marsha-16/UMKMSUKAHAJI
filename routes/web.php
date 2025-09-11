<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\PemetaanController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;

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

// =================== ADMIN AUTH ===================
Route::get('/loginAdmin', [AdminAuthController::class, 'loginForm'])->name('auth.loginAdmin');
Route::post('/loginAdmin', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::get('/dashboardAdmin', function () {
    return view('pages.admin.dashboardAdmin');
})->middleware('auth:admin')->name('admin.dashboard');

// USER LOGOUT
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

// ADMIN LOGOUT
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


// Halaman form register
Route::get('/register', [AuthController::class, 'registerView'])->name('register.view');

// Proses submit register
Route::post('/register', [AuthController::class, 'registerSubmit'])->name('register');

// =================== NOTIFICATION (Admin & User) ===================
Route::get('/notification', function () {
    return view('pages.notifications');
})->middleware('auth:web,admin');

Route::post('/notification/{id}/read', function ($id) {
    $notification = \Illuminate\Support\Facades\DB::table('notifications')->where('id', $id);
    $notification->update([
        'read_at'=> \Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'),
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

    // khusus admin
    // Route::get('/admin/pemetaan', [PemetaanController::class, 'index'])->name('admin.pemetaan');
    Route::post('/admin/pemetaan/update-status/{id}', [PemetaanController::class, 'update_status'])->name('admin.pemetaan.update_status');

    Route::get('/reports/umkm', [ReportController::class, 'showReportPage'])->name('reports.umkm'); 
    // Route::get('/reports/umkm', [ReportController::class, 'printAll'])->name('reports.umkm'); 
    
    Route::post('/pemetaan/{id}/read', [PemetaanController::class, 'markAsRead'])
    ->name('pemetaan.read');
});

// =================== ADMIN & USER ===================
Route::middleware(['auth:admin,web'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile_view']);
    Route::post('/profile/{id}', [UserController::class, 'update_profile']);
    Route::get('/change-password', [UserController::class, 'change_password_view']);
    Route::post('/change-password/{id}', [UserController::class, 'change_password']);

    Route::get('/search', [SearchController::class, 'index'])->name('search');

    Route::get('/pemetaan', [PemetaanController::class, 'index']);
});

// =================== USER ONLY ===================
Route::middleware('auth:web')->group(function () {
    Route::get('/pemetaan/create', [PemetaanController::class, 'create']);
    Route::post('/pemetaan', [PemetaanController::class, 'store']);
    Route::get('/pemetaan/{id}', [PemetaanController::class, 'edit']);
    Route::put('/pemetaan/{id}', [PemetaanController::class, 'update']);
    Route::delete('/pemetaan/{id}', [PemetaanController::class, 'destroy']);
});


