<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Convert enrolment_no to uppercase before processing
        $enrolmentNo = strtoupper(trim($request->input('enrolment_no', '')));
        $request->merge(['enrolment_no' => $enrolmentNo]);

        $request->validate([
            'enrolment_no' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $email = trim($request->input('email'));
        $name = trim($request->input('name'));
        $branch = trim($request->input('branch', ''));
        $semester = trim($request->input('semester', ''));
        $gender = trim($request->input('gender', ''));
        $school = trim($request->input('school', ''));
        $password = $request->input('password');

        // Prevent duplicate registration
        if (User::where('email', $email)->orWhere('enrolment_no', $enrolmentNo)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'An account with this email or enrollment number is already registered. Please login.'
            ]);
        }

        // Find or create student record
        $student = Student::where('enroll_no', $enrolmentNo)->first();
        if (!$student) {
            $student = Student::create([
                'enroll_no' => $enrolmentNo,
                'full_name' => $name,
                'email' => $email,
                'program_code' => $branch ?: 'N/A',
                'semester' => $semester ?: '1',
                'gender' => $gender ?: 'N/A',
                'school_name' => $school ?: 'N/A',
                'dept_code' => 'SOCS',
                'school_code' => 'SOCS',
                'password' => Hash::make($password),
                'is_tms' => 0,
                'createdAt' => now(),
                'updatedAt' => now(),
            ]);
        } else {
            // Update student details if provided
            $student->update([
                'full_name' => $name ?: $student->full_name,
                'email' => $email ?: $student->email,
                'program_code' => $branch ?: $student->program_code,
                'semester' => $semester ?: $student->semester,
                'gender' => $gender ?: $student->gender,
                'school_name' => $school ?: $student->school_name,
                'password' => Hash::make($password),
                'updatedAt' => now(),
            ]);
        }

        // Create user (Laravel users table)
        $user = User::create([
            'enrolment_no' => $enrolmentNo,
            'name' => $name ?: $student->full_name,
            'email' => $email ?: $student->email,
            'password' => Hash::make($password),
        ]);

        // Send confirmation email safely
        try {
            Mail::send('emails.account-created', [
                'studentName' => $name,
                'studentEmail' => $email,
                'studentPassword' => '****** (as created)',
                'loginUrl' => route('login')
            ], function ($message) use ($email) {
                $message->to($email)
                    ->subject('Your CampusConnect Account Details')
                    ->from(config('mail.from.address', 'noreply@campusconnect.ac.in'), config('mail.from.name', 'CampusConnect'));
            });
        } catch (\Exception $e) {
            Log::warning('Registration email sending failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully! You can now log in using your created password.'
        ]);
    }
}
