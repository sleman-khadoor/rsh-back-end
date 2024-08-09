<?php

namespace App\Enums;

enum RequestType: string
{
    case CONTACT_REQUEST = 'contact_request';
    case TRANSLATION_SERVICE = 'translation_service';
    case MARKETING_SERVICE = 'marketing_service';
    case BOOK_DELIVERY_SERVICE = 'book_delivery_service';
    case CONTENT_WRITING_SERVICE = 'content_writing_service';
    case CREATIVE_EDITING_SERVICE = 'creative_editing_service';
    case LITERARY_AGENCY_SERVICE = 'literary_agency_service';
    case ORGANIZING_EVENTS_CONFERENCES_SERVICE = 'organizing_events_conferences_service';
    case PROOFREADING_SERVICE = 'proofreading_service';
}
