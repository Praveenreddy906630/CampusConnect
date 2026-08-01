<?php

namespace App\Http\Controllers;

use App\Models\Event;

class PublicEventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('event_date', 'asc')->get();
        return view('events', compact('events'));
    }
}
