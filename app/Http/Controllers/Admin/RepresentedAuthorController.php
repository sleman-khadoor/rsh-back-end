<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\RepresentedAuthor\StoreRepresentedAuthorRequest;
use App\Http\Requests\RepresentedAuthor\UpdateRepresentedAuthorRequest;
use App\Http\Resources\RepresentedAuthor\AdminRepresentedAuthorResource;
use App\Traits\Uploader;
use App\Models\RepresentedAuthor;
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
#[Subgroup('Represented Author Management', 'APIs for managing Authors')]
class RepresentedAuthorController extends Controller
{

    use Uploader, HasChildRecords;

    public function __construct()
    {
        $this->setResource(AdminRepresentedAuthorResource::class);
    }

    #[Endpoint('Get all Represented Authors.')]
    #[QueryParam('filter[name]', 'string', 'filter Authors by name.', false)]
    #[QueryParam('page', 'integer', 'The page number', example: 1)]
    #[QueryParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $authors = QueryBuilder::for(RepresentedAuthor::class)
                            ->allowedFilters(RepresentedAuthor::allowedFilters())
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);


        return $this->collection($authors);
    }

    #[Endpoint('Get Represented Author by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Author', true)]
    public function show(RepresentedAuthor $represented_author) {

        return $this->resource($represented_author);
    }

    #[Endpoint('Store Represented Author.')]
    #[BodyParam('name', 'array', 'The name of the Author.', example: ['en' => 'Ahmad', 'ar' => 'أحمد'])]
    #[BodyParam('about', 'array', 'The about of the Author.', example: ['en' => 'about the author', 'ar' => 'حول المؤلف'])]
    #[BodyParam('avatar', 'file', 'The avatar of the Author.')]
    public function store(StoreRepresentedAuthorRequest $request) {

        $author = RepresentedAuthor::create($request->validated());

        if($request->hasFile('avatar')) {
            $author->avatar = $this->uploadAttachment($request->file('avatar'), 'avatars');
            $author->save();
        }

        return $this->resource($author, method: 'POST');
    }

    #[Endpoint('Update Represented Author.')]
    #[UrlParam('id', 'integer', 'The ID of the Author', true)]
    #[BodyParam('name', 'array', 'The name of the Author.', example: ['en' => 'Ahmad', 'ar' => 'أحمد'])]
    #[BodyParam('about', 'array', 'The about of the Author.', example: ['en' => 'about the author', 'ar' => 'حول المؤلف'])]
    #[BodyParam('avatar', 'file', 'The avatar of the Author.')]
    public function update(UpdateRepresentedAuthorRequest $request, RepresentedAuthor $represented_author) {

        $represented_author->update($request->validated());

        if($request->hasFile('avatar')) {
            $represented_author->avatar = $this->uploadAttachment($request->file('avatar'), 'avatars');
            $represented_author->save();
        }

        return $this->resource($represented_author, method:'PUT');
    }

    #[Endpoint('Delete Represented Author.')]
    #[UrlParam('id', 'integer', 'The ID of the Author.', true)]
    public function destroy(RepresentedAuthor $represented_author) {

        if($this->hasChildRecords($represented_author)) {

            return $this->error(
                    Response::HTTP_CONFLICT,
                    config('response-messages.crud.record_has_childs')
                );
        }

        $represented_author->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
