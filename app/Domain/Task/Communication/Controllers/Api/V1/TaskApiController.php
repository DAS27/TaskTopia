<?php

declare(strict_types=1);

namespace App\Domain\Task\Communication\Controllers\Api\V1;

use App\Domain\Task\Business\TaskReader;
use App\Domain\Task\Business\TaskWriter;
use App\Domain\Task\Communication\Requests\TaskCreateRequest;
use App\Domain\Task\Communication\Requests\TaskEditRequest;
use App\Domain\Task\Processors\Transformer\TaskTransformer;
use App\Domain\Task\TaskConfig;
use App\Domain\Task\Transfers\TaskDto;
use App\Parent\Controllers\ApiController;
use App\Parent\Requests\IndexRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Put;
use Symfony\Component\HttpFoundation\Response;

final class TaskApiController extends ApiController
{
    #[Get('/tasks', name: 'api.v1.tasks')]
    public function index(IndexRequest $request, TaskReader $reader): JsonResponse
    {
        $tasks = $reader->getAvailableTasks();

        return fractal($tasks->items(), new TaskTransformer())
            ->withResourceName(TaskConfig::DOMAIN_NAME)
            ->respond();
    }

    #[Get('/tasks/{id}', name: 'api.v1.tasks.show')]
    public function show(int $id, TaskReader $reader): JsonResponse
    {
        $task = $reader->getTaskById($id);

        return fractal($task, new TaskTransformer())
            ->withResourceName(TaskConfig::DOMAIN_NAME)
            ->respond();
    }

    #[Post('/tasks', name: 'api.v1.tasks.create')]
    public function create(TaskCreateRequest $request, TaskWriter $writer): JsonResponse
    {
        /** @var array<string, string|Carbon> $params */
        $params = $request->all();
        $params['created_at'] = Carbon::now();
        $params['updated_at'] = Carbon::now();

        $taskDto = TaskDto::from($params);

        $task = $writer->createTask($taskDto);

        return fractal($task, new TaskTransformer())
            ->withResourceName(TaskConfig::DOMAIN_NAME)
            ->respond(Response::HTTP_CREATED);
    }

    #[Put('/tasks/{id}', name: 'api.v1.tasks.update')]
    public function update(
        int $id,
        TaskEditRequest $request,
        TaskWriter $writer,
        TaskReader $reader
    ): JsonResponse
    {
        $task = $reader->getTaskById($id);

        if ($task) {
            /** @var array<string, string|Carbon> $params */
            $params = $request->all();
            $params['updated_at'] = Carbon::now();

            $taskDto = TaskDto::from($params);

            $newData = $writer->updateTask($taskDto);

            return fractal($newData, new TaskTransformer())
                ->withResourceName(TaskConfig::DOMAIN_NAME)
                ->respond(Response::HTTP_OK);
        }

    }

    #[Delete('/tasks/{id}', name: 'api.v1.tasks.delete')]
    public function delete(int $id, TaskWriter $writer): JsonResponse
    {
        $writer->deleteTask($id);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }

}
