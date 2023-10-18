<?php

declare(strict_types=1);

namespace App\Domain\Task;

use App\Parent\Configs\KernelConfig;

final class TaskConfig extends KernelConfig
{
    public const DOMAIN_NAME = 'tasks';

    /**
     * @return string[]
     */
    public function getAllowedSorts(): array
    {
        return ['id', 'title', 'status_id', 'user_id', 'created_at'];
    }
}
