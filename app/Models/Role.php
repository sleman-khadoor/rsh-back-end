<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name'];

    public static function getSuperAdminRole(): string {

        return config('core-config.roles.super_admin');
    }

    public static function getServicesAdminRole(): string {

        return config('core-config.roles.services_admin');
    }

    public static function getBooksAdminRole(): string {

        return config('core-config.roles.books_admin');
    }
}
