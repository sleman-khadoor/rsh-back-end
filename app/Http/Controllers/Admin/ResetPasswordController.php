<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        $user = Auth::user();

        if(!Hash::check($request->validated('old_password'), $user->password)) {

            return $this->error(
                Response::HTTP_CONFLICT,
                config('response-messages.password_reset.fail')
            );
        }

        $user->password = Hash::make($request->validated('new_password'));
        $user->save();

        return $this->success([], config('response-messages.password_reset.success'));
    }
}
