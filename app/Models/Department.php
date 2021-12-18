<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
