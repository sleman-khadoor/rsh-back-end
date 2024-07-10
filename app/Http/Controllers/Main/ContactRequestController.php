<?php

namespace App\Http\Controllers\Main;

use App\Enums\RequestType;
use App\Events\NewRequestStored;
use App\Models\ContactRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest\StoreContactRequestRequest;
use Carbon\Carbon;

class ContactRequestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreContactRequestRequest $request)
    {
        $data = $request->validated();

        $contactRequest = new ContactRequest();
        $contactRequest->fullname = $data['fullname'];
        $contactRequest->mobile = $data['mobile'];
        $contactRequest->email = $data['email'];
        $contactRequest->message = $data['message'];
        $contactRequest->date = Carbon::now();
        $contactRequest->save();

        NewRequestStored::dispatch(RequestType::CONTACT_REQUEST->value);

        return $this->success([], config('response-messages.crud.contact_request_success'));
    }
}
