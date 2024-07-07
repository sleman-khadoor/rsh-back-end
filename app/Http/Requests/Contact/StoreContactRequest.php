<?php

namespace App\Http\Requests\Contact;

use App\Traits\JsonErrors;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
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
            'contact_type_id' => ['required', 'integer', Rule::exists('contact_types', 'id')],
            'value' => ['required', Rule::unique('contacts')->where('contact_type_id', $this->input('contact_type_id'))]
        ];
    }
}
