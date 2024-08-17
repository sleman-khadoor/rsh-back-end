<?php

namespace App\Http\Requests\ServiceRequest;

use App\Enums\RequestType;
use App\Rules\RecaptchaRule;
use App\Traits\JsonErrors;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;


class StoreServiceRequestRequest extends FormRequest
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
            'fullname' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'service_name' => ['required', 'string', Rule::in(array_map(fn($service) => $service->value, RequestType::cases()))],
            'documents' => ['array', 'max:5'],
            'documents.*' => [
                File::types(['pdf', 'docx', 'png', 'jpg', 'jpeg'])
                    ->min('2kb')
                    ->max('10mb')
            ],
            'recaptcha' => ['required', new RecaptchaRule],
        ];
    }
}
