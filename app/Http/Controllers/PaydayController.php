<?php

namespace App\Http\Controllers;

use App\Actions\PaydayAction;

class PaydayController extends Controller
{
    public function __construct(private readonly PaydayAction $payday)
    {
    }

    public function store()
    {
        $this->payday->execute();
        return response()->noContent();
    }
}
