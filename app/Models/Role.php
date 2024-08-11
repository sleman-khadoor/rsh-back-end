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

        return config('core-config.roles.service_admin');
    }

    public static function getBooksAdminRole(): string {

        return config('core-config.roles.book_admin');
    }

    public static function getBlogsAdminRole(): string {

        return config('core-config.roles.blog_admin');
    }

    public static function getNewsAdminRole(): string {

        return config('core-config.roles.news_admin');
    }

    public static function getUserManagementAdminRole(): string {

        return config('core-config.roles.user_management_admin');
    }

    public static function getContactAdminRole(): string {

        return config('core-config.roles.contact_admin');
    }
}
