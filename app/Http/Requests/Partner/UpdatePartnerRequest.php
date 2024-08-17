<?php

namespace App\Http\Requests\Partner;

use App\Enums\LanguageEnum;
use App\Traits\JsonErrors;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdatePartnerRequest extends FormRequest
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
            'name' => ['required','array'],
            'name.*' => [
                'required',
                'string',
                'max:255',
                UniqueTranslationRule::for('partners')->ignore($this->partner?->id)
            ],
            'avatar' => [File::image()->max('5mb')],
            'website_link' => ['required','string', 'url'],
        ];
    }
}
