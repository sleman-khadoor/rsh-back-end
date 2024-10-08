<?php

namespace App\Http\Requests\Book;

use App\Traits\JsonErrors;
use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateBookRequest extends FormRequest
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
            'title.*' => [
                'required',
                'string',
                'max:255',
            ],
            'abstract' => ['required', 'array'],
            'abstract.*' => ['required', 'string'],
            'cover_image' => [
                File::image()
                ->max('5mb')
            ],
            'ISBN' => [
                'required',
                'string',
                Rule::unique('books')->ignore($this->book?->id)
            ],
            'EISBN' => [
                'required',
                'string',
                Rule::unique('books')->ignore($this->book?->id)
            ],
            'printing_year' => ['required', 'integer', 'digits:4', 'min:1800', 'max:'.(date('Y') + 1)],
            'author_id' => ['required', 'int', Rule::exists('authors', 'id')],
            'formats' => ['array'],
            'formats.*' => ['integer', Rule::exists('book_formats','id')],
            'categories' => ['array'],
            'categories.*' => ['integer', Rule::exists('book_categories','id')],
        ];
    }
}
