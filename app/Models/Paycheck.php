<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paycheck extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'employee_id',
        'net_amount',
        'payed_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'net_amount' => 'integer',
        'payed_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
