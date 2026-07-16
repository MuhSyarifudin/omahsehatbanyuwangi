<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
         // Laragon share mengirimkan header X-Forwarded-Host yang berisi nama domain Ngrok asli
    if (Request::hasHeader('X-Forwarded-Host')) {
        
        // Ambil domain ngrok secara dinamis (contoh: xxxx.ngrok-free.app)
        $ngrokUrl = 'https://' . Request::header('X-Forwarded-Host');
        
        // Paksa Laravel mengubah basis domain aset & rute menjadi domain Ngrok tersebut
        URL::forceRootUrl($ngrokUrl);
        URL::forceScheme('https');
    }
    }
}
