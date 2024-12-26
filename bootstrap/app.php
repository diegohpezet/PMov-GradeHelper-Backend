<?php

use App\Http\Middlewares\HandleInertiaRequests;
use App\Http\Middlewares\CheckAdmin;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['admin' => CheckAdmin::class]);
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
        if (env('APP_ENV') == 'local') {
            $middleware->trustProxies(at: '*');
        }
    })    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
