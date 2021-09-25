<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Route extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'airline',
        'airline_id',
        'source_airport',
        'source_airport_id',
        'destination_airport',
        'destination_airport_id',
        'codeshare',
        'stops',
        'equipment',
        'price',
    ];

    public $timestamps = true;

    public function sourceAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'source_airport_id')->with('city');
    }

    public function destinationAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id')->with('city');
    }
}
