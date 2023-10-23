<?php

declare(strict_types=1);

namespace App\Domain\Task\Seeders;

use App\Domain\Status\Models\Status;
use App\Domain\Task\Models\Task;
use App\Parent\Seeders\Seeder;
use Carbon\Carbon;

final class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $status = Status::firstOrFail();

        $tasks = [
            [
                'title' => 'System design application', 'description' => 'Need to create architecture for application', 'user_id' => null, 'status_id' => $status->id,
                'start_at' => null, 'finish_at' => null, 'create_at' => Carbon::now(), 'update_at' => Carbon::now()
            ],
            [
                'title' => 'Layout application', 'description' => 'Need to create design for application with web designers', 'user_id' => null, 'status_id' => $status->id,
                'start_at' => null, 'finish_at' => null, 'create_at' => Carbon::now(), 'update_at' => Carbon::now()
            ],
            [
                'title' => 'Architecture database', 'description' => 'Need to create architecture for database', 'user_id' => null, 'status_id' => $status->id,
                'start_at' => null, 'finish_at' => null, 'create_at' => Carbon::now(), 'update_at' => Carbon::now()
            ],
            [
                'title' => 'Meet with Mom', 'description' => 'Just sad I miss you', 'user_id' => null, 'status_id' => $status->id,
                'start_at' => null, 'finish_at' => null, 'create_at' => Carbon::now(), 'update_at' => Carbon::now()
            ],
            [
                'title' => 'Need to buy milk', 'description' => null, 'user_id' => null, 'status_id' => $status->id,
                'start_at' => null, 'finish_at' => null, 'create_at' => Carbon::now(), 'update_at' => Carbon::now()
            ],
        ];

        Task::insert($tasks);
    }
}
