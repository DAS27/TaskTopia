<?php

declare(strict_types=1);

namespace App\Domain\Task\Models;

use App\Parent\Models\Model;

final class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'status_id',
        'start_at',
        'finish_at',
    ];

    public function getId(): int|string
    {
        return $this->id;
    }
}
