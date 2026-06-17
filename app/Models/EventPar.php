<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPar extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'hole_number',
        'par_value',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
