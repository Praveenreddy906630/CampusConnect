@extends('layouts.coordinator')

@section('content')
<div class="p-6 font-body space-y-8">
    <h1 class="text-3xl font-heading font-bold text-text-dark">📊 Coordinator Dashboard</h1>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow flex items-center gap-4">
            <div class="p-3 bg-blue-100 rounded-full text-blue-600 text-2xl">🎭</div>
            <div>
                <h2 class="text-sm font-semibold text-text-light">My Events</h2>
                <p class="text-3xl font-bold text-text-dark">{{ $coordinator->events->count() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow flex items-center gap-4">
            <div class="p-3 bg-green-100 rounded-full text-green-600 text-2xl">📝</div>
            <div>
                <h2 class="text-sm font-semibold text-text-light">Total Registrations</h2>
                <p class="text-3xl font-bold text-text-dark">{{ $totalRegistrations }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow flex items-center gap-4">
            <div class="p-3 bg-purple-100 rounded-full text-purple-600 text-2xl">👥</div>
            <div>
                <h2 class="text-sm font-semibold text-text-light">Unique Participants</h2>
                <p class="text-3xl font-bold text-text-dark">{{ $totalUniqueParticipants }}</p>
            </div>
        </div>
    </div>

    {{-- Recent Registrations --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-heading font-semibold mb-4 text-text-dark">🆕 Recent Registrations (All My Events)</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm font-body border-collapse">
                <thead class="bg-gray-100 rounded-t-lg">
                    <tr>
                        <th class="px-4 py-2 border">Enrolment</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Event</th>
                        <th class="px-4 py-2 border">Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRegistrations as $reg)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-2 border">{{ $reg->participant_enrolment }}</td>
                        <td class="px-4 py-2 border">{{ $reg->participant->full_name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $reg->event->event_name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $reg->created_at->format('d M, Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-400">No recent registrations.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Event-wise Stats --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-heading font-semibold mb-4 text-text-dark">📊 Event Registration Stats</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm font-body border-collapse">
                <thead class="bg-gray-100 rounded-t-lg">
                    <tr>
                        <th class="px-4 py-2 border">Event</th>
                        <th class="px-4 py-2 border">Registrations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eventStats as $stat)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-2 border">{{ $stat['event_name'] }}</td>
                        <td class="px-4 py-2 border font-semibold">{{ $stat['registrations_count'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-4 py-4 text-center text-gray-400">No event stats available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .font-heading { font-family: 'Poppins', sans-serif; }
    .font-body { font-family: 'Roboto', sans-serif; }
</style>
@endsection
