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
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Admin Endpoints')]
#[Subgroup('User Management', 'APIs for managing Users.')]
class UserManagemenrController extends Controller
{
    public function __construct()
    {
        $this->setResource(UserResource::class);
    }

    #[Endpoint('Get all Users.')]
    #[QueryParam('filter[first_name]', 'string', 'filter Users by first_name.', false)]
    #[QueryParam('filter[last_name]', 'string', 'filter Users by last_name.', false)]
    #[QueryParam('filter[username]', 'string', 'filter Users by username.', false)]
    #[QueryParam('include[roles]', 'array', 'include roles with the users.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $users = QueryBuilder::for(User::class)
                            ->where('id', '!=', Auth::id())
                            ->onlyAdmins()
                            ->allowedIncludes(User::allowedIncludes())
                            ->allowedFilters(User::allowedFilters())
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return $this->collection($users);
    }

    #[Endpoint('Get User by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the User.', true)]
    public function show(User $user) {

        return $this->resource($user->load(User::allowedIncludes()));
    }

    #[Endpoint('Store User.')]
    #[BodyParam('first_name', 'string', 'The first_name of the User.')]
    #[BodyParam('last_name', 'string', 'The last_name of the User.')]
    #[BodyParam('username', 'string', 'The username of the User.')]
    #[BodyParam('password', 'string', 'The password of the User.')]
    #[BodyParam('password_confirmation', 'string', 'The password Confirmation.')]
    #[BodyParam('roles', 'array', 'The roles of the User.')]
    public function store(StoreUserRequest $request) {

        $data = $request->validated();

        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        $user->is_deletable = true;
        $user->save();

        foreach($data['roles'] as $roleId) {
            $role = Role::findOrFail($roleId);
            $user->assignRole($role);
        }

        return $this->resource($user, method:'post');
    }

    #[Endpoint('Update User.')]
    #[UrlParam('slug', 'string', 'The slug of the User.', true)]
    #[BodyParam('first_name', 'string', 'The first_name of the User.')]
    #[BodyParam('last_name', 'string', 'The last_name of the User.')]
    #[BodyParam('username', 'string', 'The username of the User.')]
    #[BodyParam('password', 'string', 'The password of the User.')]
    #[BodyParam('password_confirmation', 'string', 'The password Confirmation.')]
    #[BodyParam('roles', 'array', 'The roles of the User.')]
    public function update(UpdateUserRequest $request, User $user) {

        $data = $request->validated();

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->username = $data['username'];
        $user->is_deletable = true;
        $user->save();

        if($request->roles){
            $user->roles()->sync([]);
            foreach($data['roles'] as $roleId) {

                $role = Role::findOrFail($roleId);

                $user->assignRole($role);
            }
        }

        return $this->resource($user, method:'PUT');
    }

    #[Endpoint('Delete User.')]
    #[UrlParam('slug', 'string', 'The slug of the User.', true)]
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
