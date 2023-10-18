<?php

declare(strict_types=1);

namespace App\Domain\Task\Repositories;

use App\Domain\Task\TaskConfig;
use App\Domain\Task\Transfers\TaskDto;
use App\Parent\Repositories\CacheRepository;
use App\Parent\Transfers\RequestDto;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

final class TaskCacheRepository extends CacheRepository implements TaskRepositoryInterface
{
    protected TaskRepositoryInterface $repository;

    public function __construct(Application $app)
    {
        $this->repository = app(TaskRepository::class);
        parent::__construct($app);
    }

    /**
     * @param  string[]  $titles
     * @return DataCollection<int, TaskDto>
     */
    public function getTasksByTitles(array $titles): DataCollection
    {
        return $this->repository->getTasksByTitles($titles);
    }

    /**
     * @return DataCollection<int, TaskDto>
     */
    public function getAvailableTasks(): DataCollection
    {
        return Cache::tags([TaskConfig::DOMAIN_NAME])
            ->remember(TaskConfig::DOMAIN_NAME, Carbon::parse('1 week'), fn () => $this->repository->getAvailableTasks());
    }

    public function findTaskByTitle(string $title): ?TaskDto
    {
        return Cache::tags(['task'])
            ->remember(TaskConfig::DOMAIN_NAME . ':' . $title, Carbon::parse('2 weeks'), fn () => $this->repository->findTaskByTitle($title));
    }

    public function findTaskByUserId(int $userId): ?TaskDto
    {
        return Cache::tags(['task'])
            ->remember(TaskConfig::DOMAIN_NAME . ':' . $userId, Carbon::parse('2 weeks'), fn () => $this->repository->findTaskByUserId($userId));
    }

    public function findTaskByStatusId(int $statusId): ?TaskDto
    {
        return Cache::tags(['task'])
            ->remember(TaskConfig::DOMAIN_NAME . ':' . $statusId, Carbon::parse('2 weeks'), fn () => $this->repository->findTaskByStatusId($statusId));
    }

    /**
     * @return PaginatedDataCollection<int|string, TaskDto>
     */
    public function getTaskCollection(RequestDto $requestDto): PaginatedDataCollection
    {
        return Cache::tags([TaskConfig::DOMAIN_NAME])->remember(
            TaskConfig::DOMAIN_NAME . ':' . $requestDto->getCacheCode(),
            Carbon::parse('2 weeks'),
            fn () => $this->repository->getTaskCollection($requestDto)
        );
    }

    public function getFirstTask(): TaskDto
    {
        return $this->repository->getFirstTask();
    }
}
