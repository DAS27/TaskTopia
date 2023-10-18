<?php

declare(strict_types=1);

namespace App\Domain\Task;

use App\Domain\Task\Transfers\TaskDto;
use Carbon\Carbon;
use Spatie\LaravelData\DataCollection;

interface TaskFacadeInterface
{
    public function hasTitle(string $title): bool;

    public function getTaskByTitle(string $title): TaskDto;

    public function getTaskByUserId(int $userId): TaskDto;

    public function getTaskByStatusId(int $statusId): TaskDto;

    /**
     * @return DataCollection<int, TaskDto>
     */
    public function getAvailableTask(): DataCollection;

    public function getPreferredTaskByTitle(string $title): TaskDto;

    /**
     * @param  string[]  $titles
     * @return DataCollection<int, TaskDto>
     */
    public function findTasksByTitles(array $titles): DataCollection;

    public function updateTask(TaskDto $TaskDto): TaskDto;

    public function createTask(TaskDto $TaskDto): TaskDto;
}
