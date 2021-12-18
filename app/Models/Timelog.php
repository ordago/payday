<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timelog extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'employee_id',
        'started_at',
        'stopped_at',
        'minutes',
    ];

    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'started_at' => 'datetime',
        'stopped_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
