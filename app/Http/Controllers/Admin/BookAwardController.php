<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookAward\StoreBookAwardRequest;
use App\Http\Requests\BookAward\UpdateBookAwardRequest;
use App\Http\Resources\BookAward\AdminBookAwardResource;
use App\Models\BookAward;
use Symfony\Component\HttpFoundation\Response;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;

#[Group('Admin Endpoints')]
#[Subgroup('Book Awards Management', 'APIs for managing Book Awards')]
class BookAwardController extends Controller
{

    public function __construct()
    {
        $this->setResource(AdminBookAwardResource::class);
    }

    #[Endpoint('Store Book Award.')]
    #[BodyParam('title', 'array', 'The title of the Book Award.', example: ['en' => 'Historical', 'ar' => 'تاريخي'])]
    #[BodyParam('book_id', 'integer', 'The id of the Book.')]
    public function store(StoreBookAwardRequest $request) {

        $bookAward = BookAward::create($request->validated());

        return $this->resource($bookAward, method:'POST');
    }

    #[Endpoint('Update Book Award.')]
    #[BodyParam('title', 'array', 'The title of the Book Award.', example: ['en' => 'Historical', 'ar' => 'تاريخي'])]
    public function update(UpdateBookAwardRequest $request, BookAward $bookAward) {

        $bookAward->update($request->validated());

        return $this->resource($bookAward, method:'PUT');
    }

    #[Endpoint('Delete Book Award.')]
    #[UrlParam('id', 'integer', 'The ID of the book award', true)]
    public function destroy(BookAward $bookAward) {

        $bookAward->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
