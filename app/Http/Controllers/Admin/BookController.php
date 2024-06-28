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
use Symfony\Component\HttpFoundation\Response;


class BookController extends Controller
{
    use Uploader;

    public function index(Request $request) {

        $books = QueryBuilder::for(Book::class)
                            ->allowedIncludes(Book::allowedIncludes())
                            ->allowedFilters([
                                AllowedFilter::custom('book_category', new FilterBookByCategory),
                                'title', 'ISBN', 'EISBN'])
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return AdminBookResource::collection($books);
    }

    public function show(Book $book) {

        return AdminBookResource::make($book->load(Book::allowedIncludes()));
    }

    public function store(StoreBookRequest $request) {

        $book = Book::create($this->extractBookData($request));

        if($request->hasFile('cover_image')) {
            $book->cover_image = $this->uploadAttachment($request->file('cover_image'), 'book-covers');
            $book->save();
        }

        if($request->has('awards')) {

            $this->storeAwards($request->validated('awards'), $book->id);
        }

        if($request->has('formats')) {

            $this->storeFormats($request->validated('formats'), $book->id);
        }

        if($request->has('reviews')) {

            $this->storeReviews($request->validated('reviews'), $book->id);
        }

        return AdminBookResource::make($book);
    }

    public function update(UpdateBookRequest $request, Book $book) {

        $book->update($this->extractBookData($request));

        if($request->hasFile('cover_image')) {
            $book->cover_image = $this->uploadAttachment($request->file('cover_image'), 'book-covers');
            $book->save();
        }

        if($request->has('formats')) {

            $book->formats()->sync([]);
            $this->storeFormats($request->validated('formats'), $book->id);
        }

        return AdminBookResource::make($book);
    }

    public function destroy(Book $book) {

        $book->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }

    private function extractBookData(Request $request): array {

        return [
            'title' => [
                'ar' => $request->validated('title.ar'),
                'en' => $request->validated('title.en'),
            ],
            'abstract' => [
                'ar' => $request->validated('abstract.ar'),
                'en' => $request->validated('abstract.en'),
            ],
            'ISBN' => $request->validated('ISBN'),
            'EISBN' => $request->validated('EISBN'),
            'printing_year' => $request->validated('printing_year'),
            'author_id' => $request->validated('author_id')
        ];
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

    private function storeFormats(array $formats, int $bookId): void {

        foreach($formats as $format) {

            DB::table('book_format')->insert([
                'book_id' => $bookId,
                'book_format_id' => $format['id']
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
