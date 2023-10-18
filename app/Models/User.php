<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Spatie\Permission\Traits\HasRoles;

final class User extends \App\Domain\User\Models\User
{
    use HasRoles;
}
