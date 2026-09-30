<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'unique:projects,slug'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status_id' => ['required', 'exists:statuses,id'],
            'role' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'technologies' => ['nullable', 'array'],
            'technologies.*' => ['exists:technologies,id'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'notes' => ['nullable', 'string'],
            'features' => ['nullable', 'array'],
            'features.*.name' => ['required', 'string', 'max:255'],
            'features.*.description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The project title is required.',
            'title.max' => 'The project title must not exceed 150 characters.',
            'description.required' => 'The project description is required.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'status_id.required' => 'Please select a status.',
            'status_id.exists' => 'The selected status is invalid.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'thumbnail.image' => 'The thumbnail must be an image.',
            'thumbnail.mimes' => 'The thumbnail must be a JPEG, PNG, or WebP image.',
            'thumbnail.max' => 'The thumbnail must not exceed 5MB.',
            'github_url.url' => 'Please enter a valid GitHub URL.',
            'demo_url.url' => 'Please enter a valid demo URL.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->title ?? ''),
        ]);
    }
}
