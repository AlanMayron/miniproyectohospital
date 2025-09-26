<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'description', 'capacity', 'occupancy'];

    protected $casts = [
        'capacity' => 'integer',
        'occupancy' => 'integer',
    ];

    public function getUtilizationAttribute(): float
    {
        return $this->capacity > 0 ? round(($this->occupancy / $this->capacity) * 100, 1) : 0.0;
    }
}
