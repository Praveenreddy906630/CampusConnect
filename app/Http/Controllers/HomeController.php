<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        // Get events grouped by type
        $events = Event::with(['registrations'])
            ->orderBy('event_date', 'asc')
            ->orderBy('event_name', 'asc')
            ->get();

        // Group events by type
        $eventsByType = $events->groupBy('type');

        // Count events by type
        $eventCounts = $eventsByType->map(function ($events) {
            return $events->count();
        });

        // Get settings
        $settings = Setting::first();

        return view('index', compact('eventsByType', 'eventCounts', 'settings'));
    }
}