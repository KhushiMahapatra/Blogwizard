<?php

namespace App\Http\Requests\Auth\Posts;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Auth\Posts\CreateRequest;

class CreateRequest extends FormRequest
{
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
            'file' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug'],
            'excerpt' => ['required','string','max:500'],
            'description' => ['required', 'string', 'max:3000'],
            'status' => ['required', 'integer', 'in:0,1'], // Assuming status is either 0 or 1
            'categories' => ['required', 'array'], // Change 'category' to 'categories'
            'categories.*' => ['required', 'exists:categories,id'], // Validate each category ID
            'tags' => ['required', 'array'],
            'tags.*' => ['required', 'exists:tags,id'],
            'published_at' => ['nullable', 'date'],

        // Validate each tag ID
        ];
    }
}
