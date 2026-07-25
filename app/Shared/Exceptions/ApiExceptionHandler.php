<?php

namespace App\Shared\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionHandler
{
    public static function register(Exceptions $exceptions): void
    {
        $exceptions->render(function (ValidationException $e, Request $request) {
            if (!self::shouldReturnJson($request)) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if (!self::shouldReturnJson($request)) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if (!self::shouldReturnJson($request)) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'You are not allowed to perform this action.',
            ], 403);
        });

        $exceptions->render(function (ModelNotFoundException|NotFoundHttpException $e, Request $request) {
            if (!self::shouldReturnJson($request)) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'Resource not found.',
            ], 404);
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if (!self::shouldReturnJson($request)) {
                return null;
            }

            if (app()->environment('local')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'exception' => class_basename($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ], 500);
            }

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 500);
        });
    }

    private static function shouldReturnJson(Request $request): bool
    {
        return $request->is('api/*') || $request->expectsJson();
    }
}