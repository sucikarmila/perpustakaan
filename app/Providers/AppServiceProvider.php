<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
{
    View::composer('*', function ($view) {
        if (Auth::check()) {
            $jumlahKoleksi = DB::table('koleksi_pribadi')
                ->where('UserID', Auth::user()->UserID)
                ->count();
            $view->with('jumlahKoleksi', $jumlahKoleksi);
        }
    });
}
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
    
}
