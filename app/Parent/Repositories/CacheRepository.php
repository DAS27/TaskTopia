<?php

declare(strict_types=1);

namespace App\Parent\Repositories;

use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

abstract class CacheRepository extends Repository implements CacheableInterface
{
    use CacheableRepository;
}
