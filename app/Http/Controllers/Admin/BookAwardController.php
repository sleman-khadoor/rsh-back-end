<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookAward\StoreBookAwardRequest;
use App\Http\Requests\BookAward\UpdateBookAwardRequest;
use App\Http\Resources\BookAward\AdminBookAwardResource;
use App\Models\BookAward;
use Symfony\Component\HttpFoundation\Response;


class BookAwardController extends Controller
{
    public function store(StoreBookAwardRequest $request) {

        $bookAward = BookAward::create([
            'title' => [
                'en' => $request->validated('title.en'),
                'ar' => $request->validated('title.ar'),
            ],
            'book_id' => $request->validated('book_id')
        ]);

        return AdminBookAwardResource::make($bookAward);
    }

    public function update(UpdateBookAwardRequest $request, BookAward $bookAward) {

        $bookAward->update([
            'title' => [
                'en' => $request->validated('title.en'),
                'ar' => $request->validated('title.ar'),
            ],
        ]);

        return AdminBookAwardResource::make($bookAward);
    }

    public function destroy(BookAward $bookAward) {

        $bookAward->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
