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

    public function __construct()
    {
        $this->setResource(AdminBookAwardResource::class);
    }

    public function store(StoreBookAwardRequest $request) {

        $bookAward = BookAward::create($request->validated());

        return $this->resource($bookAward, method:'POST');
    }

    public function update(UpdateBookAwardRequest $request, BookAward $bookAward) {

        $bookAward->update($request->validated());

        return $this->resource($bookAward, method:'PUT');
    }

    public function destroy(BookAward $bookAward) {

        $bookAward->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
