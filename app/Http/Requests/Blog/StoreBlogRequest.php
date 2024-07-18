<?php

namespace App\Http\Requests\Blog;

use App\Enums\LanguageEnum;
use App\Traits\JsonErrors;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreBlogRequest extends FormRequest
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
            'title' => ['required','string','max:100'],
            'content' => ['required','string'],
            'writer' => ['required','string', 'max:30'],
            'date' => ['required', 'date'],
            'lang' => ['required', Rule::in(array_map(fn($lang) => $lang->value, LanguageEnum::cases()))],
            'cover_image' => [File::image()->min('400kb')->max('4mb')],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer', Rule::exists('blog_categories', 'id')],
        ];
    }
}
