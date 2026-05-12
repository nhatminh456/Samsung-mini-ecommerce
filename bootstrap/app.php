<?php
// @Author: [Trần Nhật Minh] - [Mã sinh viên: 23140006]
// @Project: Mini Ecommerce 
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'api/chatbot/reply'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();