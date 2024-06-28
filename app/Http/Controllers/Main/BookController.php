<?php

namespace App\Http\Controllers\Main;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Filters\FilterBookByCategory;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Resources\Book\PublicBookResource;

class BookController extends Controller
{
    public function index(Request $request) {

        $books = QueryBuilder::for(Book::class)
                            ->allowedIncludes(Book::allowedIncludes())
                            ->allowedFilters([
                                AllowedFilter::custom('book_category', new FilterBookByCategory),
                                'title', 'ISBN', 'EISBN'])
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return PublicBookResource::collection($books);
    }

    public function show(Book $book) {

        return PublicBookResource::make($book->load(Book::allowedIncludes()));
    }
}
