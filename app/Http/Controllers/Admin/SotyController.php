<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soty;
use App\Models\Student;

class SotyController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Base query with student relation
        $query = Soty::with('student');

        // 🔍 Search filter (by enrolment, name, email)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('enrolment_no', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($sub) use ($search) {
                        $sub->where('full_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('enroll_no', 'like', "%{$search}%");
                    });
            });
        }

        // 🎚 Gender filter
        if ($gender = $request->input('gender')) {
            $query->whereHas(
                'student',
                fn($q) =>
                $q->where('gender', strtoupper($gender))
            );
        }

        // 🎚 Program filter
        if ($program = $request->input('program')) {
            $query->whereHas(
                'student',
                fn($q) =>
                $q->where('program_code', 'like', "%{$program}%")
            );
        }

        // 🎚 Semester filter
        if ($semester = $request->input('semester')) {
            $query->whereHas(
                'student',
                fn($q) =>
                $q->where('semester', $semester)
            );
        }

        // 📅 Date range filters
        if ($from = $request->input('from_date')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->input('to_date')) {
            $query->whereDate('created_at', '<=', $to);
        }

        // ⏱ Sorting (optional: default latest)
        $submissions = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.soty.index', compact('submissions'));
    }

    // app/Http/Controllers/Admin/SotyController.php

    public function deleteAll()
    {
        if (auth()->user()->user_type !== "admin") {
            abort(403, 'Unauthorized action.');
        }

        Soty::truncate();

        return redirect()->back('admin.soty.index')
            ->with('success', 'All submissions deleted successfully.');
    }
}
