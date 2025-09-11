<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set timezone PHP/Laravel (jaga-jaga meskipun sudah di config/app.php)
        config(['app.timezone' => 'Asia/Jakarta']);
        date_default_timezone_set('Asia/Jakarta');
        Carbon::setLocale('id');

        // Set timezone MySQL agar waktu INSERT/SELECT sesuai
        DB::statement("SET time_zone = '+07:00'");
    }
}
