<?php

namespace App\Http\Requests\Book;

use App\Traits\JsonErrors;
use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreBookRequest extends FormRequest
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
            'title' => ['required','array'],
            'title.*' => [
                'required',
                'string',
                'max:255',
                UniqueTranslationRule::for('books')->where('author_id', $this->input('author_id'))
            ],
            'abstract' => ['required','array'],
            'abstract.*' => ['required','string'],
            'ISBN' => ['required', 'string', Rule::unique('books')],
            'EISBN' => ['required', 'string', Rule::unique('books')],
            'printing_year' => ['required', 'digits:4'],
            'cover_image' => [
                File::image()
                ->max('5mb')
            ],
            'author_id' => ['required','int', Rule::exists('authors', 'id')],
            'formats' => ['required', 'array'],
            'formats.*' => ['required', Rule::exists('book_formats', 'id')],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', Rule::exists('book_categories','id')],

            'awards' => ['array'],
            'awards.*.en' => ['string'],
            'awards.*.ar' => ['string'],
            'reviews' => ['array'],
            'reviews.*.username' => ['string', 'max:255'],
            'reviews.*.review.en' => ['string'],
            'reviews.*.review.ar' => ['string'],
        ];
    }
}
