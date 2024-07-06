<?php

namespace App\Filters;


use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterBookByCategory implements Filter{

    public function __invoke(Builder $query, $values, string $property)
    {
        /*
            check the values size so the whereIntegerInRaw doesn't break.
            !! throw custom exception in the future, and maybe log some info about the request.
        */
        if(count($values) > 100) return;

        $query->whereHas('bookCategories', function (Builder $query) use ($values) {
            $query->whereIntegerInRaw('book_categories.id',  $values);
        });
    }

}
