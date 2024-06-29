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
    public function store(StoreBookReviewRequest $request) {

        $bookReview = BookReview::create([
            'username' => [
                'en' => $request->validated('username.en'),
                'ar' => $request->validated('username.ar'),
            ],
            'review' => [
                'en' => $request->validated('review.en'),
                'ar' => $request->validated('review.ar'),
            ],
            'book_id' => $request->validated('book_id')
        ]);

        return AdminBookReviewResource::make($bookReview);
    }

    public function update(UpdateBookReviewRequest $request, BookReview $bookReview) {

        $bookReview->update([
            'username' => [
                'en' => $request->validated('username.en'),
                'ar' => $request->validated('username.ar'),
            ],
            'review' => [
                'en' => $request->validated('review.en'),
                'ar' => $request->validated('review.ar'),
            ],
        ]);

        return AdminBookReviewResource::make($bookReview);
    }

    public function destroy(BookReview $bookReview) {

        $bookReview->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
