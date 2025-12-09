<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class, 
            
            // Tambahkan Alias untuk Peran Kustom lainnya:
            'bpdpks' => \App\Http\Middleware\IsBpdpks::class,      
            'mahasiswa' => \App\Http\Middleware\IsMahasiswa::class, 
            
            // PERBAIKAN: Ganti namespace untuk middleware bawaan Laravel
            // 'auth' => \App\Http\Middleware\Authenticate::class, // <-- ERROR. Ganti dengan yang di bawah.
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class, // <-- BENAR
            
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            
            // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // <-- ERROR. Ganti dengan yang di bawah.
            'guest' => \Illuminate\Routing\Middleware\SubstituteBindings::class, // <-- Diganti dengan routing bawaan untuk guest di L11
            
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            // Tambahkan alias middleware kustom lainnya di sini
        ]);
        
        // Pendaftaran Middleware Group 'web' (Middleware yang selalu aktif di rute web)
        $middleware->web(append: [
            // Middleware yang ditambahkan ke grup 'web'
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class, // Tambahan untuk autentikasi
        ]);
        
        // Pendaftaran Middleware Group 'api'
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        
        // Catatan: Jika Anda ingin menggunakan Middleware 'RedirectIfAuthenticated' untuk rute 'guest',
        // Anda harus mendaftarkannya di lokasi baru:
        // $middleware->alias([
        //     'guest' => \Illuminate\Routing\Middleware\RedirectIfAuthenticated::class,
        // ]);
        // Namun, di L11 defaultnya sudah ditangani oleh konfigurasi 'guest'
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();