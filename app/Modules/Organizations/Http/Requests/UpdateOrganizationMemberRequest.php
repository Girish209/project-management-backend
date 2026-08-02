<?php

namespace App\Modules\Organizations\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'required', 'string', 'max:100'],
            'last_name' => ['sometimes', 'required', 'string', 'max:100'],
            'employee_code' => ['sometimes', 'nullable', 'string', 'max:100'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'department' => ['sometimes', 'nullable', 'string', 'max:150'],
            'designation' => ['sometimes', 'nullable', 'string', 'max:150'],
            'status' => ['sometimes', 'required', 'in:invited,active,disabled'],
            'joined_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
