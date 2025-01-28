<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //PARA USO EM TODAS AS ROTAS
        //$middleware->addMiddleware(Authenticate::class); // Adiciona o middleware 'auth'
        //$middleware->addMiddleware(RoleMiddleware::class); // Adiciona o RoleMiddleware
        //$middleware->appendMiddleware('role', RoleMiddleware::class);
        $middleware->alias([
            'role' => RoleMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();




