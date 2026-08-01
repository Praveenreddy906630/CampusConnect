<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventRegistration;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id'; 

    protected $casts = [
        'is_group' => 'boolean',
        'registration_open' => 'boolean',
        'max_participants' => 'integer',
    ];

    protected $fillable = [
        'event_name',
        'type',
        'description',
        'venue',
        'thumbnail_image',
        'event_date',
        'event_time',
        'is_group',
        'max_group_size',
        'max_participants',
        'registration_open',
        'carousel_image_1',
        'carousel_image_2',
        'carousel_image_3',
        'carousel_image_4',
        'carousel_image_5',
    ];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    public function coordinators()
    {
        return $this->belongsToMany(Coordinator::class, 'coordinator_event', 'event_id', 'coordinator_id');
    }
}
