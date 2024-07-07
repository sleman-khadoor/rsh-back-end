<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Resources\Contact\AdminContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\QueryBuilder\QueryBuilder;

class ContactController extends Controller
{
    public function index(Request $request) {

        $contacts = QueryBuilder::for(Contact::class)
                                ->allowedIncludes(Contact::allowedIncludes())
                                ->allowedFilters(Contact::allowedFilters())
                                ->defaultSort('-id')
                                ->paginate($request->perPage, ['*'], 'page', $request->page);

        return AdminContactResource::collection($contacts);
    }

    public function show(Contact $contact) {

        return AdminContactResource::make($contact->load(Contact::allowedIncludes()));
    }

    public function store(StoreContactRequest $request) {

        $contact = Contact::create($request->validated());

        return AdminContactResource::make($contact);
    }

    public function update(UpdateContactRequest $request, Contact $contact) {

        $contact->update($request->validated());

        return AdminContactResource::make($contact);
    }

    public function destroy(Contact $contact) {

        $contact->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
