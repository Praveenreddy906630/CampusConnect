<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Soty;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalRegistrations = EventRegistration::count();
        $totalSoty = Soty::count();
        $recentSoty = Soty::orderBy('created_at', 'desc')->take(5)->get();

        // recent registrations (small preview)
        $recentRegistrations = EventRegistration::with(['event', 'participant'])
            ->latest()
            ->take(5)
            ->get();

        // // registrations grouped by event_id + program_code with male/female counts
        // $rows = DB::table('event_registrations as er')
        //     ->join('students as s', 'er.participant_enrolment', '=', 's.enroll_no') // ✅ corrected
        //     ->join('events as e', 'er.event_id', '=', 'e.event_id')                 // ✅ corrected
        //     ->select(
        //         'e.event_id',
        //         'e.event_name',
        //         's.program_code',
        //         DB::raw("SUM(CASE WHEN UPPER(s.gender) = 'M' THEN 1 ELSE 0 END) as males"),   // ✅ corrected
        //         DB::raw("SUM(CASE WHEN UPPER(s.gender) = 'F' THEN 1 ELSE 0 END) as females"), // ✅ corrected
        //         DB::raw("COUNT(*) as total")
        //     )
        //     ->groupBy('e.event_id', 'e.event_name', 's.program_code')
        //     ->orderBy('e.event_name')
        //     ->get();

        $eventStatsRaw = DB::table('event_registrations as er')
            ->join('events as e', 'er.event_id', '=', 'e.event_id')
            ->leftJoin('students as s', 'er.participant_enrolment', '=', 's.enroll_no')
            ->select(
                'e.event_id',
                'e.event_name',
                // normalize empty strings to 'Unknown'
                DB::raw("COALESCE(NULLIF(TRIM(s.school_code), ''), 'Unknown') as school_code"),
                // robust gender matching (handles 'm', 'M', 'male', ' Male ', etc.)
                DB::raw("SUM(CASE WHEN LOWER(TRIM(COALESCE(s.gender, ''))) LIKE 'm%' THEN 1 ELSE 0 END) as boys"),
                DB::raw("SUM(CASE WHEN LOWER(TRIM(COALESCE(s.gender, ''))) LIKE 'f%' THEN 1 ELSE 0 END) as girls"),
                // count registrations (safe with LEFT JOIN)
                DB::raw("COUNT(er.id) as total")
            )
            ->groupBy('e.event_id', 'e.event_name', 's.school_code')
            ->orderBy('e.event_name')
            ->orderBy('s.school_code')
            ->get();

        // IMPORTANT: group the collection by the actual column name returned: 'event_id'
        $eventStats = $eventStatsRaw->groupBy('event_id');


        // Fetch events list (preserve events with NO registrations if needed)
        $events = Event::orderBy('event_name')->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEvents',
            'totalRegistrations',
            'recentRegistrations',
            'totalSoty',
            'recentSoty',
            'eventStats',
            'events'
        ));
    }
}
