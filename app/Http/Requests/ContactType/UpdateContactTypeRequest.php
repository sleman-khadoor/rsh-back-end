<?php

namespace App\Http\Requests\ContactType;

use App\Traits\JsonErrors;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactTypeRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', Rule::unique('contact_types')->ignore($this->route('contact_type'))]
        ];
    }
}
