<?php

namespace App\Http\Controllers\Main;

use App\Events\NewRequestStored;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest\StoreServiceRequestRequest;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Traits\Uploader;
use Carbon\Carbon;

class ServiceRequestController extends Controller
{
    use Uploader;

    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreServiceRequestRequest $request)
    {
        $data = $request->validated();

        $serviceRequest = new ServiceRequest();
        $serviceRequest->fullname = $data['fullname'];
        $serviceRequest->mobile = $data['mobile'];
        $serviceRequest->email = $data['email'];
        $serviceRequest->description = $data['description'];
        $serviceRequest->service_name = $data['service_name'];
        $serviceRequest->date = Carbon::now();
        $serviceRequest->save();

        if(array_key_exists('documents', $data)) {

            foreach($data['documents'] as $file) {

                $filePath = $this->storeFileInStorage($file, 'services-docs');

                ServiceRequestDocument::create([
                    'document_link' => $filePath,
                    'service_request_id' => $serviceRequest->id
                ]);
            }
        }

        NewRequestStored::dispatch($serviceRequest->service_name);

        return $this->success([], config('response-messages.crud.service_request_success'));
    }
}
