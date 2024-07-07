<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookReview\StoreBookReviewRequest;
use App\Http\Requests\BookReview\UpdateBookReviewRequest;
use App\Http\Resources\BookReview\AdminBookReviewResource;
use App\Models\BookReview;
use Symfony\Component\HttpFoundation\Response;

class BookReviewController extends Controller
{
    public function __construct()
    {
        $this->setResource(AdminBookReviewResource::class);
    }

    public function store(StoreBookReviewRequest $request) {

        $bookReview = BookReview::create($request->validated());

        return $this->resource($bookReview, method:'POST');
    }

    public function update(UpdateBookReviewRequest $request, BookReview $bookReview) {

        $bookReview->update($request->validated());

        return $this->resource($bookReview, method:'PUT');
    }

    public function destroy(BookReview $bookReview) {

        $bookReview->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
