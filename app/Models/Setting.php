<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'registration_start',
        'registration_end',
        'max_outdoor_events',
        'max_indoor_events',
        'max_cultural_events',
    ];
}
