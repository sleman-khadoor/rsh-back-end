<?php

namespace App\Http\Requests\RepresentedAuthor;

use App\Traits\JsonErrors;
use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Validation\Rules\File;

class UpdateRepresentedAuthorRequest extends FormRequest
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
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string', 'max:255', UniqueTranslationRule::for('represented_authors')->ignore($this->represented_author?->id)],
            'about' => ['required', 'array'],
            'about.*' => ['required', 'string'],
            'avatar' => [
                File::image()
                    ->min('200kb')
                    ->max('5mb')
            ],
        ];
    }
}
