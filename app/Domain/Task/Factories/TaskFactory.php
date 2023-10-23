<?php

declare(strict_types=1);

namespace App\Domain\Task\Factories;

use App\Domain\Task\Models\Task;
use App\Parent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Task>
 */
final class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->title(),
            'description' => $this->faker->text(),
            'user_id' => null,
            'status_id' => null,
            'start_at' => null,
            'finish_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
