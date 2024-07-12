<?php

namespace App\Http\Controllers\Main;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Filters\FilterBookByAuthor;
use App\Http\Controllers\Controller;
use App\Filters\FilterBookByCategory;
use Knuckles\Scribe\Attributes\Group;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\QueryParam;
use App\Http\Resources\Book\PublicBookResource;

#[Group('Public Endpoints')]
#[Subgroup('Books', 'APIs for Books')]
class BookController extends Controller
{

    #[Endpoint('Get all Books.')]
    #[QueryParam('filter[title]', 'string', 'filter Books by name.', false)]
    #[QueryParam('filter[ISBN]', 'string', 'filter Books by ISBN.', false)]
    #[QueryParam('filter[EISBN]', 'string', 'filter Books by EISBN.', false)]
    #[QueryParam('filter[author]', 'string', 'filter Books by author.', false)]
    #[QueryParam('include[]', 'array', 'relations to load on the book', false, example: "['bookCategories', 'formats', 'awards', 'reviews']")]
    #[QueryParam('page', 'integer', 'The page number', example: 1)]
    #[QueryParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $books = QueryBuilder::for(Book::class)
                            ->allowedIncludes(Book::allowedIncludes())
                            ->allowedFilters([
                                ...Book::allowedFilters(),
                                AllowedFilter::custom('book_category', new FilterBookByCategory),
                                AllowedFilter::custom('author', new FilterBookByAuthor)
                                ])
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return PublicBookResource::collection($books);
    }

    #[Endpoint('Get Book by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Book', true)]
    public function show(Book $book) {

        return PublicBookResource::make($book->load(Book::allowedIncludes()));
    }
}
