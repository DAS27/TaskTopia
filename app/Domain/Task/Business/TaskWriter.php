<?php

declare(strict_types=1);

namespace App\Domain\Task\Business;

use App\Domain\Task\Transfers\TaskDto;
use App\Domain\Task\Repositories\TaskEntityManagerInterface;

final class TaskWriter
{
    public function __construct(
        protected TaskEntityManagerInterface $entityManager,
    ) {
    }

    public function createTask(TaskDto $TaskDto): TaskDto
    {
        return $this->entityManager->createTask($TaskDto);
    }

    public function updateTask(TaskDto $TaskDto): TaskDto
    {
        return $this->entityManager->updateTask($TaskDto);
    }

    public function deleteTask(int $id): void
    {
        $this->entityManager->deleteTask($id);
    }
}
