<?php

namespace App\Http\Requests\BookReview;

use App\Traits\JsonErrors;
use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

class UpdateBookReviewRequest extends FormRequest
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
            'username.*' => ['required', 'string', 'max:255', UniqueTranslationRule::for('book_reviews')->ignore($this->book_review?->id)],
            'review' => ['required', 'array'],
            'review.*' => ['required', 'string'],
        ];
    }
}
