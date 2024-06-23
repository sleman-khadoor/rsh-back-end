<?php

namespace App\Http\Requests\Book;

use App\Traits\JsonErrors;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookCategoryRequest extends FormRequest
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
            'title' => ['required'],
            'title.*' => ['required', 'string', 'max:255', UniqueTranslationRule::for('book_categories')->ignore($this->book_category?->id)],
        ];
    }
}
