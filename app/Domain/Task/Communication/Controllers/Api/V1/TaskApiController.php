<?php

declare(strict_types=1);

namespace App\Domain\Task\Communication\Controllers\Api\V1;

use App\Domain\Task\Business\TaskReader;
use App\Domain\Task\Processors\Transformer\TaskTransformer;
use App\Domain\Task\TaskConfig;
use App\Parent\Controllers\ApiController;
use App\Parent\Requests\IndexRequest;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

final class TaskApiController extends ApiController
{
    #[Get('/tasks', name: 'api.v1.tasks')]
    public function index(IndexRequest $request, TaskReader $reader): JsonResponse
    {
        $tasks = $reader->getTaskCollection($request->toDto());

        return fractal($tasks->items(), new TaskTransformer())
            ->withResourceName(TaskConfig::DOMAIN_NAME)
            ->respond();
    }
}
