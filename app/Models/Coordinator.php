<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    protected $primaryKey = 'coordinator_id'; 

    protected $fillable = [
        'user_id',
        'event_id',
        'mobile',
        'ext',
        'school',
        'profile_pic',
    ];

    // Link back to the user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'coordinator_event', 'coordinator_id', 'event_id');
    }
}
