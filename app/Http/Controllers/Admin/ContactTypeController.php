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

class ContactTypeController extends Controller
{
    use HasChildRecords;

    public function __construct()
    {
        $this->setResource(AdminContactTypeResource::class);
    }


    public function index(Request $request) {

        $contactTypes = QueryBuilder::for(ContactType::class)
                                    ->allowedIncludes(ContactType::allowedIncludes())
                                    ->allowedFilters(ContactType::allowedFilters())
                                    ->defaultSort('-id')
                                    ->paginate($request->perPage, ['*'], 'page', $request->page);

        return $this->collection($contactTypes);
    }

    public function show(ContactType $contactType) {

        return $this->resource($contactType->load(ContactType::allowedIncludes()));
    }

    public function store(StoreContactTypeRequest $request) {

        $contactType = ContactType::create($request->validated());

        return $this->resource($contactType, method:'POST');
    }

    public function update(UpdateContactTypeRequest $request, ContactType $contactType) {

        $contactType->update($request->validated());

        return $this->resource($contactType, method:'PUT');
    }

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