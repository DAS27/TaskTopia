<?php

declare(strict_types=1);

namespace App\Domain\Task\Business;

use App\Domain\Task\Business\Exception\TaskCacheNotFoundException;
use App\Domain\Task\Transfers\TaskDto;

final class TaskCache
{
    /**
     * @var array<TaskDto>
     */
    protected static array $storeTransfersCacheByTaskId = [];

    /**
     * @var array<TaskDto>
     */
    protected static array $storeTransferCacheByTaskTitle = [];

    public function hasTaskByTaskId(int $idTask): bool
    {
        return isset(self::$storeTransfersCacheByTaskId[$idTask]);
    }

    public function hasTaskByTitle(string $title): bool
    {
        return isset(self::$storeTransferCacheByTaskTitle[$title]);
    }

    public function cacheTask(TaskDto $taskDto): void
    {
        self::$storeTransferCacheByTaskTitle[$taskDto->title] = $taskDto;
        self::$storeTransfersCacheByTaskId[$taskDto->id] = $taskDto;
    }

    /**
     * Retrieves a task by its task ID.
     *
     * @param  int  $idTask  The ID of the task to retrieve.
     * @return TaskDto The task with the specified task ID.
     * @throws TaskCacheNotFoundException If the task is not found in the cache.
     */
    public function getTaskByTaskId(int $idTask): TaskDto
    {
        if (! $this->hasTaskByTaskId($idTask)) {
            throw new TaskCacheNotFoundException();
        }

        return self::$storeTransfersCacheByTaskId[$idTask];
    }

    /**
     * Retrieves a task by its title.
     *
     * @param  string  $title  The title of the task to retrieve.
     * @return TaskDto The task with the specified title.
     * @throws TaskCacheNotFoundException If the task is not found in the cache.
     */
    public function getTaskByTitle(string $title): TaskDto
    {
        if (! $this->hasTaskByTitle($title)) {
            throw new TaskCacheNotFoundException();
        }

        return self::$storeTransferCacheByTaskTitle[$title];
    }
}
