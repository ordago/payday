<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetEmployeesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'filter' => ['nullable', 'sometimes', 'array'],
            'filter.full_name' => ['nullable', 'sometimes', 'string'],
            'filter.job_title' => ['nullable', 'sometimes', 'string'],
            'filter.email' => ['nullable', 'sometimes', 'string'],
            'filter.department.name' => ['nullable', 'sometimes', 'string'],
        ];
    }
}
