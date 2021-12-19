<?php

namespace App\Http\Requests;

use App\Models\Department;
use App\Enums\PaymentTypes;
use App\PaymentTypes\Concerns\PaymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpsertEmployeeRequest extends FormRequest
{
    public function getDepartment(): Department
    {
        return Department::where('uuid', $this->departmentId)->firstOrFail();
    }

    public function rules()
    {
        return [
                'fullName' => 'required|string',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('employees', 'email')->ignore($this->employee),
                ],
                'departmentId' => 'required|string|exists:departments,uuid',
                'jobTitle' => 'required|string',
                'paymentType' => [
                    'required',
                    new Enum(PaymentTypes::class),
                ],
                'salary' => 'nullable|sometimes|integer',
                'hourlyRate' => 'nullable|sometimes|integer',
        ];
    }
}
