@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-3xl font-heading font-bold mb-8 text-text-dark">📊 Dashboard</h1>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full mr-4">
                    <span class="text-2xl text-blue-600">👥</span>
                </div>
                <div>
                    <h2 class="text-lg font-heading font-semibold text-text-light">Total Users</h2>
                    <p class="text-3xl font-heading font-bold text-text-dark mt-1">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full mr-4">
                    <span class="text-2xl text-green-600">🎭</span>
                </div>
                <div>
                    <h2 class="text-lg font-heading font-semibold text-text-light">Events</h2>
                    <p class="text-3xl font-heading font-bold text-text-dark mt-1">{{ $totalEvents }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-primary hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full mr-4">
                    <span class="text-2xl text-primary">📝</span>
                </div>
                <div>
                    <h2 class="text-lg font-heading font-semibold text-text-light">Registrations</h2>
                    <p class="text-3xl font-heading font-bold text-text-dark mt-1">{{ $totalRegistrations }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full mr-4">
                    <span class="text-2xl text-yellow-600">🏆</span>
                </div>
                <div>
                    <h2 class="text-lg font-heading font-semibold text-text-light">SOTY Applications</h2>
                    <p class="text-3xl font-heading font-bold text-text-dark mt-1">{{ $totalSoty }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        {{-- Recent Registrations --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-heading font-semibold text-text-dark">🆕 Recent Registrations</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm font-body">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-3 text-text-dark font-heading">Enrolment</th>
                            <th class="px-4 py-3 text-text-dark font-heading">Name</th>
                            <th class="px-4 py-3 text-text-dark font-heading">Event</th>
                            <th class="px-4 py-3 text-text-dark font-heading">Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRegistrations as $reg)
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-text-dark font-medium">{{ $reg->participant_enrolment }}</td>
                            <td class="px-4 py-3 text-text-dark">{{ $reg->participant->full_name ?? '-' }}</td>
                            <td class="px-4 py-3 text-text-dark">{{ $reg->event->event_name ?? '-' }}</td>
                            <td class="px-4 py-3 text-text-light text-sm">{{ $reg->created_at->format('M d, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-text-light">No recent registrations.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent SOTY Applications --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-heading font-semibold text-text-dark">🏆 Recent SOTY Applications</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm font-body">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-3 text-text-dark font-heading">Enrolment</th>
                            <th class="px-4 py-3 text-text-dark font-heading">Name</th>
                            <th class="px-4 py-3 text-text-dark font-heading">CGPA</th>
                            <th class="px-4 py-3 text-text-dark font-heading">Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSoty as $soty)
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-text-dark font-medium">{{ $soty->enrolment_no }}</td>
                            <td class="px-4 py-3 text-text-dark">{{ $soty->student->full_name ?? '-' }}</td>
                            <td class="px-4 py-3 text-text-dark">
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                    {{ number_format(($soty->even_cgpa + $soty->odd_cgpa) / 2, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-text-light text-sm">{{ $soty->created_at->format('M d, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-text-light">No recent applications.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @php
    // Departments list (from results). flatten(1) ensures one-level flattening.
    $departments = $eventStats
        ->flatMap(fn($group) => collect($group)->pluck('school_code'))
        ->filter()   // remove empty/null if any
        ->unique()
        ->sort()
        ->values();

    // Fallback: if no departments found in stats (no regs yet), pull distinct school_code
    if ($departments->isEmpty()) {
        $departments = \DB::table('students')
            ->distinct()
            ->whereNotNull('school_code')
            ->pluck('school_code')
            ->sort()
            ->values();
    }
@endphp

<table class="min-w-full text-sm text-left border-collapse">
    <thead>
        <tr class="bg-gray-100 border-b">
            <th rowspan="2" class="px-4 py-3 font-semibold border text-center">Event</th>
            @foreach ($departments as $dept)
                <th colspan="2" class="px-4 py-3 font-semibold border text-center">{{ $dept }}</th>
            @endforeach
            <th rowspan="2" class="px-4 py-3 font-semibold border text-center">Total</th>
        </tr>
        <tr class="bg-gray-50 border-b">
            @foreach ($departments as $dept)
                <th class="px-4 py-2 border text-center">Boys</th>
                <th class="px-4 py-2 border text-center">Girls</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($events as $event)
            @php
                // get rows for this event (collection keyed by event_id)
                $rows = $eventStats->get($event->event_id, collect());
                $eventTotals = ['boys' => 0, 'girls' => 0];
            @endphp

            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3 font-semibold text-text-dark">{{ $event->event_name }}</td>

                @foreach ($departments as $dept)
                    @php
                        // rows is a collection of stdClass rows for this event
                        $record = $rows->firstWhere('school_code', $dept);
                        $b = $record->boys ?? 0;
                        $g = $record->girls ?? 0;
                        $eventTotals['boys'] += (int) $b;
                        $eventTotals['girls'] += (int) $g;
                    @endphp
                    <td class="px-4 py-3 text-center">{{ $b }}</td>
                    <td class="px-4 py-3 text-center">{{ $g }}</td>
                @endforeach

                <td class="px-4 py-3 text-center font-semibold text-primary">
                    {{ $eventTotals['boys'] + $eventTotals['girls'] }}
                </td>
            </tr>
        @endforeach

        {{-- Total row --}}
        <tr class="bg-gray-100 font-semibold border-t-2">
            <td class="px-4 py-3 text-right">Total</td>

            @foreach ($departments as $dept)
                @php
                    // flatten one level to get every row object across events
                    $deptRows = $eventStats->flatten(1)->where('school_code', $dept);
                    $boysSum = $deptRows->sum('boys');
                    $girlsSum = $deptRows->sum('girls');
                @endphp
                <td class="px-4 py-3 text-center">{{ $boysSum }}</td>
                <td class="px-4 py-3 text-center">{{ $girlsSum }}</td>
            @endforeach

            <td class="px-4 py-3 text-center text-primary">
                {{ $eventStats->flatten(1)->sum('total') }}
            </td>
        </tr>
    </tbody>
</table>


    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-heading font-semibold mb-6 text-text-dark">⚡ Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.events.index') }}" class="bg-blue-100 hover:bg-blue-200 text-blue-800 p-4 rounded-lg text-center transition-colors">
                <div class="text-2xl mb-2">🎭</div>
                <div class="font-heading font-semibold">Manage Events</div>
            </a>
            <a href="{{ route('admin.registrations.index') }}" class="bg-green-100 hover:bg-green-200 text-green-800 p-4 rounded-lg text-center transition-colors">
                <div class="text-2xl mb-2">📝</div>
                <div class="font-heading font-semibold">View Registrations</div>
            </a>
            <a href="{{ route('admin.soty.index') }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 p-4 rounded-lg text-center transition-colors">
                <div class="text-2xl mb-2">🏆</div>
                <div class="font-heading font-semibold">SOTY Applications</div>
            </a>
        </div>
    </div>
</div>
@endsection