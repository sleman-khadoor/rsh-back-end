<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['full_name', 'mobile', 'email', 'message'];
}
