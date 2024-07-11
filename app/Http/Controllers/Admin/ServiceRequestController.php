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

class ServiceRequestController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->setResource(ServiceRequestResource::class);
    }

    public function index(Request $request) {

        $contactRequests = QueryBuilder::for(ServiceRequest::class)
                                    ->allowedIncludes(ServiceRequest::allowedIncludes())
                                    ->allowedFilters(ServiceRequest::allowedFilters())
                                    ->defaultSort('-id')
                                    ->paginate($request->perPage, ['*'], 'page', $request->page);

        $notification = Notification::where('type', '!=', RequestType::CONTACT_REQUEST->value)->first();

        if($notification)  {

            $notification->count = 0;
            $notification->save();
        }

        return $this->collection($contactRequests);
    }

    public function show(ServiceRequest $serviceRequest) {

        return $this->resource($serviceRequest->load(ServiceRequest::allowedIncludes()));
    }

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
