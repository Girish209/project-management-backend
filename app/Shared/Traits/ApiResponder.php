<?php

namespace App\Shared\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait ApiResponder
{
    protected function respondWithMessage(
        string $message = 'Success',
        int $status = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], $status);
    }

    protected function respondWithData(
        mixed $data,
        string $message = 'Success',
        int $status = 200
    ): JsonResponse {
        if ($data instanceof JsonResource) {
            $resourceData = $data->response()->getData(true);

            $response = [
                'success' => true,
                'message' => $message,
                'data' => $resourceData['data'],
            ];

            if (isset($resourceData['links'])) {
                $response['links'] = $resourceData['links'];
            }

            if (isset($resourceData['meta'])) {
                $response['meta'] = $resourceData['meta'];
            }

            return response()->json($response, $status);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    protected function respondCreated(
        mixed $data = null,
        string $message = 'Created successfully'
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], 201);
    }

    protected function respondNoContent(): JsonResponse
    {
        return response()->json(null, 204);
    }

    protected function respondBadRequest(
        string $message = 'Bad request',
        mixed $errors = null
    ): JsonResponse {
        return $this->respondError($message, 400, $errors);
    }

    protected function respondUnauthorized(
        string $message = 'Unauthenticated'
    ): JsonResponse {
        return $this->respondError($message, 401);
    }

    protected function respondForbidden(
        string $message = 'Forbidden'
    ): JsonResponse {
        return $this->respondError($message, 403);
    }

    protected function respondNotFound(
        string $message = 'Resource not found'
    ): JsonResponse {
        return $this->respondError($message, 404);
    }

    protected function respondValidationError(
        mixed $errors,
        string $message = 'Validation failed'
    ): JsonResponse {
        return $this->respondError($message, 422, $errors);
    }

    protected function respondServerError(
        string $message = 'Something went wrong'
    ): JsonResponse {
        return $this->respondError($message, 500);
    }

    protected function respondError(
        string $message,
        int $status,
        mixed $errors = null
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}
