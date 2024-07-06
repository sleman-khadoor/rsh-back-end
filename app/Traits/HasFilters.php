<?php

namespace App\Traits;

/**
 * @property array allowedFilters
 */
trait HasFilters {

    public static function allowedFilters(): array {

        return static::$allowedFilters ?? [];
    }
}
