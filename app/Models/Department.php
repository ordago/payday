<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'name',
        'description',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
