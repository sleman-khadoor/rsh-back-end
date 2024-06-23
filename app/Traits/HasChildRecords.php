<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HasChildRecords {

    protected function hasChildRecords(Model $model, string ...$relations): ?JsonResponse {

        foreach($relations as $relation) {

            if(!method_exists($model, $relation)) {
                throw InvalidArgumentException("The relation $relation does not exists on the model.");
            }

            if($model->$relation()->count()) {

                return $this->error(
                    Response::HTTP_CONFLICT,
                    str_replace('{childs}', $relation, config('response-messages.crud.record_has_childs'))
                );
            }
        }

        return null;
    }
}
