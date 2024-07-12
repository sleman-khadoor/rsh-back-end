<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserManagemenrController extends Controller
{
    public function __construct()
    {
        $this->setResource(UserResource::class);
    }

    public function index(Request $request) {

        $users = QueryBuilder::for(User::class)
                            ->onlyAdmins()
                            ->allowedIncludes(User::allowedIncludes())
                            ->allowedFilters(User::allowedFilters())
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return $this->collection($users);
    }

    public function show(User $user) {

        return $this->resource($user->load(User::allowedIncludes()));
    }

    public function store(StoreUserRequest $request) {

        $data = $request->validated();

        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        $user->is_deletable = true;
        $user->save();

        foreach($data['roles'] as $roleObj) {

            $role = Role::findOrFail($roleObj['id']);
            $user->assignRole($role);
        }

        return $this->resource($user);
    }

    public function update(UpdateUserRequest $request, User $user) {

        $data = $request->validated();

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        $user->is_deletable = true;
        $user->save();

        $user->roles()->sync([]);

        foreach($data['roles'] as $roleObj) {

            $role = Role::findOrFail($roleObj['id']);

            $user->assignRole($role);
        }

        return $this->resource($user);
    }

    public function destroy(User $user) {

        if(!$user->canBeDeleted()) {

            return $this->error(
                Response::HTTP_UNAUTHORIZED,
                config('response-messages.crud.user_delete_failed')
            );
        }

        $user->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
