<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();
        $middleware->redirectGuestsTo(null);

        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'api/auth/*',
            'api/users/*',
            'api/planillas*',
            'api/notifications*',
            'api/notifications/*',
            'api/sent-reports*',
            'api/sent-reports/*',
            'api/deadlines*',
            'api/deadlines/*',
            'api/assignments/*',
            'api/my-assignments',
            'api/calendario',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors(),
                'status' => 422,
            ], 422);
        });

        $exceptions->render(function (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Recurso no encontrado.',
                'errors' => null,
                'status' => 404,
            ], 404);
        });

        $exceptions->render(function (AuthenticationException $e) {
            return response()->json([
                'message' => 'No autenticado.',
                'errors' => null,
                'status' => 401,
            ], 401);
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            return response()->json([
                'message' => 'Ruta no encontrada.',
                'errors' => null,
                'status' => 404,
            ], 404);
        });
    })->create();
