<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soty;
use Illuminate\Support\Facades\Storage;
use App\Models\Student; 

class SotyController extends Controller
{
    /**
     * Show the SOTY application form.
     */
    public function index(Request $request)
    {
        $query = Soty::with('student');

        // 🔍 Search by enrolment, name, or email
        if ($search = $request->input('search')) {
            $query->where('enrolment_no', 'like', "%{$search}%")
                ->orWhereHas('student', function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
        }

        // 🎚 Filter by date range
        if ($from = $request->input('from_date')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->input('to_date')) {
            $query->whereDate('created_at', '<=', $to);
        }

        // 🎚 Filter by gender
        if ($gender = $request->input('gender')) {
            $query->whereHas('student', function ($q) use ($gender) {
                $q->where('gender', $gender);
            });
        }

        // 🎚 Filter by program
        if ($program = $request->input('program')) {
            $query->whereHas('student', function ($q) use ($program) {
                $q->where('program', $program);
            });
        }

        // 🎚 Filter by semester
        if ($semester = $request->input('semester')) {
            $query->whereHas('student', function ($q) use ($semester) {
                $q->where('semester', $semester);
            });
        }

        // 📄 Paginate results
        $submissions = $query->paginate(15)->appends($request->all());

        return view('admin.soty.index', compact('submissions'));
    }

    public function create()
    {
        $user = auth()->user();

        // Fetch student details from students table
        $student = Student::where('enroll_no', $user->enrolment_no)->first();

        if (!$student) {
            return redirect('/')->with('error', 'Only registered students can apply for Student of the Year.');
        }

        // Check if student has already applied
        $soty = Soty::where('enrolment_no', $student->enroll_no)->first();

        // Pass student info and existing submission (if any) to the view
        return view('soty.apply', compact('student', 'soty'));
    }


    /**
     * Store the SOTY application.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Fetch student
        $student = Student::where('enroll_no', $user->enrolment_no)->first();
        if (!$student) {
            return redirect()->back()->with('error', 'Student details not found.');
        }

        // Validation
        $request->validate([
            'even_attendance' => 'required|numeric|min:0|max:100',
            'odd_attendance'  => 'required|numeric|min:0|max:100',
            'even_cgpa'       => 'required|numeric|min:0|max:10',
            'odd_cgpa'        => 'required|numeric|min:0|max:10',
            'details'         => 'required|string|max:2000',
            'question'        => 'required|string|max:2000',
            'file'            => 'required|mimes:zip|max:10240', // max 10MB
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Sanitize full name to remove spaces/special chars
            $fullName = preg_replace('/[^A-Za-z0-9]/', '_', $student->full_name);

            // Create custom filename
            $filename = $student->enroll_no . '_' . $fullName . '_documents.' . $file->getClientOriginalExtension();

            // Store in "soty" folder
            $path = $file->storeAs('soty', $filename, 'public');
        } else {
            return redirect()->back()->with('error', 'File upload failed.');
        }


        // Save to DB
        Soty::create([
            'enrolment_no'     => $student->enroll_no,
            'even_attendance'  => $request->even_attendance,
            'odd_attendance'   => $request->odd_attendance,
            'even_cgpa'        => $request->even_cgpa,
            'odd_cgpa'         => $request->odd_cgpa,
            'details'          => $request->details,
            'question'         => $request->question,
            'file_location'    => $path,
        ]);

        return redirect()->back()->with('success', 'Your application for Student of the Year has been submitted successfully.');
    }

    public function destroy($id)
    {
        $soty = Soty::findOrFail($id);

        // Delete file if exists
        if ($soty->file_location && \Storage::disk('public')->exists($soty->file_location)) {
            \Storage::disk('public')->delete($soty->file_location);
        }

        // Delete record
        $soty->delete();

        return redirect()->back()->with('success', 'Submission deleted successfully.');
    }
}
