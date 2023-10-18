<?php

declare(strict_types=1);

namespace App\Parent\Fractal;

use Illuminate\Http\JsonResponse;

final class Fractal extends \Spatie\Fractal\Fractal
{
    /**
     * @param  callable|array<string, string>  $headers
     */
    public function respond(
        callable|int $statusCode = 200,
        callable|array $headers = [],
        callable|int $options = 0
    ): JsonResponse {
        $response = parent::respond($statusCode, $headers, $options);
        $response->header('content-type', ['application/vnd.api+json']);

        return $response;
    }
}
