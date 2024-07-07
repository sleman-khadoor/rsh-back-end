<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Traits\Uploader;
use App\Models\BookAward;
use App\Models\BookReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Filters\FilterBookByCategory;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\Book\AdminBookResource;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Admin Endpoints')]
#[Subgroup('Book Management', 'APIs for managing Books')]
class BookController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->setResource(AdminBookResource::class);
    }

    #[Endpoint('Get all Books.')]
    #[QueryParam('filter[title]', 'string', 'filter Books by name.', false)]
    #[QueryParam('filter[ISBN]', 'string', 'filter Books by ISBN.', false)]
    #[QueryParam('filter[EISBN]', 'string', 'filter Books by EISBN.', false)]
    #[QueryParam('include[]', 'array', 'relations to load on the book', false, example: "['bookCategories', 'formats', 'awards', 'reviews']")]
    #[QueryParam('page', 'integer', 'The page number', example: 1)]
    #[QueryParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $books = QueryBuilder::for(Book::class)
                            ->allowedIncludes(Book::allowedIncludes())
                            ->allowedFilters([
                                ...Book::allowedFilters(),
                                AllowedFilter::custom('book_category', new FilterBookByCategory),
                                ])
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return $this->collection($books);
    }

    #[Endpoint('Get Book by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Book', true)]
    public function show(Book $book) {

        return $this->resource($book->load(Book::allowedIncludes()));
    }

    #[Endpoint('Store Book.')]
    #[BodyParam('title', 'array', 'The title of the Book.', example: ['en' => 'Book', 'ar' => 'كتاب'])]
    #[BodyParam('abstract', 'array', 'The abstract of the Book.', example: ['en' => 'about the book', 'ar' => 'حول الكتاب'])]
    #[BodyParam('ISBN', 'string', 'The ISBN of the Book.')]
    #[BodyParam('EISBN', 'string', 'The EISBN of the Book.')]
    #[BodyParam('printing_year', 'string', 'The printing year of the Book.')]
    #[BodyParam('cover_image', 'file', 'The cover image of the Book.')]
    #[BodyParam('author_id', 'int', 'The author id of the Book.')]
    #[BodyParam('formats', 'array', 'The formats of the Book.')]
    #[BodyParam('formats.*.id', 'int', 'The id of the format.')]
    #[BodyParam('categories', 'array', 'The categories of the Book.')]
    #[BodyParam('categories.*.id', 'int', 'The id of the category.')]
    #[BodyParam('awards', 'array', 'The awards of the Book.')]
    #[BodyParam('awards.*', 'array', 'The awards of the Book.', example:['en' => 'award', 'ar' => 'جائزة'])]
    #[BodyParam('reviews', 'array', 'The reviews of the Book.')]
    #[BodyParam('reviews.*username', 'string', 'The username of the Review.')]
    #[BodyParam('reviews.*review', 'array', 'The review of the Review.', example:['en' => 'review', 'ar' => 'مراجعة'])]
    public function store(StoreBookRequest $request) {

        $data = $request->validated();

        $book = Book::create($data);

        if($data['cover_image']) {
            $book->cover_image = $this->uploadAttachment($data['cover_image'], 'book-covers');
            $book->save();
        }

        if($data['categories']) {

            $book->bookCategories()->attach(Arr::flatten($data['categories']));
        }

        if($data['awards']) {

            $this->storeAwards($data['awards'], $book->id);
        }

        if($data['formats']) {

            $book->formats()->attach(Arr::flatten($data['formats']));
        }

        if($data['reviews']) {

            $this->storeReviews($data['reviews'], $book->id);
        }

        return $this->resource($book, method:'POST');
    }

    #[Endpoint('Update Book.')]
    #[UrlParam('slug', 'string', 'The slug of the Book', true)]
    #[BodyParam('title', 'array', 'The title of the Book.', example: ['en' => 'Book', 'ar' => 'كتاب'])]
    #[BodyParam('abstract', 'array', 'The abstract of the Book.', example: ['en' => 'about the book', 'ar' => 'حول الكتاب'])]
    #[BodyParam('ISBN', 'string', 'The ISBN of the Book.')]
    #[BodyParam('EISBN', 'string', 'The EISBN of the Book.')]
    #[BodyParam('printing_year', 'string', 'The printing year of the Book.')]
    #[BodyParam('cover_image', 'file', 'The cover image of the Book.')]
    #[BodyParam('author_id', 'int', 'The author id of the Book.')]
    #[BodyParam('formats', 'array', 'The formats of the Book.')]
    #[BodyParam('formats.*.id', 'int', 'The id of the format.')]
    #[BodyParam('categories', 'array', 'The categories of the Book.')]
    #[BodyParam('categories.*.id', 'int', 'The id of the category.')]
    #[BodyParam('awards', 'array', 'The awards of the Book.')]
    #[BodyParam('awards.*', 'array', 'The awards of the Book.', example:['en' => 'award', 'ar' => 'جائزة'])]
    #[BodyParam('reviews', 'array', 'The reviews of the Book.')]
    #[BodyParam('reviews.*username', 'string', 'The username of the Review.')]
    #[BodyParam('reviews.*review', 'array', 'The review of the Review.', example:['en' => 'review', 'ar' => 'مراجعة'])]
    public function update(UpdateBookRequest $request, Book $book) {

        $data = $request->validated();

        $book->update($data);

        if($data['cover_image']) {
            $book->cover_image = $this->uploadAttachment($data['cover_image'], 'book-covers');
            $book->save();
        }

        if($data['formats']) {

            $book->formats()->sync([]);
            $book->formats()->attach(Arr::flatten($data['formats']));
        }

        return $this->resource($book, method:'PUT');
    }

    #[Endpoint('Delete Book.')]
    #[UrlParam('slug', 'string', 'The slug of the Book', true)]
    public function destroy(Book $book) {

        $book->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }

    private function storeAwards(array $awards, int $bookId): void {

        foreach($awards as $award) {

            BookAward::create([
                'title' => [
                    'en' => $award['en'],
                    'ar' => $award['ar']
                ],
                'book_id' => $bookId
            ]);
        }
    }

    private function storeReviews(array $reviews, int $bookId): void {

        foreach($reviews as $review) {

            BookReview::create([
                'username' => $review['username'],
                'review' => [
                    'en' => $review['review']['en'],
                    'ar' => $review['review']['ar']
                ],
                'book_id' => $bookId
            ]);
        }
    }
}
