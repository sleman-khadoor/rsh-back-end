<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends Controller
{
    public function __invoke(Request $request)
    {
        $roles = QueryBuilder::for(Role::class)
                            ->where('name', '!=', Role::getSuperAdminRole())
                            ->defaultSort('id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return RoleResource::collection($roles);
    }
}
