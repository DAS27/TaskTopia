<?php

declare(strict_types=1);

namespace App\Parent\Transfers;

use Illuminate\Http\Request;

final class RequestDto extends Transfer
{
    /**
     * @param  array<string, string>|null  $filter
     * @param  array<string, string>|null  $fields
     */
    public function __construct(
        public ?string $sort = null,
        public ?int $pageNumber = null,
        public ?int $pageSize = null,
        public ?string $cursor = null,
        public ?int $offset = null,
        public ?array $filter = null,
        public ?array $fields = null,
    ) {
    }

    public function toRequest(): Request
    {
        $request = new Request();
        $request->replace([
            'sort' => $this->sort,
            'page' => [
                'number' => $this->pageNumber,
                'size' => $this->pageSize,
            ],
            'filter' => $this->filter,
            'fields' => $this->fields,
        ]);

        return $request;
    }

    public function getCacheCode(): string
    {
        return md5($this->toJson());
    }
}
