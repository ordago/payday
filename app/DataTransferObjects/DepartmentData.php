<?php

namespace App\DataTransferObjects;

use App\Http\Requests\StoreDepartmentRequest;

class DepartmentData
{
    public function __construct(public readonly string $name, public readonly ?string $description)
    {
    }
}
