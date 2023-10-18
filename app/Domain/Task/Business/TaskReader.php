<?php

declare(strict_types=1);

namespace App\Domain\Task\Business;

use App\Domain\Task\Processors\Transformer\TaskTransformer;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\Transfers\TaskDto;
use App\Parent\Transfers\RequestDto;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

final class TaskReader
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository,
    ) {
    }

    /**
     * @return DataCollection<int, TaskDto>
     */
    public function getAvailableTasks(): DataCollection
    {
        return $this->taskRepository->getAvailableTasks();
    }

    /**
     * @param  string[]  $titles
     * @return DataCollection<int, TaskDto>
     */
    public function getTasksByTitles(array $titles): DataCollection
    {
        return $this->taskRepository->getTasksByTitles($titles);
    }

    public function getTaskByTitle(string $title): TaskDto
    {
        $taskTransfer = $this->taskRepository->findTaskByTitle($title);

        if ($taskTransfer === null) {
            abort(404, 'Task with title' . $title . ' not found');
        }

        return $taskTransfer;
    }

    public function getTaskByUserId(int $userId): TaskDto
    {
        $taskTransfer = $this->taskRepository->findTaskByUserId($userId);

        if ($taskTransfer === null) {
            abort(404, 'Task with user id' . $userId . ' not found');
        }

        return $taskTransfer;
    }

    public function getTaskByStatusId(int $statusId): TaskDto
    {
        $taskTransfer = $this->taskRepository->findTaskByStatusId($statusId);

        if ($taskTransfer === null) {
            abort(404, 'Task with status id' . $statusId . ' not found');
        }

        return $taskTransfer;
    }

    public function taskExists(string $title): bool
    {
        return $this->taskRepository->findTaskByTitle($title) !== null;
    }

    public function getPreferredTaskByTitle(string $taskName): TaskDto
    {
        $taskTransfer = $this->taskRepository->findTaskByTitle($taskName);

        if ($taskTransfer === null) {
            abort(404, 'Task with title' . $taskName . ' not found');
        }

        return $taskTransfer;
    }

    /**
     * @return PaginatedDataCollection<int|string, TaskDto>
     */
    public function getTaskCollection(
        RequestDto $requestDto
    ): PaginatedDataCollection {
        return $this->taskRepository->getTaskCollection($requestDto);
    }

    public function getFirstTask(): TaskDto
    {
        return $this->taskRepository->getFirstTask();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function transformTransferToArray(?TaskDto $TaskDto): ?array
    {
        if (! $TaskDto) {
            return null;
        }

        return (new TaskTransformer())->transform($TaskDto);
    }
}
