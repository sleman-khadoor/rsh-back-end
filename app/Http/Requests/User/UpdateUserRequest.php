<?php

namespace App\Http\Requests\User;

use App\Models\Role;
use App\Traits\JsonErrors;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    use JsonErrors;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', Rule::unique('users')->ignore($this->route('user'))],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'integer', Rule::in(Role::where('name', '!=', Role::getSuperAdminRole())->pluck('id')->toArray())]
        ];
    }
}
