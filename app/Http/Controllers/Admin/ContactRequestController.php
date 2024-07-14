<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RequestType;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactRequest\ContactRequestResource;
use App\Models\ContactRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\QueryBuilder\QueryBuilder;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;

#[Group('Admin Endpoints')]
#[Subgroup('Contact requests Management', 'APIs for managing Contact requests')]
class ContactRequestController extends Controller
{
    public function __construct()
    {
        $this->setResource(ContactRequestResource::class);
    }


    #[Endpoint('Get all Contact requests.')]
    #[QueryParam('filter[fullname]', 'string', 'filter Contact requests by fullname.', false)]
    #[QueryParam('filter[mobile]', 'string', 'filter Contact requests by mobile.', false)]
    #[QueryParam('filter[email]', 'string', 'filter Contact requests by email.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $contactRequests = QueryBuilder::for(ContactRequest::class)
                                    ->allowedFilters(ContactRequest::allowedFilters())
                                    ->defaultSort('-id')
                                    ->paginate($request->perPage, ['*'], 'page', $request->page);

        $notification = Notification::where('type', RequestType::CONTACT_REQUEST->value)->first();

        if($notification)  {

            $notification->count = 0;
            $notification->save();
        }

        return $this->collection($contactRequests);
    }

    #[Endpoint('Get Contact request by slug.')]
    #[UrlParam('slug', 'integer', 'The slug of the Contact request', true)]
    public function show(ContactRequest $contactRequest) {

        return $this->resource($contactRequest);
    }

    #[Endpoint('Delete Contact request.')]
    #[UrlParam('slug', 'integer', 'The slug of the Contact request', true)]
    public function destroy(ContactRequest $contactRequest) {

        $contactRequest->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
