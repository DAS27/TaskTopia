<?php

declare(strict_types=1);

namespace App\Domain\Task\Repositories;

use App\Domain\Task\Transfers\TaskDto;

interface TaskEntityManagerInterface
{
    public function createTask(TaskDto $TaskDto): TaskDto;

    public function updateTask(TaskDto $TaskDto): TaskDto;

    public function deleteTask(int $id): void;
}
