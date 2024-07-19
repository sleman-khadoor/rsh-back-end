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
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Group;


#[Group('Admin Endpoints')]
#[Subgroup('Contact Management', 'APIs for managing Contacts')]
class ContactController extends Controller
{

    public function __construct()
    {
        $this->setResource(AdminContactResource::class);
    }

    #[Endpoint('Get all Contacts.')]
    #[QueryParam('filter[value]', 'string', 'filter Contacts by value.', false)]
    #[QueryParam('include[contactType]', 'string', 'include contact type.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $contacts = QueryBuilder::for(Contact::class)
                                ->allowedIncludes(Contact::allowedIncludes())
                                ->allowedFilters(Contact::allowedFilters())
                                ->defaultSort('-id')
                                ->paginate($request->perPage, ['*'], 'page', $request->page);

        return $this->collection($contacts);
    }


    #[Endpoint('Update Contact.')]
    #[UrlParam('slug', 'string', 'The slug of the Contact', true)]
    #[BodyParam('value', 'mixed', 'The value of the Contact.')]
    public function update(UpdateContactRequest $request, Contact $contact) {

        $contact->update($request->validated());

        return $this->resource($contact, method:'PUT');
    }
}
