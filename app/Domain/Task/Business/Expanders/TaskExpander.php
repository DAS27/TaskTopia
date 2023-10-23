<?php

declare(strict_types=1);

namespace App\Domain\Task\Business\Expanders;

use App\Domain\Task\Transfers\TaskDto;
use Spatie\LaravelData\DataCollection;

final class TaskExpander
{
    public function expandTask(TaskDto $taskTransfer): TaskDto
    {
        return $taskTransfer;
    }

    /**
     * @param  DataCollection<int|string, TaskDto>  $taskTransfers
     * @return DataCollection<int|string, TaskDto>
     */
    public function expandTasks(DataCollection $taskTransfers): DataCollection
    {
        foreach ($taskTransfers as $key => $taskTransfer) {
            $taskTransfers[$key] = $this->expandTask($taskTransfer);
        }

        return $taskTransfers;
    }
}
