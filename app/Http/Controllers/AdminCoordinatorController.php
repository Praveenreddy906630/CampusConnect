<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Coordinator;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Mail\CoordinatorWelcomeMail;
use Illuminate\Support\Facades\Mail;

class AdminCoordinatorController extends Controller
{
    // List all coordinators
    public function index()
    {
        // eager load user + multiple events
        $coordinators = Coordinator::with('user', 'events')->get();
        return view('admin.coordinators.index', compact('coordinators'));
    }

    public function create()
    {
        // Step 1: Get all events that are NOT assigned to any coordinator
        $assignedEventIds = \DB::table('coordinator_event')->pluck('event_id'); // pivot table

        // Step 2: Fetch only unassigned events
        $events = \App\Models\Event::whereNotIn('event_id', $assignedEventIds)->get();

        return view('admin.coordinators.create', compact('events'));
    }

    // Store coordinator
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6',
            'event_ids'  => 'required|array',
            'event_ids.*' => 'exists:events,event_id',
            'mobile'     => 'required',
            'school'     => 'required|string|max:50',
            'ext'        => 'nullable',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:5000'
        ]);

        // Create user
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'user_type' => 'coordinator'
        ]);

        // Handle profile picture
        $profilePicPath = null;
        if ($request->hasFile('profile_pic')) {
            $profilePicPath = $request->file('profile_pic')->store('coordinators', 'public');
        }

        // Create coordinator record
        $coordinator = Coordinator::create([
            'user_id'     => $user->id,
            'mobile'      => $request->mobile,
            'ext'         => $request->ext,
            'school'      => $request->school,
            'profile_pic' => $profilePicPath
        ]);

        // Attach events
        $coordinator->events()->attach($request->event_ids);

        // 📨 Send welcome email
        $eventNames = Event::whereIn('event_id', $request->event_ids)->pluck('event_name')->toArray();
        Mail::to($request->email)->send(new CoordinatorWelcomeMail(
            $request->name,
            $request->email,
            $request->password,
            $eventNames
        ));

        return redirect()->route('admin.coordinators.index')->with('success', 'Coordinator added and email sent successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $coordinator = Coordinator::with(['user', 'events'])->findOrFail($id);
        $events = Event::all();
        return view('admin.coordinators.edit', compact('coordinator', 'events'));
    }

    // Update coordinator
    public function update(Request $request, $id)
    {
        $coordinator = Coordinator::with('user')->findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email,' . $coordinator->user_id,
            'password'   => 'nullable|string|min:6',
            'event_ids'  => 'required|array',
            'event_ids.*' => 'exists:events,event_id',
            'mobile'     => 'required',
            'school'     => 'required|string|max:50',
            'ext'        => 'nullable',
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:5000'
        ]);

        // 1️⃣ Update user info
        $coordinator->user->name  = $request->name;
        $coordinator->user->email = $request->email;
        if ($request->filled('password')) {
            $coordinator->user->password = Hash::make($request->password);
        }
        $coordinator->user->save();

        // 2️⃣ Handle profile picture
        if ($request->hasFile('profile_pic')) {
            // delete old if exists
            if ($coordinator->profile_pic && Storage::disk('public')->exists($coordinator->profile_pic)) {
                Storage::disk('public')->delete($coordinator->profile_pic);
            }
            $coordinator->profile_pic = $request->file('profile_pic')->store('coordinators', 'public');
        }

        // 3️⃣ Update coordinator info
        $coordinator->mobile = $request->mobile;
        $coordinator->ext    = $request->ext;
        $coordinator->school = $request->school;
        $coordinator->save();

        // 4️⃣ Sync events (replace old ones with new selections)
        $coordinator->events()->sync($request->event_ids);

        return redirect()->route('admin.coordinators.index')->with('success', 'Coordinator updated successfully.');
    }

    // 🗑️ Delete coordinator (and linked user)
    public function destroy($id)
    {
        $coordinator = Coordinator::with('events')->findOrFail($id);

        // Detach all events
        $coordinator->events()->detach();

        // 🗑️ Delete profile picture file if it exists
        if ($coordinator->profile_pic && Storage::disk('public')->exists($coordinator->profile_pic)) {
            Storage::disk('public')->delete($coordinator->profile_pic);
        }

        // Delete related user as well
        $user = $coordinator->user;
        if ($user) {
            $user->delete();
        }

        // Delete coordinator record
        $coordinator->delete();

        return redirect()->route('admin.coordinators.index')->with('success', 'Coordinator deleted successfully.');
    }
}
