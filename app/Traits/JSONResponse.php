<?php


namespace App\Traits;

trait JSONResponse
{
    private string $resource;

    public function getResource(): string
    {
        return $this->resource;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function collection($collection, $status = true, $errors = null)
    {
        $resource = $this->getResource();

        return $resource::collection($collection)
            ->additional(
                [
                    'success' => $status,
                    'total' => $collection->count()>0??0,
                    'errors' => $errors,
                ]
            );
    }

    public function resource($collection, $status = true, $errors = null, $method = null, $message = null)
    {
        $message = match(strtoupper($method)) {

            'POST' => config('response-messages.crud.store_success'),
            'PUT' => config('response-messages.crud.update_success'),
            DEFAULT => null
        };

        $additionalData = [
            'success' => $status,
            'errors' => $errors,
        ];

        if(!is_null($message)) $additionalData['message'] = $message;

        $resourceInstance = new $this->resource($collection);
        $resourceInstance->additional($additionalData);

        return $resourceInstance;
    }
}
