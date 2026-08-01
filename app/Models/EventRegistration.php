<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id',
        'leader_enrolment',
        'participant_enrolment',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    // Leader relation
    public function leader()
    {
        return $this->belongsTo(Student::class, 'leader_enrolment', 'enroll_no');
    }

    // Participant relation
    public function participant()
    {
        return $this->belongsTo(Student::class, 'participant_enrolment', 'enroll_no');
    }

    public function student()
    {
        return $this->participant();
    }
    public function coordinators()
{
    return $this->belongsToMany(Coordinator::class, 'coordinator_event', 'event_id', 'coordinator_id')
                ->with('user');
}
}
