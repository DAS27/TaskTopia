<?php

declare(strict_types=1);

namespace App\Domain\Task\Business;

use App\Domain\Task\Business\Expanders\TaskExpander;
use App\Domain\Task\Processors\Transformer\TaskTransformer;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Domain\Task\Transfers\TaskDto;
use App\Parent\Transfers\RequestDto;
use Spatie\LaravelData\DataCollection;

final class TaskReader
{
    public function __construct(
        protected TaskRepositoryInterface $repository,
        protected TaskCache $taskCache,
        protected TaskExpander $taskExpander
    ) {
    }

    /**
     * @return DataCollection<int, TaskDto>
     */
    public function getAvailableTasks(): DataCollection
    {
        $tasks = $this->repository->getTasksCollection(new RequestDto());
        $tasks = $this->taskExpander->expandTasks($tasks);
        $this->cacheTaskTransfers($tasks->items());

        return $tasks;
    }

    /**
     * @param  string[]  $titles
     * @return DataCollection<int, TaskDto>
     */
    public function getTasksByTitles(array $titles): DataCollection
    {
        return $this->repository->getTasksByTitles($titles);
    }


    public function getTaskById(int $idTask): TaskDto
    {
        if ($this->taskCache->hasTaskByTaskId($idTask)) {
            return $this->taskCache->getTaskByTaskId($idTask);
        }

        $taskTransfer = $this->repository
            ->findTaskById($idTask);

        if (! $taskTransfer) {
            abort(404, sprintf('Task with id "%s" not found!', $idTask));
        }

        $taskTransfer = $this->taskExpander->expandTask($taskTransfer);
        $this->taskCache->cacheTask($taskTransfer);

        return $taskTransfer;
    }

    public function getTaskByTitle(string $title): TaskDto
    {
        $taskTransfer = $this->repository->findTaskByTitle($title);

        if ($taskTransfer === null) {
            abort(404, 'Task with title' . $title . ' not found');
        }

        return $taskTransfer;
    }

    public function getTaskByUserId(int $userId): TaskDto
    {
        $taskTransfer = $this->repository->findTaskByUserId($userId);

        if ($taskTransfer === null) {
            abort(404, 'Task with user id' . $userId . ' not found');
        }

        return $taskTransfer;
    }

    public function getTaskByStatusId(int $statusId): TaskDto
    {
        $taskTransfer = $this->repository->findTaskByStatusId($statusId);

        if ($taskTransfer === null) {
            abort(404, 'Task with status id' . $statusId . ' not found');
        }

        return $taskTransfer;
    }

    public function taskExists(string $title): bool
    {
        return $this->repository->findTaskByTitle($title) !== null;
    }

    public function getPreferredTaskByTitle(string $taskName): TaskDto
    {
        $taskTransfer = $this->repository->findTaskByTitle($taskName);

        if ($taskTransfer === null) {
            abort(404, 'Task with title' . $taskName . ' not found');
        }

        return $taskTransfer;
    }

    public function getFirstTask(): TaskDto
    {
        return $this->repository->getFirstTask();
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

    /**
     * @param  TaskDto[]  $tasks
     */
    protected function cacheTaskTransfers(array $tasks): void
    {
        foreach ($tasks as $region) {
            $this->taskCache->cacheTask($region);
        }
    }
}
