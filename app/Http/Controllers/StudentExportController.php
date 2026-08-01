<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class StudentExportController extends Controller
{
    public function export()
    {
        $students = Student::all();

        $headers = [
            'id',
            'enroll_no',
            'full_name',
            'program_code',
            'gender',
            'mobile',
            'email',
            'dept_code',
            'school_code',
            'school_name',
            'semester',
            'password',
            'is_tms',
            'createdAt',
            'updatedAt'
        ];

        $rows = [];
        foreach ($students as $student) {
            $rows[] = [
                $student->id,
                $student->enroll_no,
                $student->full_name,
                $student->program_code,
                $student->gender,
                $student->mobile,
                $student->email,
                $student->dept_code,
                $student->school_code,
                $student->school_name,
                $student->semester,
                $student->password,
                $student->is_tms,
                $student->createdAt,
                $student->updatedAt,
            ];
        }

        $filename = "students_export_" . now()->format('Y_m_d_H_i') . ".csv";
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $headers);

        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file, 'r');

        $header = fgetcsv($handle); // First row
        $header = array_map(fn($h) => strtolower(trim($h)), $header);

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            Student::create([
                'enroll_no'     => $data['enroll_no'] ?? null,
                'full_name'     => $data['full_name'] ?? null,
                'program_code'  => $data['program_code'] ?? null,
                'gender'        => $data['gender'] ?? null,
                'mobile'        => $data['mobile'] ?? null,
                'email'         => $data['email'] ?? null,
                'dept_code'     => $data['dept_code'] ?? null,
                'school_code'   => $data['school_code'] ?? null,
                'school_name'   => $data['school_name'] ?? null,
                'semester'      => $data['semester'] ?? null,
                'password'      => $data['password'] ?? '0',  // default 0
                'is_tms'        => $data['is_tms'] ?? 0,
                'createdAt'     => $data['createdAt'] ?? now(),
                'updatedAt'     => $data['updatedAt'] ?? now(),
            ]);
        }

        fclose($handle);

        return redirect()->back()->with('success', 'Students imported successfully.');
    }
}
