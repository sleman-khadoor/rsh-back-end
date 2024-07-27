<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RequestType;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\ServiceRequest\ServiceRequestResource;
use App\Traits\Uploader;
use Symfony\Component\HttpFoundation\Response;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\QueryParam;


#[Group('Admin Endpoints')]
#[Subgroup('Service requests Management', 'APIs for managing Service requests.')]
class ServiceRequestController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->setResource(ServiceRequestResource::class);
    }


    #[Endpoint('Get all Service requests.')]
    #[QueryParam('filter[fullname]', 'string', 'filter Service requests by fullname.', false)]
    #[QueryParam('filter[mobile]', 'string', 'filter Service requests by fullname.', false)]
    #[QueryParam('filter[email]', 'string', 'filter Service requests by fullname.', false)]
    #[QueryParam('include[documents]', 'array', 'include documents with the service requests.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $contactRequests = QueryBuilder::for(ServiceRequest::class)
                                    ->allowedIncludes(ServiceRequest::allowedIncludes())
                                    ->allowedFilters(ServiceRequest::allowedFilters())
                                    ->defaultSort('-id')
                                    ->paginate($request->perPage, ['*'], 'page', $request->page);

        $requestedService = is_array($request->filter) ? RequestType::tryFrom($request->filter['service_name']) : null;

        $notification = Notification::where('type', $requestedService?->value)->first();

        if($notification)  {

            $notification->count = 0;
            $notification->save();
        }

        return $this->collection($contactRequests);
    }


    #[Endpoint('Get Service request by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Service request.', true)]
    public function show(ServiceRequest $serviceRequest) {

        return $this->resource($serviceRequest->load(ServiceRequest::allowedIncludes()));
    }

    #[Endpoint('Deelete Service request.')]
    #[UrlParam('slug', 'string', 'The slug of the Service request.', true)]
    public function destroy(ServiceRequest $serviceRequest) {

        $documents = $serviceRequest->documents;

        if(count($documents) > 0) {

            foreach($documents as $document) {

                $this->deleteFileFromStorage($document->document_link);

                $document->delete();
            }
        }

        $serviceRequest->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
