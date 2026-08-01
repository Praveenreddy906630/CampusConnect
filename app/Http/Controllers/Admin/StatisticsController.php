<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Soty;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index() {
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

        $eventStats = DB::table('event_registrations as er')
            ->join('students as s', 'er.participant_enrolment', '=', 's.enroll_no')
            ->join('events as e', 'er.event_id', '=', 'e.event_id')
            ->select(
                'e.event_id',
                'e.event_name',
                's.program_code',
                DB::raw("SUM(CASE WHEN UPPER(s.gender) = 'M' THEN 1 ELSE 0 END) as males"),
                DB::raw("SUM(CASE WHEN UPPER(s.gender) = 'F' THEN 1 ELSE 0 END) as females"),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('e.event_id', 'e.event_name', 's.program_code')
            ->orderBy('e.event_name')
            ->orderBy('s.program_code')
            ->get()
            ->groupBy('event_id'); // group rows under each event

        // Fetch events list (preserve events with NO registrations if needed)
        $events = Event::orderBy('event_name')->get();

        return view('admin.statistics', compact(
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
