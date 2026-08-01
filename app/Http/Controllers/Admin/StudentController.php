<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        // 1. Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('enroll_no', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('program_code', 'like', "%{$search}%")
                    ->orWhere('dept_code', 'like', "%{$search}%")
                    ->orWhere('school_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Filter (example: program_code, gender, semester)
        if ($program = $request->input('program_code')) {
            $query->where('program_code', $program);
        }
        if ($gender = $request->input('gender')) {
            $query->where('gender', $gender);
        }
        if ($semester = $request->input('semester')) {
            $query->where('semester', $semester);
        }

        // 3. Sorting
        $sortBy = $request->input('sort_by', 'id'); // default sort column
        $sortDir = $request->input('sort_dir', 'asc'); // default sort direction
        $query->orderBy($sortBy, $sortDir);

        // 4. Pagination
        $students = $query->paginate(15)->withQueryString();

        return view('admin.students.index', compact('students'));
    }

    public function deleteAll(Request $request)
    {
        // Optional: Add authorization check
        if (!auth()->user()->user_type == "admin") {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            // Get count before deletion for success message
            $studentCount = Student::count();
            
            // Delete all students
            Student::truncate(); // faster and resets auto-increment ID

            return redirect()->route('admin.students.index')
                ->with('success', "All {$studentCount} students deleted successfully.");

        } catch (\Exception $e) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Error deleting students: ' . $e->getMessage());
        }
    }

    public function export()
    {
        try {
            $fileName = 'students_' . date('Y-m-d_H-i-s') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ];

            $students = Student::all();
            
            if ($students->count() === 0) {
                return redirect()->back()->with('error', 'No students data available to export.');
            }

            $callback = function() use ($students) {
                $file = fopen('php://output', 'w');
                
                // Add CSV headers
                fputcsv($file, [
                    'Enrolment Number', 'Full Name', 'Program Code', 'Gender', 
                    'Phone', 'Email', 'Department Code', 'School Code', 
                    'School Name', 'Semester'
                ]);

                // Add data rows
                foreach ($students as $student) {
                    fputcsv($file, [
                        $student->enroll_no,
                        $student->full_name,
                        $student->program_code,
                        $student->gender,
                        $student->mobile,
                        $student->email,
                        $student->dept_code,
                        $student->school_code,
                        $student->school_name,
                        $student->semester
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Error exporting students: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240' // 10MB max
        ]);

        // Optional: Add authorization check
        if (!auth()->user()->user_type == "admin") {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            $file = $request->file('csv_file');
            $csvData = file_get_contents($file);
            $rows = array_map('str_getcsv', explode("\n", $csvData));
            $header = array_shift($rows);

            $importedCount = 0;
            $errorCount = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                // Skip empty rows
                if (empty($row) || count($row) != count($header)) {
                    continue;
                }

                try {
                    $studentData = array_combine($header, $row);
                    
                    // Validate required fields
                    if (empty($studentData['enroll_no']) || empty($studentData['full_name'])) {
                        $errorCount++;
                        $errors[] = "Row " . ($index + 2) . ": Missing required fields";
                        continue;
                    }

                    // Create or update student
                    Student::updateOrCreate(
                        ['enroll_no' => $studentData['enroll_no']],
                        [
                            'full_name' => $studentData['full_name'],
                            'program_code' => $studentData['program_code'] ?? null,
                            'gender' => $studentData['gender'] ?? null,
                            'mobile' => $studentData['mobile'] ?? null,
                            'email' => $studentData['email'] ?? null,
                            'dept_code' => $studentData['dept_code'] ?? null,
                            'school_code' => $studentData['school_code'] ?? null,
                            'school_name' => $studentData['school_name'] ?? null,
                            'semester' => $studentData['semester'] ?? null,
                        ]
                    );

                    $importedCount++;

                } catch (\Exception $e) {
                    $errorCount++;
                    $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            $message = "Import completed! {$importedCount} students imported successfully.";
            if ($errorCount > 0) {
                $message .= " {$errorCount} errors occurred.";
                // You might want to log the detailed errors
                \Log::warning('Student import errors', ['errors' => $errors]);
            }

            return redirect()->route('admin.students.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Error importing students: ' . $e->getMessage());
        }
    }
}