<?php

namespace App\Filters;


use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterBookByAuthor implements Filter{

    public function __invoke(Builder $query, $value, string $property)
    {

        $query->whereHas('author', function (Builder $query) use ($value) {
            $query->where('name', 'LIKE',  '%' . $value . '%');
        });
    }

}
