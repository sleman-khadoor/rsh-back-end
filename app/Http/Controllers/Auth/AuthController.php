<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {

        if(!Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {

            return $this->error(Response::HTTP_UNAUTHORIZED, config('response-messages.auth.credentials_not_match'));
        }

        $user = Auth::user();
        $token = $user->createToken(config('app.api_login_token'))->plainTextToken;

        return $this->success([
            'user' => UserResource::make($user),
            'token' => $token
        ], config('response-messages.auth.login_success'));
    }

    public function logout() {

        $user = Auth::user();

        $user->tokens()->delete();

        return $this->success([], config('response-messages.auth.logout_success'));
    }
}
