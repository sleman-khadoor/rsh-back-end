<?php

namespace App\Models\Abstracts;


interface RelationsAware {

    public function relations(): array;
}
