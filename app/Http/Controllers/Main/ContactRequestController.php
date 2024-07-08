<?php

namespace App\Http\Controllers\Main;

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
        $contactRequest->full_name = $data['full_name'];
        $contactRequest->mobile = $data['mobile'];
        $contactRequest->email = $data['email'];
        $contactRequest->message = $data['message'];
        $contactRequest->date = Carbon::now();
        $contactRequest->save();

        NewRequestStored::dispatch(config('core-config.notifications.keys.contact_form'));

        return $this->success([], config('response-messages.crud.contact_request_success'));
    }
}
