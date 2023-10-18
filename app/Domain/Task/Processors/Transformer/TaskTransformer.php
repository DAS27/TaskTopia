<?php

declare(strict_types=1);

namespace App\Domain\Task\Processors\Transformer;

use App\Domain\Task\Transfers\TaskDto;
use League\Fractal\TransformerAbstract;

final class TaskTransformer extends TransformerAbstract
{
    /** @var string[] */
    protected array $defaultIncludes = [];

    /** @var string[] */
    protected array $availableIncludes = [];

    /**
     * @return array<string, string|int|bool|null>
     */
    public function transform(TaskDto $task): array
    {
        return [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'user_id' => $task->user_id,
            'status_id' => $task->status_id,
            'start_at' => $task->start_at,
            'finish_at' => $task->finish_at,
        ];
    }
}
