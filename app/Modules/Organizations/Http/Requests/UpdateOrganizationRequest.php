<?php

namespace App\Modules\Organizations\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('organizations', 'slug')->ignore($this->route('organization')),
            ],
            'logo_path' => ['sometimes', 'nullable', 'string', 'max:2048'],
            'timezone' => ['sometimes', 'required', 'timezone'],
            'settings' => ['sometimes', 'nullable', 'array'],
        ];
    }
}
