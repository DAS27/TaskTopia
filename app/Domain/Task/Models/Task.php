<?php

declare(strict_types=1);

namespace App\Domain\Task\Models;

use App\Domain\Status\Models\Status;
use App\Models\User;
use App\Parent\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
