<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateTechnologyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:technologies,name,' . $this->route('technology')->id],
            'slug' => ['required', 'string', 'unique:technologies,slug,' . $this->route('technology')->id],
            'icon' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The technology name is required.',
            'name.unique' => 'This technology name already exists.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->name ?? ''),
        ]);
    }
}
