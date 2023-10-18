<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Parent\Configs\KernelConfig;

final class UserConfig extends KernelConfig
{
    public const DOMAIN_NAME = 'users';

    /**
     * @return string[]
     */
    public function getAllowedSorts(): array
    {
        return [];
    }
}
