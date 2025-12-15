<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'checkLogin' => \App\Http\Middleware\CheckLogin::class,
        'checkPemerintahProfile' => \App\Http\Middleware\CheckPemerintahProfile::class,
        'checkRtRwProfile' => \App\Http\Middleware\CheckRtRwProfile::class,
    ]);
})

    ->withExceptions(function (Exceptions $exceptions): void {
        // Konfigurasi exception handling bisa ditambah di sini
    })
    ->create();
