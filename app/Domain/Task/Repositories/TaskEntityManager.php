<?php

declare(strict_types=1);

namespace App\Domain\Task\Repositories;

use App\Domain\Task\TaskConfig;
use App\Domain\Task\Models\Task;
use App\Domain\Task\Transfers\TaskDto;
use App\Parent\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Cache;

final class TaskEntityManager extends EloquentRepository implements TaskEntityManagerInterface
{
    public function createTask(TaskDto $taskDto): TaskDto
    {
        return TaskDto::from(Task::create($taskDto->toArray()));
    }

    public function updateTask(TaskDto $taskDto): TaskDto
    {
        $task = Task::findOrFail($taskDto->title);
        $task->update($taskDto->toArray());
        $this->clearCache($taskDto);

        return TaskDto::from($task);
    }

    public function deleteTask(int $id): void
    {
        Task::findOrFail($id)->delete();
        $this->clearCache(null);
    }

    protected function clearCache(?TaskDto $dto): void
    {
        Cache::tags([TaskConfig::DOMAIN_NAME])->flush();
        if ($dto) {
            Cache::forget(TaskConfig::DOMAIN_NAME . ':' . $dto->title);
            Cache::forget(TaskConfig::DOMAIN_NAME . ':' . $dto->user_id);
            Cache::forget(TaskConfig::DOMAIN_NAME . ':' . $dto->status_id);
        }
    }
}
