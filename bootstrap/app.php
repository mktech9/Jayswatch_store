<?php


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->web(append: [
            \App\Http\Middleware\PreventBackHistory::class,
        ]);

        // ✅ Register middleware alias
        $middleware->alias([
            'checklogin' => \App\Http\Middleware\checklogin::class,
            'menu.permission' => \App\Http\Middleware\CheckMenuPermission::class,

        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->view('frontend.404', [], 404);
        });

    })
    ->create();
