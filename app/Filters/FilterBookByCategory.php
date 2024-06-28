<?php

namespace App\Filters;


use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;


class FilterBookByCategory implements Filter{

    public function __invoke(Builder $query, $values, string $property)
    {
        $query->whereHas('bookCategories', function (Builder $query) use ($values) {
            $query->whereIn('id',  $values);
        });
    }

}
