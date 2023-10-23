<?php

declare(strict_types=1);

namespace App\Domain\Task\Repositories;

use App\Domain\Task\Transfers\TaskDto;
use App\Parent\Transfers\RequestDto;
use Spatie\LaravelData\DataCollection;

interface TaskRepositoryInterface
{
    /**
     * @param  string[]  $titles
     * @return DataCollection<int, TaskDto>
     */
    public function getTasksByTitles(array $titles): DataCollection;

    /**
     * @return DataCollection<int, TaskDto>
     */
    public function getAvailableTasks(): DataCollection;

    public function findTaskById(int $id): ?TaskDto;

    public function findTaskByTitle(string $title): ?TaskDto;

    public function findTaskByUserId(int $userId): ?TaskDto;

    public function findTaskByStatusId(int $statusId): ?TaskDto;

    /**
     * @return DataCollection<int|string, TaskDto>
     */
    public function getTasksCollection(RequestDto $requestDto): DataCollection;

    public function getFirstTask(): TaskDto;
}
