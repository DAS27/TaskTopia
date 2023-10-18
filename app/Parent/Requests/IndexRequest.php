<?php

declare(strict_types=1);

namespace App\Parent\Requests;

use App\Parent\Transfers\RequestDto;
use Illuminate\Foundation\Http\FormRequest;

final class IndexRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'sort' => ['nullable', 'string'],
            'page' => ['nullable', 'array'],
            'page.size' => ['nullable', 'numeric'],
            'page.number' => ['nullable', 'numeric'],
            'page.cursor' => ['nullable', 'string'],
            'page.offset' => ['nullable', 'numeric'],
            'filter' => ['nullable', 'array'],
            'fields' => ['nullable', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): RequestDto
    {
        /** @var ?string $sort */
        $sort = $this->input('sort');
        /** @var ?string $language */
        $language = $this->input('accept_language');
        /** @var ?string $region */
        $region = $this->input('accept_region');
        /** @var ?int $number */
        $number = $this->input('page.number');
        /** @var ?int $size */
        $size = $this->input('page.size');
        /** @var ?int $offset */
        $offset = $this->input('page.offset');
        /** @var ?string $cursor */
        $cursor = $this->input('page.cursor');
        /** @var array<string, string> $filter */
        $filter = $this->input('filter');
        /** @var array<string, string> $fields */
        $fields = $this->input('fields');

        return new RequestDto(
            sort: $sort,
            pageNumber: $number ? (int) $number : null,
            pageSize: $size ? (int) $size : null,
            cursor: $cursor,
            offset: $offset ? (int) $offset : null,
            filter: $filter,
            fields: $fields,
        );
    }
}
