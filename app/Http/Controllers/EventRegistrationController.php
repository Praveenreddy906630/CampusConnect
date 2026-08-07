<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User; // Or EventRegistration if you have a pivot table

class EventRegistrationController extends Controller
{
    public function show(Event $event)
    {
        if (auth()->user()->user_type !== 'student' || !auth()->user()->enrolment_no) {
            return redirect()->route('events.index')->with('error', 'Only students can register for events.');
        }
        return view('event-register', compact('event'));
    }

    public function register(Request $request, $eventId)
    {
        if (auth()->user()->user_type !== 'student' || !auth()->user()->enrolment_no) {
            return redirect()->back()->with('error', 'Only students with a valid enrolment number can register for events.');
        }

        $event = Event::findOrFail($eventId);

        // ✅ Fetch settings
        $settings = \App\Models\Setting::first();
        $category = $event->type; // 'outdoor', 'indoor', 'cultural'

        // ✅ Count how many events this user/enrolment has already registered for in this category
        $enrolmentsToCheck = $event->is_group
            ? $request->input('enrolment_numbers', [])
            : [$request->input('enrolment_number')];

        foreach ($enrolmentsToCheck as $enrolment) {
            $count = \App\Models\EventRegistration::whereHas('event', function ($q) use ($category) {
                $q->where('type', $category);
            })
                ->where('participant_enrolment', $enrolment)
                ->count();

            $limit = match ($category) {
                'outdoor'  => $settings->max_outdoor_events,
                'indoor'   => $settings->max_indoor_events,
                'cultural' => $settings->max_cultural_events,
                default    => 0,
            };

            if ($limit > 0 && $count >= $limit) {
                return redirect()->back()
                    ->with('error', "⚠ Registration failed: Enrolment {$enrolment} can only register for {$limit} {$category} event(s).");
            }
        }

        // ✅ Existing logic continues unchanged
        if ($event->is_group) {
            $leaderEnrolment = $request->input('enrolment_numbers.0'); // first enrolment is leader
            $participantEnrolments = $request->input('enrolment_numbers');

            // Check for duplicates in input
            if (count($participantEnrolments) !== count(array_unique($participantEnrolments))) {
                return redirect()->back()->with('error', 'Enrolment numbers must be unique within the group.');
            }

            // Check if max participants exceeded
            $currentCount = EventRegistration::where('event_id', $event->event_id)->count();
            $numNewParticipants = count($participantEnrolments);
            if ($currentCount + $numNewParticipants > $event->max_participants) {
                return redirect()->back()->with('error', '⚠ Registration failed: maximum number of participants reached for this event.');
            }

            $alreadyRegistered = [];
            foreach ($participantEnrolments as $participant) {
                // Check if participant already registered for this event
                $exists = EventRegistration::where('event_id', $event->event_id)
                    ->where('participant_enrolment', $participant)
                    ->exists();

                if ($exists) {
                    $alreadyRegistered[] = $participant;
                } else {
                    EventRegistration::create([
                        'event_id' => $event->event_id,
                        'leader_enrolment' => $leaderEnrolment,
                        'participant_enrolment' => $participant,
                    ]);
                }
            }

            if (!empty($alreadyRegistered)) {
                $msg = 'The following enrolment numbers are already registered: ' . implode(', ', $alreadyRegistered);
                return redirect()->back()->with('error', $msg);
            }
        } else {
            $enrolment = $request->input('enrolment_number');

            // Check if max participants exceeded
            $currentCount = EventRegistration::where('event_id', $event->event_id)->count();
            if ($currentCount + 1 > $event->max_participants) {
                return redirect()->back()->with('error', '⚠ Registration failed: maximum number of participants reached for this event.');
            }

            $exists = EventRegistration::where('event_id', $event->event_id)
                ->where('participant_enrolment', $enrolment)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'You are already registered for this event.');
            }

            EventRegistration::create([
                'event_id' => $event->event_id,
                'leader_enrolment' => $enrolment,
                'participant_enrolment' => $enrolment,
            ]);
        }

        return redirect()->route('events.index')->with('success', '🎉 Registration successful! You will be contacted for further communication.');
    }

    public function myRegistrations()
    {
        $userEnrol = auth()->user()->enrolment_no;

        $registrations = EventRegistration::with('event')
            ->where('leader_enrolment', $userEnrol)
            ->orWhere('participant_enrolment', $userEnrol)
            ->get()
            ->groupBy('event_id')
            ->map(function ($group) use ($userEnrol) {
                $first = $group->first();
                $first->is_leader = $first->leader_enrolment === $userEnrol;
                return $first;
            })
            ->filter(fn($r) => $r->event !== null);

        // Registrations by category
        $categoryStats = [
            'Indoor' => $registrations->filter(fn($r) => strtolower($r->event->type) === 'indoor')->count(),
            'Outdoor' => $registrations->filter(fn($r) => strtolower($r->event->type) === 'outdoor')->count(),
            'Cultural' => $registrations->filter(fn($r) => strtolower($r->event->type) === 'cultural')->count(),
        ];

        return view('my_registrations', [
            'registrations' => $registrations,
            'categoryStats' => $categoryStats,
        ]);
    }
}
