<?php

declare(strict_types=1);

namespace App\Domain\Task\Repositories;

use App\Domain\Task\Transfers\TaskDto;
use App\Parent\Transfers\RequestDto;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

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

    public function findTaskByTitle(string $title): ?TaskDto;

    public function findTaskByUserId(int $userId): ?TaskDto;

    public function findTaskByStatusId(int $statusId): ?TaskDto;

    /**
     * @return PaginatedDataCollection<int|string, TaskDto>
     */
    public function getTaskCollection(RequestDto $requestDto): PaginatedDataCollection;

    public function getFirstTask(): TaskDto;
}
