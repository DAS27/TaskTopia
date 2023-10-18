<?php

declare(strict_types=1);

namespace App\Domain\Task\Seeders;

use App\Domain\Task\Models\Task;
use App\Parent\Seeders\Seeder;

final class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'System design application', 'description' => 'Need to create architecture for application', 'user_id' => null, 'status_id' => null,
                'start_at' => null, 'finish_at' => null
            ],
            [
                'title' => 'Layout application', 'description' => 'Need to create design for application with web designers', 'user_id' => null, 'status_id' => null,
                'start_at' => null, 'finish_at' => null
            ],
            [
                'title' => 'Architecture database', 'description' => 'Need to create architecture for database', 'user_id' => null, 'status_id' => null,
                'start_at' => null, 'finish_at' => null
            ],
            [
                'title' => 'Meet with Mom', 'description' => 'Just sad I miss you', 'user_id' => null, 'status_id' => null,
                'start_at' => null, 'finish_at' => null
            ],
            [
                'title' => 'Need to buy milk', 'description' => null, 'user_id' => null, 'status_id' => null,
                'start_at' => null, 'finish_at' => null
            ],
        ];

        Task::insert($tasks);
    }
}
