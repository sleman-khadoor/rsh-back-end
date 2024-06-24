<?php

namespace App\Traits;

use App\Models\Abstracts\RelationsAware;
use Exception;

trait HasChildRecords {

    protected function hasChildRecords(RelationsAware $model): bool {

        foreach($model->relations() as $relation) {

            if(!method_exists($model, $relation)) {

                throw new Exception("The relation $relation does not exist on " . class_basename($model));
            }

            if($model->$relation()->count()) {

                return true;
            }
        }

        return false;
    }
}
