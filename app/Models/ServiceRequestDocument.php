<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestDocument extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'service_requests_documents';
    protected $fillable = ['document_link', 'service_request_id'];
}
