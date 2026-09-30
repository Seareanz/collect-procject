<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:statuses,name,' . $this->route('status')->id],
            'slug' => ['required', 'string', 'unique:statuses,slug,' . $this->route('status')->id],
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
