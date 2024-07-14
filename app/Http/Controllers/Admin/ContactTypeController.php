<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactType\StoreContactTypeRequest;
use App\Http\Requests\ContactType\UpdateContactTypeRequest;
use App\Http\Resources\ContactType\AdminContactTypeResource;
use App\Models\ContactType;
use App\Traits\HasChildRecords;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Admin Endpoints')]
#[Subgroup('Contact type Management', 'APIs for managing Contact types.')]
class ContactTypeController extends Controller
{
    use HasChildRecords;

    public function __construct()
    {
        $this->setResource(AdminContactTypeResource::class);
    }


    #[Endpoint('Get all Contact types.')]
    #[QueryParam('filter[title]', 'string', 'filter Book Categroies by title.', false)]
    #[QueryParam('include[contacts]', 'array', 'include contacts with the contact type.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $contactTypes = QueryBuilder::for(ContactType::class)
                                    ->allowedIncludes(ContactType::allowedIncludes())
                                    ->allowedFilters(ContactType::allowedFilters())
                                    ->defaultSort('-id')
                                    ->paginate($request->perPage, ['*'], 'page', $request->page);

        return $this->collection($contactTypes);
    }

    #[Endpoint('Get Contact type by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the contact type.', true)]
    public function show(ContactType $contactType) {

        return $this->resource($contactType->load(ContactType::allowedIncludes()));
    }

    #[Endpoint('Store Contact type.')]
    #[BodyParam('title', 'array', 'The title of the Contact type.')]
    public function store(StoreContactTypeRequest $request) {

        $contactType = ContactType::create($request->validated());

        return $this->resource($contactType, method:'POST');
    }

    #[Endpoint('Update Contact type.')]
    #[UrlParam('slug', 'integer', 'The slug of the contact type.', true)]
    #[BodyParam('title', 'array', 'The title of the Contact type.')]
    public function update(UpdateContactTypeRequest $request, ContactType $contactType) {

        $contactType->update($request->validated());

        return $this->resource($contactType, method:'PUT');
    }

    #[Endpoint('Delete Contact type.')]
    #[UrlParam('slug', 'string', 'The slug of the contact type.', true)]
    public function destroy(ContactType $contactType) {

        if($this->hasChildRecords($contactType)) {

            return $this->error(
                    Response::HTTP_CONFLICT,
                    config('response-messages.crud.record_has_childs')
                );
        }

        $contactType->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
