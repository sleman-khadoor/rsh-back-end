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

class ContactRequestController extends Controller
{
    public function __construct()
    {
        $this->setResource(ContactRequestResource::class);
    }

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

    public function show(ContactRequest $contactRequest) {

        return $this->resource($contactRequest);
    }

    public function destroy(ContactRequest $contactRequest) {

        $contactRequest->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
