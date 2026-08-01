@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    {{-- Event-wise Registration Stats --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-10">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-heading font-semibold text-text-dark">📊 Event Registration Statistics</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm font-body border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 border text-text-dark font-heading">Event</th>
                        <th class="px-4 py-3 border text-text-dark font-heading">Program</th>
                        <th class="px-4 py-3 border text-text-dark font-heading">Boys</th>
                        <th class="px-4 py-3 border text-text-dark font-heading">Girls</th>
                        <th class="px-4 py-3 border text-text-dark font-heading">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        @php
                            $rows = $eventStats->get($event->event_id, collect());
                            $eventTotalM = $rows->sum('males');
                            $eventTotalF = $rows->sum('females');
                            $eventTotal  = $rows->sum('total');
                        @endphp

                        @if($rows->isEmpty())
                            <tr class="border-b">
                                <td class="px-4 py-3 text-text-dark font-semibold">{{ $event->event_name }}</td>
                                <td colspan="4" class="px-4 py-3 text-text-light text-center">
                                    No registrations yet
                                </td>
                            </tr>
                        @else
                            {{-- First row will show event name --}}
                            @foreach($rows as $index => $r)
                                <tr class="border-b hover:bg-gray-50 transition-colors">
                                    @if($index === 0)
                                        <td class="px-4 py-3 text-text-dark font-semibold align-top" rowspan="{{ $rows->count() }}">
                                            {{ $event->event_name }}
                                        </td>
                                    @endif
                                    <td class="px-4 py-3 text-text-dark">{{ $r->program_code ?? 'Unknown' }}</td>
                                    <td class="px-4 py-3 text-text-dark font-medium">{{ $r->males }}</td>
                                    <td class="px-4 py-3 text-text-dark font-medium">{{ $r->females }}</td>
                                    <td class="px-4 py-3 text-text-dark font-semibold">{{ $r->total }}</td>
                                </tr>
                            @endforeach

                            {{-- Per-event total row --}}
                            <tr class="bg-gray-50 font-semibold border-b-2">
                                <td colspan="2" class="px-4 py-3 text-text-dark text-right">Event Total</td>
                                <td class="px-4 py-3 text-primary">{{ $eventTotalM }}</td>
                                <td class="px-4 py-3 text-primary">{{ $eventTotalF }}</td>
                                <td class="px-4 py-3 text-primary">{{ $eventTotal }}</td>
                            </tr>
                            <tr><td colspan="5" class="py-2"></td></tr> {{-- Spacer --}}
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-text-light">
                                No events found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection