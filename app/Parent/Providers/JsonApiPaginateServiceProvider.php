<?php

declare(strict_types=1);

namespace App\Parent\Providers;

use App\Parent\Transfers\RequestDto;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

final class JsonApiPaginateServiceProvider extends ServiceProvider
{
    public function registerMacro(): void
    {
        $macro = function (RequestDto $requestDto) {
            $maxResults = config('json-api-paginate.max_results');
            $defaultSize = $requestDto->pageSize ?? config('json-api-paginate.default_size');
            $numberParameter = config('json-api-paginate.number_parameter');
            $cursorParameter = config('json-api-paginate.cursor_parameter');
            $sizeParameter = config('json-api-paginate.size_parameter');
            $paginationParameter = config('json-api-paginate.pagination_parameter');
            $paginationMethod = config('json-api-paginate.use_cursor_pagination')
                ? 'cursorPaginate'
                : (config('json-api-paginate.use_simple_pagination') ? 'simplePaginate' : 'paginate');
            $size = $defaultSize;

            $cursor = (string) $requestDto->cursor;

            if ($size > $maxResults) {
                $size = $maxResults;
            }

            /** @var array<string, string> $input */
            $input = request()->input();
            $paginator = $paginationMethod === 'cursorPaginate'
                ? $this->{$paginationMethod}($size, ['*'], $paginationParameter . '[' . $cursorParameter . ']', $cursor)
                    ->appends(Arr::except($input, $paginationParameter . '.' . $cursorParameter))
                : $this
                    ->{$paginationMethod}($size, ['*'], $paginationParameter . '.' . $numberParameter)
                    ->setPageName($paginationParameter . '[' . $numberParameter . ']')
                    ->appends(Arr::except($input, $paginationParameter . '.' . $numberParameter));

            if (! is_null(config('json-api-paginate.base_url'))) {
                $paginator->setPath(config('json-api-paginate.base_url'));
            }

            return $paginator;
        };
        /** @var string $method */
        $method = config('json-api-paginate.method_name');
        EloquentBuilder::macro($method, $macro);
        BaseBuilder::macro($method, $macro);
        BelongsToMany::macro($method, $macro);
        HasManyThrough::macro($method, $macro);
    }
}
