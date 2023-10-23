<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Status\Seeders\StatusSeeder;
use App\Domain\Task\Seeders\TaskSeeder;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StatusSeeder::class,
            TaskSeeder::class
        ]);
    }
}
