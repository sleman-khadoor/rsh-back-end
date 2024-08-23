<?php

namespace App\Http\Requests\News;

use App\Traits\JsonErrors;
use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Validation\Rules\File;

class StoreNewsRequest extends FormRequest
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
            'title' => ['required', 'array'],
            'title.*' => ['required', 'string', 'max:255'],
            'content' => ['required', 'array'],
            'content.*' => ['required', 'string'],
            'cover_image' => [
                File::image()
                    ->max('2mb')
            ],
        ];
    }
}
