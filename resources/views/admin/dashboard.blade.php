@extends('layouts.admin')

@section('content')
<div class="md:p-6 font-body">
    {{-- Mobile Greeting Header --}}
    <div class="mb-6 md:mb-8 pt-2">
        <h2 class="text-sm text-text-light font-medium">Good Evening,</h2>
        <h1 class="text-2xl font-heading font-bold text-text-dark">{{ Auth::user()->name ?? 'Admin' }} 👋</h1>
    </div>

    {{-- Upcoming Events --}}
    <div class="mb-8">
        <h3 class="text-lg font-heading font-bold text-text-dark mb-4">Upcoming Events</h3>
        <div class="flex overflow-x-auto pb-4 gap-4 snap-x hide-scrollbar">
            @forelse($events->take(3) as $event)
            <div class="min-w-[280px] md:min-w-[320px] bg-gradient-to-br from-primary to-red-700 rounded-3xl shadow-lg p-5 text-white snap-center relative overflow-hidden">
                <div class="absolute top-0 right-0 opacity-10 text-8xl -mt-4 -mr-4">🎭</div>
                <h4 class="text-xl font-heading font-bold mb-1">{{ $event->event_name }}</h4>
                <p class="text-sm text-red-100 mb-4">{{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('M d, Y') : 'TBA' }}</p>
                <a href="{{ route('admin.events.index') }}" class="inline-block bg-white text-primary px-4 py-2 rounded-full text-sm font-semibold hover:bg-gray-100 transition-colors shadow-sm">
                    View Details →
                </a>
            </div>
            @empty
            <div class="w-full bg-white rounded-3xl shadow-sm border border-gray-100 p-6 text-center">
                <p class="text-text-light text-sm">No upcoming events.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="mb-8">
        <h3 class="text-lg font-heading font-bold text-text-dark mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.events.index') }}" class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:shadow-md transition-all active:scale-95">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl">➕</div>
                <span class="text-xs font-semibold text-text-dark text-center">Create Event</span>
            </a>
            <a href="{{ route('admin.registrations.index') }}" class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:shadow-md transition-all active:scale-95">
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-2xl">📝</div>
                <span class="text-xs font-semibold text-text-dark text-center">Registrations</span>
            </a>
            <a href="{{ route('admin.soty.index') }}" class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:shadow-md transition-all active:scale-95">
                <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-full flex items-center justify-center text-2xl">🏆</div>
                <span class="text-xs font-semibold text-text-dark text-center">SOTY Apps</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:shadow-md transition-all active:scale-95">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-2xl">👥</div>
                <span class="text-xs font-semibold text-text-dark text-center">Users</span>
            </a>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-heading font-bold text-text-dark">Recent Activity</h3>
            <a href="{{ route('admin.registrations.index') }}" class="text-sm text-primary font-medium hover:underline">View All</a>
        </div>
        
        <div class="flex flex-col gap-3">
            @forelse($recentRegistrations->take(4) as $reg)
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-xl shrink-0">
                    👤
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-semibold text-text-dark truncate">{{ $reg->participant->full_name ?? 'Unknown Student' }}</h4>
                    <p class="text-xs text-text-light truncate">Registered for {{ $reg->event->event_name ?? 'an event' }}</p>
                </div>
                <div class="text-right shrink-0">
                    <span class="text-[10px] text-text-light block">{{ $reg->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                <p class="text-sm text-text-light">No recent activity.</p>
            </div>
            @endforelse

            @foreach($recentSoty->take(2) as $soty)
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-yellow-50 rounded-full flex items-center justify-center text-xl shrink-0">
                    🏆
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-semibold text-text-dark truncate">{{ $soty->student->full_name ?? 'Unknown Student' }}</h4>
                    <p class="text-xs text-text-light truncate">Submitted SOTY Application</p>
                </div>
                <div class="text-right shrink-0">
                    <span class="text-[10px] text-text-light block">{{ $soty->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<style>
/* Hide scrollbar for horizontal scroll areas */
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
@endsection