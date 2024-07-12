<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasFilters;
use App\Traits\HasIncludes;
use Spatie\Sluggable\HasSlug;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasIncludes, HasFilters, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static array $allowedIncludes = ['roles'];
    protected static array $allowedFilters = ['first_name', 'last_name', 'email', 'username'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_deletable' => 'boolean',
        ];
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('username')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function canBeDeleted(): bool {

        return $this->is_deletable;
    }

    public function roles(): BelongsToMany {

        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function assignRole(string | Role $role): void {

        if(is_string($role)) {

            $role = Role::where('name', $role)->first();
        }

        if($role) {

            $this->roles()->attach($role);
        }
    }

    public function assignRoles(array $role): void {

        foreach($role as $roleName) {

            $this->assignRole($roleName);
        }
    }

    public function hasRole(string | Role $role): bool {

        $roleName = is_string($role) ? $role : $role->name;

        return $this->roles()->where('name', $roleName)->exists();
    }

    public function detachRole(string | Role $role): void {

        if(is_string($role)) {

            $role = Role::where('name', $role)->first();
        }

        $this->roles()->detach($role->id);
    }

    public function scopeOnlyAdmins(Builder $query): void {

        $query->whereHas('roles', function($rolesQuery) {

            $rolesQuery->where('name', '!=', Role::getSuperAdminRole());
        });
    }
}
