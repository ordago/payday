<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PaymentTypes;
use Illuminate\Validation\Rules\Enum;

class UpsertEmployeeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'fullName' => ['required'],
            'email' => ['required', 'email', 'unique:employees,email'],
            'departmentId' => ['required', 'exists:departments,uuid'],
            'paymentType' => [
                'required',
                new Enum(PaymentTypes::class),
            ],
        ];
    }
}
