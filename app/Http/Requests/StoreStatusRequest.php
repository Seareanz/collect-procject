<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:statuses,name'],
            'slug' => ['required', 'string', 'unique:statuses,slug'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The status name is required.',
            'name.unique' => 'This status name already exists.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->name ?? ''),
        ]);
    }
}
