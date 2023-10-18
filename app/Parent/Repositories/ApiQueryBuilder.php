<?php

declare(strict_types=1);

namespace App\Parent\Repositories;

use App\Parent\Transfers\RequestDto;
use Spatie\QueryBuilder\QueryBuilder;

final class ApiQueryBuilder extends QueryBuilder
{
    public function setRequestFromDto(RequestDto $requestDto): self
    {
        $this->initializeRequest($requestDto->toRequest());

        return $this;
    }
}
