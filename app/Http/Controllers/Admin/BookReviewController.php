<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookReview\StoreBookReviewRequest;
use App\Http\Requests\BookReview\UpdateBookReviewRequest;
use App\Http\Resources\BookReview\AdminBookReviewResource;
use App\Models\BookReview;
use Symfony\Component\HttpFoundation\Response;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;

#[Group('Admin Endpoints')]
#[Subgroup('Book Reviews Management', 'APIs for managing Book Reviews')]
class BookReviewController extends Controller
{
    public function __construct()
    {
        $this->setResource(AdminBookReviewResource::class);
    }

    #[Endpoint('Store Book Review.')]
    #[BodyParam('username', 'array', 'The username of the Book Review.')]
    #[BodyParam('review', 'array', 'The review of the Book Review.')]
    #[BodyParam('book_id', 'integer', 'The id of the Book.')]
    public function store(StoreBookReviewRequest $request) {

        $bookReview = BookReview::create($request->validated());

        return $this->resource($bookReview, method:'POST');
    }

    #[Endpoint('Update Book Review.')]
    #[BodyParam('username', 'array', 'The username of the Book Review.')]
    #[BodyParam('review', 'array', 'The review of the Book Review.')]
    public function update(UpdateBookReviewRequest $request, BookReview $bookReview) {

        $bookReview->update($request->validated());

        return $this->resource($bookReview, method:'PUT');
    }

    #[Endpoint('Delete Book Review.')]
    #[UrlParam('id', 'integer', 'The ID of the book review', true)]
    public function destroy(BookReview $bookReview) {

        $bookReview->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
