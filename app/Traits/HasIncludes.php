<?php

namespace App\Traits;

/**
 * @property array allowedIncludes
 */
trait HasIncludes {

    public static function allowedIncludes(): array {

        return static::$allowedIncludes ?? [];
    }
}
