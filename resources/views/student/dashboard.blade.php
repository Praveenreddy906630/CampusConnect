@extends('layouts.student')

@section('title', 'Student Dashboard')

@section('content')
<div class="px-4 py-2">
    {{-- Hero Greeting --}}
    <div class="mb-6">
        <h2 class="text-sm text-text-light font-medium">Good Evening,</h2>
        <h1 class="text-2xl font-heading font-bold text-text-dark">{{ Auth::user()->name ?? 'Student' }} 👋</h1>
    </div>

    @php
        $myRegistrationsCount = auth()->user()->registrations()->count() ?? 0;
        $upcomingCount = $events->where('event_date', '>=', now())->count();
    @endphp

    {{-- Status Cards --}}
    <div class="grid grid-cols-2 gap-3 mb-6">
        <div class="bg-blue-50 rounded-2xl p-4 shadow-sm border border-blue-100 flex flex-col justify-center relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 text-6xl opacity-10">📅</div>
            <span class="text-2xl font-bold text-blue-700 mb-1">{{ $upcomingCount }}</span>
            <span class="text-xs font-semibold text-blue-800">Upcoming Events</span>
        </div>
        <div class="bg-green-50 rounded-2xl p-4 shadow-sm border border-green-100 flex flex-col justify-center relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 text-6xl opacity-10">🎟️</div>
            <span class="text-2xl font-bold text-green-700 mb-1">{{ $myRegistrationsCount }}</span>
            <span class="text-xs font-semibold text-green-800">My Registrations</span>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="mb-8">
        <h3 class="text-lg font-heading font-bold text-text-dark mb-4">Quick Actions</h3>
        <div class="grid grid-cols-3 gap-3">
            <a href="{{ route('events.index') }}" class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-2 hover:shadow-md transition-all active:scale-95">
                <div class="w-10 h-10 bg-primary/10 text-primary rounded-full flex items-center justify-center text-xl">📝</div>
                <span class="text-[11px] font-semibold text-text-dark text-center">Register</span>
            </a>
            <a href="{{ route('my.registrations') }}" class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-2 hover:shadow-md transition-all active:scale-95">
                <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xl">🎟️</div>
                <span class="text-[11px] font-semibold text-text-dark text-center">My Events</span>
            </a>
            <a href="{{ url('/soty/apply') }}" class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-2 hover:shadow-md transition-all active:scale-95">
                <div class="w-10 h-10 bg-yellow-50 text-yellow-600 rounded-full flex items-center justify-center text-xl">🏆</div>
                <span class="text-[11px] font-semibold text-text-dark text-center">SOTY</span>
            </a>
        </div>
    </div>

    {{-- Horizontal Events List --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-heading font-bold text-text-dark">Featured Events</h3>
            <a href="{{ route('events.index') }}" class="text-xs text-primary font-medium">View All</a>
        </div>
        <div class="flex overflow-x-auto pb-4 -mx-4 px-4 gap-4 snap-x hide-scrollbar">
            @foreach($events->take(4) as $event)
            <div class="min-w-[260px] bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl shadow-md p-5 text-white snap-center relative overflow-hidden group">
                @if($event->thumbnail_image)
                <img src="{{ asset('storage/' . $event->thumbnail_image) }}"
                    alt="{{ $event->event_name }}"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                    class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay transition-transform duration-500 group-hover:scale-110 z-0">
                <div class="fallback-icon hidden absolute top-0 right-0 opacity-20 text-7xl -mt-2 -mr-2 z-0">🎪</div>
                @else
                <div class="absolute top-0 right-0 opacity-20 text-7xl -mt-2 -mr-2 z-0">🎪</div>
                @endif
                
                <div class="relative z-10 flex flex-col h-full">
                    <div class="mb-6">
                        <span class="inline-block px-2 py-1 bg-white/20 backdrop-blur-sm rounded-md text-[10px] font-semibold uppercase tracking-wider mb-2 shadow-sm">
                            {{ $event->type ?? 'General' }}
                        </span>
                        <h4 class="text-lg font-heading font-bold leading-tight drop-shadow-md line-clamp-2" title="{{ $event->event_name }}">{{ $event->event_name }}</h4>
                    </div>
                    <div class="flex justify-between items-end mt-auto pt-2">
                        <div>
                            <p class="text-[10px] text-gray-300 uppercase tracking-wider font-semibold">Date</p>
                            <p class="text-sm font-semibold drop-shadow-sm">{{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('M d') : 'TBA' }}</p>
                        </div>
                        <a href="{{ url('/events/' . $event->event_id . '/register') }}" class="bg-white text-gray-900 px-4 py-2 rounded-full text-xs font-bold hover:bg-gray-100 transition-colors active:scale-95 shadow-lg">
                            Join Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Categories Horizontal Scroll --}}
    <div class="mb-6">
        <h3 class="text-lg font-heading font-bold text-text-dark mb-4">Explore Categories</h3>
        <div class="flex overflow-x-auto pb-2 -mx-4 px-4 gap-3 snap-x hide-scrollbar">
            <a href="{{ url('/events?type=outdoor') }}" class="min-w-[120px] bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col items-center gap-2 snap-center active:scale-95 transition-transform">
                <span class="text-3xl">🏟️</span>
                <span class="text-xs font-semibold text-text-dark">Outdoor</span>
            </a>
            <a href="{{ url('/events?type=indoor') }}" class="min-w-[120px] bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col items-center gap-2 snap-center active:scale-95 transition-transform">
                <span class="text-3xl">🏛️</span>
                <span class="text-xs font-semibold text-text-dark">Indoor</span>
            </a>
            <a href="{{ url('/events?type=cultural') }}" class="min-w-[120px] bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col items-center gap-2 snap-center active:scale-95 transition-transform">
                <span class="text-3xl">🎭</span>
                <span class="text-xs font-semibold text-text-dark">Cultural</span>
            </a>
        </div>
    </div>

</div>
@endsection
