<?php

namespace App\Shared\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait ApiResourceTrait
{
    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->setData([
            'success' => true,
            'message' => $this->resourceMessage(),
            'data' => $response->getData(true)['data'] ?? $response->getData(true),
        ]);
    }

    protected function resourceMessage(): string
    {
        return 'Data fetched successfully';
    }
}