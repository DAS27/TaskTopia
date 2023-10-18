<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Task\Repositories\TaskEntityManager;
use App\Domain\Task\Repositories\TaskEntityManagerInterface;
use App\Domain\Task\Repositories\TaskRepository;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TaskEntityManagerInterface::class, TaskEntityManager::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
