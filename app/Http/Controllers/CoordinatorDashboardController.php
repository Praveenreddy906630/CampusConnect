<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class CoordinatorDashboardController extends Controller
{
    // Coordinator Dashboard
    public function index()
    {
        $coordinator = Coordinator::with('events')->where('user_id', Auth::id())->first();

        if (!$coordinator || $coordinator->events->isEmpty()) {
            abort(403, 'No events assigned.');
        }

        // all event ids for this coordinator
        $eventIds = $coordinator->events->pluck('event_id')->toArray();

        // totals across all coordinator events
        $registrationsCount = EventRegistration::whereIn('event_id', $eventIds)->count();

        // accurate unique participants across all events (not summing per-event uniques)
        $uniqueParticipantsCount = EventRegistration::whereIn('event_id', $eventIds)
            ->distinct('participant_enrolment')
            ->count('participant_enrolment');

        // per-event stats and recent registrations
        $eventStats = collect();
        $recentRegistrations = collect();

        foreach ($coordinator->events as $event) {
            $registrationsCountForEvent = EventRegistration::where('event_id', $event->event_id)->count();

            $uniqueParticipantsCountForEvent = EventRegistration::where('event_id', $event->event_id)
                ->distinct('participant_enrolment')
                ->count('participant_enrolment');

            $recentRegs = EventRegistration::with(['participant', 'event'])
                ->where('event_id', $event->event_id)
                ->latest()
                ->take(5)
                ->get();

            $eventStats->push([
                'event_id' => $event->event_id,
                'event_name' => $event->event_name,
                'registrations_count' => $registrationsCountForEvent,
                'unique_participants_count' => $uniqueParticipantsCountForEvent,
            ]);

            $recentRegistrations = $recentRegistrations->merge($recentRegs);
        }

        // sort merged recents by newest first, reindex and limit to 10
        $recentRegistrations = $recentRegistrations->sortByDesc('created_at')->values()->take(10);

        // backward-compatible totals expected by some blades
        $totalRegistrations = $registrationsCount;
        $totalUniqueParticipants = $uniqueParticipantsCount;

        return view('coordinator.coordinator_dashboard', compact(
            'coordinator',
            'registrationsCount',
            'uniqueParticipantsCount',
            'eventStats',
            'recentRegistrations',
            'totalRegistrations',
            'totalUniqueParticipants'
        ));
    }

    public function myevents()
    {
        $coordinator = Coordinator::with('events')->where('user_id', Auth::id())->first();

        if (!$coordinator || $coordinator->events->isEmpty()) {
            abort(403, 'No events assigned.');
        }

        // For now pick the first assigned event
        $event = $coordinator->events->first();

        // Count participants
        $registrationsCount = EventRegistration::where('event_id', $event->event_id)->count();

        return view('coordinator.dashboard', compact('event', 'registrationsCount', 'coordinator'));
    }

    // Show participants
    public function participants(Request $request, $eventId)
    {
        $coordinator = Coordinator::with('events')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $event = $coordinator->events
            ->where('event_id', $eventId)
            ->firstOrFail();

        // Base query (scoped to this event)
        $query = EventRegistration::where('event_id', $event->event_id)
            ->with(['leader', 'participant']);

        // Search (name, email, enroll_no)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('participant', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('enroll_no', 'like', "%{$search}%");
            });
        }

        // Gender filter: accept 'male'/'female' or 'M'/'F'
        if ($request->filled('gender')) {
            $inputGender = $request->gender;
            $map = [
                'male' => 'M',
                'female' => 'F',
                'm' => 'M',
                'f' => 'F',
                'M' => 'M',
                'F' => 'F',
            ];
            $key = $map[strtolower($inputGender)] ?? ($map[$inputGender] ?? null);
            if ($key) {
                $query->whereHas('participant', function ($q) use ($key) {
                    $q->where('gender', $key);
                });
            }
        }

        // Program code filter
        if ($request->filled('program_code')) {
            $programCode = $request->program_code;
            $query->whereHas('participant', function ($q) use ($programCode) {
                $q->where('program_code', $programCode);
            });
        }

        // Sorting & pagination (preserve query params)
        $sort = $request->get('sort', 'participant_enrolment');
        $dir  = $request->get('direction', 'asc');
        $registrations = $query->orderBy($sort, $dir)
            ->paginate(20)
            ->appends($request->except('page'));

        // Group if group event (note: grouping a paginator groups current page)
        if ($event->is_group) {
            $groupedRegistrations = $registrations->groupBy('leader_enrolment');
        } else {
            $groupedRegistrations = $registrations;
        }

        // Program-wise stats for this event
        $programStats = \DB::table('event_registrations as er')
            ->join('students as s', 'er.participant_enrolment', '=', 's.enroll_no')
            ->where('er.event_id', $event->event_id)
            ->select(
                's.program_code',
                \DB::raw("SUM(CASE WHEN UPPER(s.gender) = 'M' THEN 1 ELSE 0 END) as males"),
                \DB::raw("SUM(CASE WHEN UPPER(s.gender) = 'F' THEN 1 ELSE 0 END) as females"),
                \DB::raw("COUNT(*) as total")
            )
            ->groupBy('s.program_code')
            ->orderBy('s.program_code')
            ->get();

        // Program codes for filter dropdown (only those present in this event)
        $programCodes = \DB::table('students as s')
            ->join('event_registrations as er', 'er.participant_enrolment', '=', 's.enroll_no')
            ->where('er.event_id', $event->event_id)
            ->distinct()
            ->orderBy('s.program_code')
            ->pluck('s.program_code');

        // Gender options for filter dropdown (use keys 'M' / 'F' in the select values)
        $genderOptions = [
            ''  => 'All',
            'M' => 'Male',
            'F' => 'Female',
        ];
        // Gender stats for this event
        $genderStats = DB::table('event_registrations as er')
            ->join('students as s', 'er.participant_enrolment', '=', 's.enroll_no')
            ->where('er.event_id', $event->event_id)
            ->selectRaw("
        SUM(CASE WHEN UPPER(s.gender) = 'M' THEN 1 ELSE 0 END) as males,
        SUM(CASE WHEN UPPER(s.gender) = 'F' THEN 1 ELSE 0 END) as females
    ")
            ->first();

        $genderStats = [
            'male'   => $genderStats->males ?? 0,
            'female' => $genderStats->females ?? 0,
        ];


        return view('coordinator.participants', compact(
            'event',
            'groupedRegistrations',
            'programStats',
            'registrations',
            'programCodes',
            'genderOptions',
            'genderStats'
        ));
    }

    // Send mail to participants
    public function sendMail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $coordinator = Coordinator::with('events', 'user')->where('user_id', Auth::id())->first();

        if (!$coordinator || $coordinator->events->isEmpty()) {
            abort(403, 'No events assigned.');
        }

        $event = $coordinator->events->first();
        $coordinatorUser = $coordinator->user;

        $registrations = EventRegistration::where('event_id', $event->event_id)
            ->with('participant')
            ->get();

        foreach ($registrations as $reg) {
            if ($reg->participant && $reg->participant->email) {
                Mail::raw($request->message, function ($mail) use ($reg, $request, $event, $coordinatorUser) {
                    $mail->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $mail->replyTo($coordinatorUser->email, $coordinatorUser->name);
                    $mail->to($reg->participant->email)
                        ->subject("[{$event->event_name}] " . $request->subject);
                });
            }
        }

        return back()->with('success', 'Emails sent successfully!');
    }

    // // Export participants
    // public function exportParticipants()
    // {
    //     $coordinator = Coordinator::with('events')
    //         ->where('user_id', auth()->id())
    //         ->firstOrFail();

    //     if ($coordinator->events->isEmpty()) {
    //         abort(403, 'No events assigned.');
    //     }

    //     $event = $coordinator->events->first();

    //     $registrations = EventRegistration::where('event_id', $event->event_id)
    //         ->with('participant')
    //         ->get();

    //     // CSV headers
    //     $headers = [
    //         'Sr No.',
    //         'name',
    //         'email',
    //         'enrolment',
    //         'mobile',
    //         'semester',
    //         'program_code',
    //     ];

    //     // Build rows
    //     $rows = [];
    //     $sr = 1;
    //     foreach ($registrations as $reg) {
    //         $student = $reg->participant;
    //         $rows[] = [
    //             $sr++,
    //             $student?->full_name ?? 'N/A',
    //             $student?->email ?? 'N/A',
    //             $reg->participant_enrolment,
    //             $student?->mobile ?? 'N/A',
    //             $student?->semester ?? 'N/A',
    //             $student?->program_code ?? 'N/A',
    //         ];
    //     }

    //     $filename = "participants_export_" . now()->format('Y_m_d_H_i') . ".csv";

    //     // Write to temp file
    //     $handle = fopen('php://temp', 'r+');
    //     fputcsv($handle, $headers);

    //     foreach ($rows as $row) {
    //         fputcsv($handle, $row);
    //     }

    //     rewind($handle);
    //     $csvContent = stream_get_contents($handle);
    //     fclose($handle);

    //     return response($csvContent, 200, [
    //         'Content-Type' => 'text/csv',
    //         'Content-Disposition' => "attachment; filename=\"$filename\"",
    //     ]);
    // }

    // Delete a participant
    public function deleteParticipant($eventId, $participantId)
    {
        $coordinator = Coordinator::with('events')->where('user_id', auth()->id())->firstOrFail();
        $registration = EventRegistration::findOrFail($participantId);

        // Ensure the participant belongs to this coordinator's event
        if (!$coordinator->events->pluck('event_id')->contains($registration->event_id) || $registration->event_id != $eventId) {
            abort(403, 'Unauthorized action.');
        }

        $registration->delete();

        return back()->with('success', 'Participant deleted successfully.');
    }

    public function exportParticipants($eventId)
    {
        $coordinator = Coordinator::with('events')->where('user_id', auth()->id())->firstOrFail();

        // Ensure the coordinator has this event
        $event = $coordinator->events->where('event_id', $eventId)->firstOrFail();

        $registrations = EventRegistration::where('event_id', $event->event_id)
            ->with('participant')
            ->get();

        $headers = [
            'Sr No.',
            'Name',
            'Email',
            'Enrolment',
            'Mobile',
            'Semester',
            'Program Code',
            'School Code',
        ];

        $filename = "participants_{$event->event_name}_" . now()->format('Y_m_d_H_i') . ".csv";

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $headers);

        $sr = 1;
        foreach ($registrations as $reg) {
            $student = $reg->participant;
            fputcsv($handle, [
                $sr++,
                $student?->full_name ?? 'N/A',
                $student?->email ?? 'N/A',
                $reg->participant_enrolment,
                $student?->mobile ?? 'N/A',
                $student?->semester ?? 'N/A',
                $student?->program_code ?? 'N/A',
                $student?->school_code ?? 'N/A',
            ]);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
}
