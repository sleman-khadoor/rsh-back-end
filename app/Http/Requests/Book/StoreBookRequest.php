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
            'ISBN' => ['required', 'string', 'numeric', Rule::unique('books')],
            'EISBN' => ['required', 'string', 'numeric', Rule::unique('books')],
            'printing_year' => ['required', 'integer', 'digits:4', 'min:1800', 'max:'.(date('Y') + 1)],
            'cover_image' => [
                File::image()
                ->min('200kb')
                ->max('2mb')
            ],
            'author_id' => ['required','int', Rule::exists('authors', 'id')],
            'formats' => ['required', 'array'],
            'formats.*' => ['required', 'integer', Rule::exists('book_formats', 'id')],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer', Rule::exists('book_categories','id')],

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
