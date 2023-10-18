<?php

declare(strict_types=1);

namespace App\Domain\Task;

use App\Domain\Task\Business\TaskReader;
use App\Domain\Task\Business\TaskWriter;
use App\Domain\Task\Transfers\TaskDto;
use App\Parent\Facades\AbstractFacade;
use Spatie\LaravelData\DataCollection;

final class TaskFacade extends AbstractFacade implements TaskFacadeInterface
{
    public function __construct(
        protected TaskReader $reader,
        protected TaskWriter $writer,
    ) {
    }

    public function hasTitle(string $title): bool
    {
        return $this->reader->taskExists($title);
    }

    public function getTaskByTitle(string $title): TaskDto
    {
        return $this->reader->getTaskByTitle($title);
    }

    public function getTaskByUserId(int $userId): TaskDto
    {
        return $this->reader->getTaskByUserId($userId);
    }

    public function getTaskByStatusId(int $statusId): TaskDto
    {
        return $this->reader->getTaskByStatusId($statusId);
    }

    /**
     * @return DataCollection<int, TaskDto>
     */
    public function getAvailableTask(): DataCollection
    {
        return $this->reader
            ->getAvailableTasks();
    }

    public function getPreferredTaskByTitle(string $title): TaskDto
    {
        return $this->reader
            ->getPreferredTaskByTitle($title);
    }

    /**
     * @param  string[]  $titles
     * @return DataCollection<int, TaskDto>
     */
    public function findTasksByTitles(array $titles): DataCollection
    {
        return $this->reader
            ->getTasksByTitles($titles);
    }

    public function updateTask(TaskDto $TaskDto): TaskDto
    {
        return $this->writer->updateTask($TaskDto);
    }

    public function createTask(TaskDto $TaskDto): TaskDto
    {
        return $this->writer->createTask($TaskDto);
    }

    /**
     * @return ?array<string, mixed>
     */
    public function transformTask(?TaskDto $TaskDto): ?array
    {
        return $this->reader->transformTransferToArray($TaskDto);
    }

    public function getFirstTask(): TaskDto
    {
        return $this->reader->getFirstTask();
    }
}
