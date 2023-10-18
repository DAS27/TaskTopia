<?php

declare(strict_types=1);

namespace App\Parent\Configs;

abstract class KernelConfig
{
    /**
     * @return string[]
     */
    abstract public function getAllowedSorts(): array;
}
