<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EventRegistration;
use App\Models\Setting;

class UserController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $settings = Setting::first();
        $maxOutdoor = $settings->max_outdoor_events ?? 0;
        $maxIndoor = $settings->max_indoor_events ?? 0;
        $maxCultural = $settings->max_cultural_events ?? 0;

        $sortBy = $request->get('sort_by', 'created_at');
        $direction = $request->get('direction', 'desc');
        
        $allowedSorts = ['name', 'email', 'user_type', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        $users = User::orderBy($sortBy, $direction)->paginate(20);

        foreach ($users as $user) {
            $enrolment = $user->enrolment_no;

            $user->events_count = [
                'outdoor' => EventRegistration::where('participant_enrolment', $enrolment)
                    ->whereHas('event', fn($q) => $q->where('type', 'outdoor'))
                    ->count(),
                'indoor' => EventRegistration::where('participant_enrolment', $enrolment)
                    ->whereHas('event', fn($q) => $q->where('type', 'indoor'))
                    ->count(),
                'cultural' => EventRegistration::where('participant_enrolment', $enrolment)
                    ->whereHas('event', fn($q) => $q->where('type', 'cultural'))
                    ->count(),
            ];

            $user->max_allowed = [
                'outdoor' => $maxOutdoor,
                'indoor' => $maxIndoor,
                'cultural' => $maxCultural,
            ];
        }

        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Optional: prevent admin from deleting themselves
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function deleteAll()
    {
        // Prevent deleting admins or self
        $deletedCount = User::where('user_type', '!=', 'admin')
            ->where('id', '!=', auth()->id())
            ->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "All non-admin users deleted successfully! ($deletedCount users removed)");
    }
}
