<?php

declare(strict_types=1);

namespace App\Parent\Transfers;

/**
 * @template T of Transfer
 */
final class ResponseDto extends Transfer
{
    /**
     * @param  bool  $is_successful
     * @param  MessageDto[]  $messages
     * @param  Transfer|null  $value
     */
    public function __construct(
        public bool $is_successful = false,
        public array $messages = [],
        public ?Transfer $value = null,
    ) {
    }

    /**
     * @return $this<T>
     */
    public function addMessage(MessageDto $messageDto): self
    {
        $this->messages[] = $messageDto;

        return $this;
    }
}
