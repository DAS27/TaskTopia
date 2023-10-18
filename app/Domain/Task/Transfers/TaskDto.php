<?php

declare(strict_types=1);

namespace App\Domain\Task\Transfers;

use App\Parent\Transfers\Transfer;
use Carbon\Carbon;

final class TaskDto extends Transfer
{
    public function __construct(
        public ?int $id,
        public string $title,
        public ?string $description,
        public ?int $user_id = null,
        public ?int $status_id = null,
        public ?Carbon $start_at = null,
        public ?Carbon $finish_at = null,
    ) {
    }
}
