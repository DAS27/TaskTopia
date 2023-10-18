<?php

declare(strict_types=1);

namespace App\Parent\Transfers;

final class MessageDto extends Transfer
{
    /**
     * @param  array<string, string>  $parameters
     */
    public function __construct(
        public ?string $type = null,
        public ?string $value = null,
        public ?string $message = null,
        public array $parameters = []
    ) {
    }
}
