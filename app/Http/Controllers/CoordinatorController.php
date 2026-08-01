<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CoordinatorController extends Controller
{
    // Dashboard: show assigned events + total registrations
    public function dashboard()
    {
        $coordinator = auth()->user()->coordinator;
        $events = $coordinator->events; // now multiple

        // total registrations across all assigned events
        $registrationsCount = EventRegistration::whereIn('event_id', $events->pluck('event_id'))->count();

        return view('coordinator.dashboard', compact('events', 'registrationsCount'));
    }

    // List registrations for all coordinator’s events
    public function registrations()
    {
        $coordinator = auth()->user()->coordinator;
        $registrations = EventRegistration::whereIn('event_id', $coordinator->events->pluck('event_id'))->get();

        return view('coordinator.registrations', compact('registrations'));
    }

    // Bulk email participants
    public function emailParticipants(Request $request)
    {
        $coordinator = auth()->user()->coordinator;
        $registrations = EventRegistration::whereIn('event_id', $coordinator->events->pluck('event_id'))->get();

        foreach ($registrations as $registration) {
            $email = $registration->user->email ?? null;
            if ($email) {
                Mail::raw($request->message, function ($m) use ($email) {
                    $m->to($email)->subject('Message from Coordinator');
                });
            }
        }

        return back()->with('success', 'Emails sent successfully!');
    }

    // Public index of coordinators
    public function publicIndex()
    {
        $coordinators = Coordinator::with(['user', 'events'])->get();
        return view('public.coordinators.index', compact('coordinators'));
    }

    public function publicShow($id)
    {
        $coordinator = Coordinator::with(['user', 'events'])->findOrFail($id);
        return view('public.coordinators.show', compact('coordinator'));
    }
    public function show($eventId, Request $request)
    {
        $event = \App\Models\Event::findOrFail($eventId);

        // Base query
        $registrations = \App\Models\EventRegistration::with(['participant'])
            ->where('event_id', $event->event_id)
            ->join('students', 'event_registrations.participant_enrolment', '=', 'students.enroll_no')
            ->select('event_registrations.*', 'students.school_code')
            ->orderBy('students.school_code') // ✅ sort by school_code
            ->get();

        // Grouping if event is group-based
        $groupedRegistrations = $event->is_group
            ? $registrations->groupBy('leader_enrolment')
            : $registrations;

        // Stats by program
        $programStats = \DB::table('event_registrations as er')
            ->join('students as s', 'er.participant_enrolment', '=', 's.enroll_no')
            ->where('er.event_id', $event->event_id)
            ->selectRaw('s.program_code, 
            SUM(CASE WHEN LOWER(s.gender) = "m" THEN 1 ELSE 0 END) as males,
            SUM(CASE WHEN LOWER(s.gender) = "f" THEN 1 ELSE 0 END) as females,
            COUNT(*) as total')
            ->groupBy('s.program_code')
            ->orderBy('s.program_code') // sort program stats too
            ->get();

        // Gender Stats
        $genderStats = \DB::table('event_registrations as er')
            ->join('students as s', 'er.participant_enrolment', '=', 's.enroll_no')
            ->where('er.event_id', $event->event_id)
            ->selectRaw("
            SUM(CASE WHEN LOWER(s.gender) = 'm' THEN 1 ELSE 0 END) as male,
            SUM(CASE WHEN LOWER(s.gender) = 'f' THEN 1 ELSE 0 END) as female
        ")
            ->first();

        $genderStats = [
            'male' => $genderStats->male ?? 0,
            'female' => $genderStats->female ?? 0,
        ];

        // Program codes for dropdowns
        $programCodes = $programStats->pluck('program_code')->unique();

        return view('coordinator.participants', compact(
            'event',
            'registrations',
            'groupedRegistrations',
            'programStats',
            'genderStats',
            'programCodes'
        ));
    }
}
