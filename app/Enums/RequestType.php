<?php

namespace App\Enums;

enum RequestType: string
{
    case CONTACT_REQUEST = 'contact_request';
    case TRANSLATION_SERVICE = 'translation_service';
}
