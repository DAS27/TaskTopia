<?php

declare(strict_types=1);

namespace App\Domain\Task\Repositories;

use App\Domain\Task\Models\Task;
use App\Domain\Task\TaskConfig;
use App\Domain\Task\Transfers\TaskDto;
use App\Parent\Repositories\ApiQueryBuilder;
use App\Parent\Repositories\EloquentRepository;
use App\Parent\Transfers\RequestDto;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

final class TaskRepository extends EloquentRepository implements TaskRepositoryInterface
{
    /**
     * @param  string[]  $titles
     * @return DataCollection<int, TaskDto>
     */
    public function getTasksByTitles(array $titles): DataCollection
    {
        return TaskDto::collection(Task::whereIn('title', $titles)->get()->toArray());
    }

    /**
     * @return DataCollection<int, TaskDto>
     */
    public function getAvailableTasks(): DataCollection
    {
        return TaskDto::collection(Task::all()->toArray());
    }

    public function findTaskByTitle(string $title): ?TaskDto
    {
        $task = Task::where('title', $title)->first();

        if (! $task) {
            return null;
        }

        return TaskDto::from($task);
    }

    public function findTaskByUserId(int $userId): ?TaskDto
    {
        $task = Task::where('user_id', $userId)->first();

        if (! $task) {
            return null;
        }

        return TaskDto::from($task);
    }

    public function findTaskByStatusId(int $statusId): ?TaskDto
    {
        $task = Task::where('status_id', $statusId)->first();

        if (! $task) {
            return null;
        }

        return TaskDto::from($task);
    }

    /**
     * @return DataCollection<(int|string), TaskDto>
     */
    public function getTasksCollection(RequestDto $requestDto): DataCollection
    {
        $config = app(TaskConfig::class);

        /** @var Task[] $result */
        $items = ApiQueryBuilder::for(Task::class)
                ->setRequestFromDto($requestDto)
                ->allowedSorts($config->getAllowedSorts())
                ->allowedFilters($config->getAllowedFilters())
                ->with(['user', 'status'])
                ->get();

        /** @var DataCollection<int|string, TaskDto> $result */
        $result = TaskDto::collection($items)->include('user', 'status');

        return $result;
    }

    public function getFirstTask(): TaskDto
    {
        return TaskDto::from(Task::firstOrFail());
    }

    public function findTaskById(int $id): ?TaskDto
    {
        $task = Task::with(['user', 'status'])->find($id);

        if (! $task) {
            return null;
        }

        return TaskDto::from($task)->include('user', 'status');
    }
}
