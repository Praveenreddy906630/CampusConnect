<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'event_date');
        $direction = $request->get('direction', 'asc');
        
        // Allowed sort columns to prevent SQL injection
        $allowedSorts = ['event_name', 'type', 'is_group', 'event_date', 'venue', 'max_participants'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'event_date';
        }

        $events = Event::orderBy($sortBy, $direction)->get();
        return view('admin.events.index', compact('events', 'sortBy', 'direction'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'venue' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable',
            'is_group' => 'required|boolean',
            'max_group_size' => 'nullable|integer|min:1|required_if:is_group,1',
            'max_participants' => 'nullable|integer|min:1',
            'registration_open' => 'nullable|boolean',
            'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'carousel_image_1' => 'nullable|image|mimes:jpg,jpeg,png',
            'carousel_image_2' => 'nullable|image|mimes:jpg,jpeg,png',
            'carousel_image_3' => 'nullable|image|mimes:jpg,jpeg,png',
            'carousel_image_4' => 'nullable|image|mimes:jpg,jpeg,png',
            'carousel_image_5' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->only([
            'event_name',
            'type',
            'description',
            'venue',
            'event_date',
            'event_time',
            'is_group',
            'max_participants',
            'max_group_size',
        ]);

        // Set default values if optional fields are empty
        // $data['venue'] = $data['venue'] ?? 'Not Specified';
        // $data['event_date'] = $data['event_date'] ?? now()->format('Y-m-d');
        // $data['event_time'] = $data['event_time'] ?? now()->format('H:i');
        $data['max_participants'] = $data['max_participants'] ?? 1000;

        $data['registration_open'] = $request->input('registration_open', 0);

        // Handle thumbnail
        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('events', 'public');
        }

        // Handle carousel images
        for ($i = 1; $i <= 5; $i++) {
            $field = "carousel_image_$i";
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('events', 'public');
            }
        }

        Event::create($data);

        // Redirect to index page after storing
        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully!');
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'venue' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable',
            'is_group' => 'required|boolean',
            'max_group_size' => 'nullable|integer|min:1|required_if:is_group,1',
            'max_participants' => 'nullable|integer|min:1',
            'registration_open' => 'nullable|boolean',
            'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'carousel_image_1' => 'nullable|image|mimes:jpg,jpeg,png',
            'carousel_image_2' => 'nullable|image|mimes:jpg,jpeg,png',
            'carousel_image_3' => 'nullable|image|mimes:jpg,jpeg,png',
            'carousel_image_4' => 'nullable|image|mimes:jpg,jpeg,png',
            'carousel_image_5' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->only([
            'event_name',
            'type',
            'description',
            'venue',
            'event_date',
            'event_time',
            'is_group',
            'max_participants',
            'max_group_size',
        ]);

        // Set default values if optional fields are empty
        // $data['venue'] = $data['venue'] ?? 'Not Specified';
        // $data['event_date'] = $data['event_date'] ?? now()->format('Y-m-d');
        // $data['event_time'] = $data['event_time'] ?? now()->format('H:i');
        $data['max_participants'] = $data['max_participants'] ?? 1000;

        $data['registration_open'] = $request->input('registration_open', 0);

        // Handle thumbnail
        if ($request->hasFile('thumbnail_image')) {
            if ($event->thumbnail_image) {
                \Storage::disk('public')->delete($event->thumbnail_image);
            }
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('events', 'public');
        }

        // Handle carousel images
        for ($i = 1; $i <= 5; $i++) {
            $field = "carousel_image_$i";
            if ($request->hasFile($field)) {
                if ($event->$field) {
                    \Storage::disk('public')->delete($event->$field);
                }
                $data[$field] = $request->file($field)->store('events', 'public');
            }
        }

        $event->update($data);

        // Redirect to index page after updating
        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully!');
    }


    public function destroy(Event $event)
    {
        // Delete thumbnail and carousel images
        if ($event->thumbnail_image) {
            \Storage::disk('public')->delete($event->thumbnail_image);
        }

        for ($i = 1; $i <= 5; $i++) {
            $field = "carousel_image_$i";
            if ($event->$field) {
                \Storage::disk('public')->delete($event->$field);
            }
        }

        $event->delete();
        return redirect()->back()->with('success', 'Event deleted successfully!');
    }

    // Add this method in your EventController
    public function deleteAll()
    {
        $events = Event::all();

        foreach ($events as $event) {
            // Delete thumbnail
            if ($event->thumbnail_image) {
                \Storage::disk('public')->delete($event->thumbnail_image);
            }

            // Delete carousel images
            for ($i = 1; $i <= 5; $i++) {
                $field = "carousel_image_$i";
                if ($event->$field) {
                    \Storage::disk('public')->delete($event->$field);
                }
            }

            // Delete event
            $event->delete();
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'All events deleted successfully!');
    }
    public function edit(Event $event)
{
    return view('admin.events.edit', compact('event'));

}

}
