<?php

namespace App\Http\Requests\BookReview;

use App\Traits\JsonErrors;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

class StoreBookReviewRequest extends FormRequest
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
            'username' => ['required', 'array'],
            'username.*' => ['required', 'string', 'max:255'],
            'review' => ['required', 'array'],
            'review.*' => ['required', 'string'],
            'book_id' => ['required', Rule::exists('books', 'id')]
        ];
    }
}
