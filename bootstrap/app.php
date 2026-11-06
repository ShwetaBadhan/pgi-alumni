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
        
        
        $middleware->redirectGuestsTo(function ($request) {
            $routeName = $request->route() ? $request->route()->getName() : '';
            $path = $request->path();

            // Agar route alumni, abstract, payment, ya register se related hai
            if (str_starts_with($routeName, 'alumni.') || 
                str_contains($path, 'abstract') || 
                str_contains($path, 'alumni') ||
                str_contains($path, 'payment') ||
                str_contains($path, 'donate') ||
                str_contains($path, 'register')) {
                
                return route('alumni-login');
            }

            return route('login');
        });

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();