<?php

namespace App\Http\Requests\Api;

use App\Models\Book;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Book $book */
        $book = $this->route('book');

        if ($this->isMethod('PUT')) {
            return [
                'title' => ['required', 'string', 'max:255'],
                'author' => ['required', 'string', 'max:255'],
                'isbn' => ['nullable', 'string', 'max:32', Rule::unique('books', 'isbn')->ignore($book->id)],
                'publication_year' => ['nullable', 'integer', 'min:1000', 'max:'.((int) now()->year + 1)],
                'description' => ['nullable', 'string'],
            ];
        }

        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'author' => ['sometimes', 'string', 'max:255'],
            'isbn' => ['sometimes', 'nullable', 'string', 'max:32', Rule::unique('books', 'isbn')->ignore($book->id)],
            'publication_year' => ['sometimes', 'nullable', 'integer', 'min:1000', 'max:'.((int) now()->year + 1)],
            'description' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
