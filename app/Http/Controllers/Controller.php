<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Traits\JSONResponse;

abstract class Controller
{
    use ApiResponser, JSONResponse;
}
