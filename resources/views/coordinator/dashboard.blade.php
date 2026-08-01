@extends('layouts.coordinator')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-6 text-text-dark">Coordinator Dashboard</h1>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($coordinator->events as $event)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all overflow-hidden">
                @if($event->thumbnail_image)
                    <img src="{{ asset('storage/' . $event->thumbnail_image) }}"
                         alt="{{ $event->event_name }}" 
                         class="w-full h-48 object-cover">
                @else
                    <img src="https://source.unsplash.com/400x250/?{{ $event->type }}"
                         alt="{{ $event->event_name }}" 
                         class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <h4 class="text-xl font-heading font-semibold mb-2 text-text-dark">{{ $event->event_name }}</h4>
                    <p class="text-text-light mb-4">{{ $event->description }}</p>
                    <!-- <div class="flex items-center text-sm text-text-light mb-2">
                        <span>📍 {{ $event->venue ?? 'Venue TBD' }}</span>
                        <span class="ml-auto">
                            ⏰ {{ \Carbon\Carbon::parse($event->event_date)->format('d M') }},
                            {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}
                        </span>
                    </div> -->
                    @php
                        $registrationsCount = $event->registrations->count();
                    @endphp
                    <p class="text-sm mt-2">
                        <span class="font-semibold text-text-dark">{{ $registrationsCount }}</span> /
                        <span class="text-text-light">{{ $event->max_participants }}</span> registered
                    </p>
                    <a href="{{ route('coordinator.participants', $event->event_id) }}"
                       class="block text-center bg-primary text-white py-2 rounded-lg hover:opacity-90 transition mt-4">
                        View Participants
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection