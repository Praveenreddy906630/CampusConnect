<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventRegistration;

class RegistrationController extends Controller
{
    public function index()
    {
        $events = Event::withCount('registrations')->get()->groupBy('type');
        return view('admin.registrations.index', compact('events'));
    }

    public function show(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        // ✅ Base query
        $query = EventRegistration::with(['leader', 'participant'])
            ->where('event_id', $event->event_id);

        // 🔍 Search filter (leader OR any participant)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('participant_enrolment', 'like', "%{$search}%")
                    ->orWhereHas('participant', function ($sub) use ($search) {
                        $sub->where('full_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('enroll_no', 'like', "%{$search}%");
                    })
                    ->orWhereHas('leader', function ($sub) use ($search) {
                        $sub->where('full_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('enroll_no', 'like', "%{$search}%");
                    });
            });
        }

        // 🎚 Filter by gender
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

        // 🎚 Filter by program_code
        if ($program = $request->input('program_code')) {
            $query->whereHas(
                'participant',
                fn($q) =>
                $q->where('program_code', $program)
            );
        }

        // 🎚 Date range filters
        if ($from = $request->input('from_date')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->input('to_date')) {
            $query->whereDate('created_at', '<=', $to);
        }

        // ↕️ Sorting
        $sort = $request->get('sort', 'participant_enrolment');
        $dir  = $request->get('direction', 'asc');
        $registrations = $query->orderBy($sort, $dir)->paginate(20);

        // 👥 Always return groups for Blade
        if ($event->is_group) {
            $groups = $registrations->groupBy('leader_enrolment');
        } else {
            $groups = collect([
                'individuals' => $registrations
            ]);
        }

        // 📊 Stats per program_code (this event only)
        $programStats = \DB::table('event_registrations as er')
            ->join('students as s', 'er.participant_enrolment', '=', 's.enroll_no')
            ->where('er.event_id', $event->event_id)
            ->select(
                's.program_code',
                \DB::raw("SUM(CASE WHEN LOWER(s.gender) = 'm' THEN 1 ELSE 0 END) as males"),
                \DB::raw("SUM(CASE WHEN LOWER(s.gender) = 'f' THEN 1 ELSE 0 END) as females"),
                \DB::raw("COUNT(*) as total")
            )
            ->groupBy('s.program_code')
            ->orderBy('s.program_code')
            ->get();

        // 📊 Gender stats (this event only)
        $genderStatsRaw = \DB::table('event_registrations as er')
            ->join('students as s', 'er.participant_enrolment', '=', 's.enroll_no')
            ->where('er.event_id', $event->event_id)
            ->selectRaw("
                SUM(CASE WHEN LOWER(s.gender) = 'm' THEN 1 ELSE 0 END) as male,
                SUM(CASE WHEN LOWER(s.gender) = 'f' THEN 1 ELSE 0 END) as female
            ")
            ->first();

        $genderStats = [
            'male'   => $genderStatsRaw->male ?? 0,
            'female' => $genderStatsRaw->female ?? 0,
        ];

        // Distinct program codes for filter dropdown
        $programCodes = \DB::table('students')->distinct()->pluck('program_code');

        return view('admin.registrations.show', compact(
            'event',
            'registrations',
            'groups',
            'programStats',
            'programCodes',
            'genderStats'
        ));
    }

    public function destroy($id)
    {
        $reg = EventRegistration::findOrFail($id);
        $reg->delete();

        return back()->with('success', 'Registration deleted successfully.');
    }

    public function deleteAll($eventId)
    {
        EventRegistration::where('event_id', $eventId)->delete();

        return back()->with('success', 'All registrations deleted successfully.');
    }
}
