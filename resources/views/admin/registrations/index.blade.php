@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-6 text-text-dark">Registrations</h1>

    @foreach(['indoor', 'outdoor', 'cultural'] as $category)
        <h2 class="text-xl font-heading font-semibold mt-8 mb-4 capitalize text-text-dark border-b pb-2">
            {{ $category }} Events
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events[$category] ?? [] as $event)
                <a href="{{ route('admin.registrations.show', $event->event_id) }}" 
                   class="group p-5 bg-white rounded-xl shadow hover:shadow-xl transition-all duration-300 flex flex-col border border-gray-200">

                    {{-- Thumbnail --}}
                    @if($event->thumbnail_image)
                        <img src="{{ asset('storage/' . $event->thumbnail_image) }}" 
                             alt="{{ $event->event_name }}" 
                             class="w-full h-36 object-cover rounded-md mb-4 group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-36 bg-gray-100 rounded-md mb-4 flex items-center justify-center">
                            <span class="text-text-light italic">No image</span>
                        </div>
                    @endif

                    {{-- Event Info --}}
                    <h3 class="font-heading font-semibold text-lg text-text-dark mb-1">{{ $event->event_name }}</h3>
                    <p class="text-sm text-text-light">{{ $event->event_date }} at {{ $event->event_time }}</p>

                    {{-- Registrations Info --}}
                    <div class="mt-3 flex flex-col gap-2">
                        <p class="text-sm">
                            <span class="font-semibold text-primary">{{ $event->registrations_count }}</span> / 
                            <span class="text-text-light">{{ $event->max_participants }}</span> registered
                        </p>
                        
                        <!-- {{-- Progress bar --}}
                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-primary transition-all duration-500" 
                                 style="width: {{ min(100, ($event->registrations_count / max(1, $event->max_participants)) * 100) }}%">
                            </div>
                        </div> -->
                    </div>
                    
                    {{-- View Details Button --}}
                    <div class="mt-4 text-right">
                        <span class="inline-block text-xs font-medium bg-primary text-white px-3 py-1 rounded-full transition group-hover:bg-primary/90">
                            View Details →
                        </span>
                    </div>
                </a>
            @empty
                <p class="text-text-light col-span-full py-6 text-center">No events found in this category.</p>
            @endforelse
        </div>
    @endforeach
</div>
@endsection
