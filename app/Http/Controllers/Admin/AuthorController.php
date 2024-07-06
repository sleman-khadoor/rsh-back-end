<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreAuthorRequest;
use App\Http\Requests\Author\UpdateAuthorRequest;
use App\Http\Resources\Author\AdminAuthorResource;
use App\Traits\Uploader;
use App\Models\Author;
use App\Traits\HasChildRecords;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Admin Endpoints')]
#[Subgroup('Author Management', 'APIs for managing Authors')]
class AuthorController extends Controller
{

    use Uploader, HasChildRecords;

    #[Endpoint('Get all Authors.')]
    #[QueryParam('filter[name]', 'string', 'filter Authors by name.', false)]
    #[QueryParam('include[]', 'array', 'relations to load on the author', false, example: "['books']")]
    #[QueryParam('page', 'integer', 'The page number', example: 1)]
    #[QueryParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $authors = QueryBuilder::for(Author::class)
                            ->allowedIncludes(Author::allowedIncludes())
                            ->allowedFilters(Author::allowedFilters())
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);


        return AdminAuthorResource::collection($authors);
    }

    #[Endpoint('Get Author by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Author', true)]
    public function show(Author $author) {

        return AdminAuthorResource::make($author);
    }

    #[Endpoint('Store Author.')]
    #[BodyParam('name', 'array', 'The name of the Author.', example: ['en' => 'Ahmad', 'ar' => 'أحمد'])]
    #[BodyParam('about', 'array', 'The about of the Author.', example: ['en' => 'about the author', 'ar' => 'حول المؤلف'])]
    #[BodyParam('avatar', 'file', 'The avatar of the Author.')]
    public function store(StoreAuthorRequest $request) {

        $author = Author::create($request->validated());

        if($request->hasFile('avatar')) {
            $author->avatar = $this->uploadAttachment($request->file('avatar'), 'avatars');
            $author->save();
        }

        return AdminAuthorResource::make($author);
    }

    #[Endpoint('Update Author.')]
    #[UrlParam('id', 'integer', 'The ID of the Author', true)]
    #[BodyParam('name', 'array', 'The name of the Author.', example: ['en' => 'Ahmad', 'ar' => 'أحمد'])]
    #[BodyParam('about', 'array', 'The about of the Author.', example: ['en' => 'about the author', 'ar' => 'حول المؤلف'])]
    #[BodyParam('avatar', 'file', 'The avatar of the Author.')]
    public function update(UpdateAuthorRequest $request, Author $author) {

        $author->update($request->validated());

        if($request->hasFile('avatar')) {
            $author->avatar = $this->uploadAttachment($request->file('avatar'), 'avatars');
            $author->save();
        }

        return AdminAuthorResource::make($author);
    }

    #[Endpoint('Delete Author.')]
    #[UrlParam('id', 'integer', 'The ID of the Author.', true)]
    public function destroy(Author $author) {

        if($this->hasChildRecords($author)) {

            return $this->error(
                    Response::HTTP_CONFLICT,
                    config('response-messages.crud.record_has_childs')
                );
        }

        $author->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
