<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDepartmentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'unique:departments,name'],
            'description' => ['nullable', 'sometimes', 'string'],
        ];
    }
}
