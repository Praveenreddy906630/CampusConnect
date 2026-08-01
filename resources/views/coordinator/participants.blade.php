@extends('layouts.coordinator')

@section('content')
<div class="p-6 space-y-12 font-body">

    <div class="mb-4 flex justify-end">
        <a href="{{ route('coordinator.participants.export', $event->event_id) }}"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md shadow-sm transition">
            📥 Export Participants CSV
        </a>
    </div>

    <!-- Stats Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md mb-8">
        <h2 class="text-lg font-heading font-semibold px-4 py-3 border-b text-text-dark">
            📊 Stats for {{ $event->event_name }}
        </h2>
        <table class="min-w-full text-left text-sm border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border text-text-dark font-heading">Program Code</th>
                    <th class="px-4 py-2 border text-text-dark font-heading">Boys</th>
                    <th class="px-4 py-2 border text-text-dark font-heading">Girls</th>
                    <th class="px-4 py-2 border text-text-dark font-heading">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programStats as $stat)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-text-dark">{{ $stat->program_code ?? 'Unknown' }}</td>
                    <td class="px-4 py-2 border text-text-dark font-semibold">{{ $stat->males }}</td>
                    <td class="px-4 py-2 border text-text-dark font-semibold">{{ $stat->females }}</td>
                    <td class="px-4 py-2 border text-text-dark font-semibold">{{ $stat->total }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-text-light">
                        No registrations yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($programStats->isNotEmpty())
            <tfoot>
                <tr class="bg-gray-50 font-semibold">
                    <td class="px-4 py-2 border text-text-dark text-right">Event Total</td>
                    <td class="px-4 py-2 border text-primary">{{ $programStats->sum('males') }}</td>
                    <td class="px-4 py-2 border text-primary">{{ $programStats->sum('females') }}</td>
                    <td class="px-4 py-2 border text-primary">{{ $programStats->sum('total') }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('coordinator.participants', $event->event_id) }}" class="mb-4 flex flex-wrap gap-4 items-end bg-white p-4 rounded-lg shadow-md">
        <div>
            <label class="block text-sm font-heading font-medium text-text-dark mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                class="border border-gray-300 rounded-md p-2 w-48 focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-heading font-medium text-text-dark mb-1">Gender</label>
            <select name="gender" class="border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-primary focus:outline-none">
                <option value="">All</option>
                <option value="male" {{ request('gender')=='male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ request('gender')=='female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-heading font-medium text-text-dark mb-1">Program Code</label>
            <select name="program_code" class="border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-primary focus:outline-none">
                <option value="">All</option>
                @foreach($programCodes as $code)
                <option value="{{ $code }}" {{ request('program_code')==$code ? 'selected' : '' }}>{{ $code }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:opacity-90 transition">Apply</button>
        </div>
    </form>

    <!-- Participants Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100 text-sm uppercase">
                <tr>
                    <th class="px-4 py-3 border text-text-dark font-heading">Enrolment</th>
                    <th class="px-4 py-3 border text-text-dark font-heading">Name</th>
                    <th class="px-4 py-3 border text-text-dark font-heading">Role</th>
                    <th class="px-4 py-3 border text-text-dark font-heading text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">

                @if($event->is_group)
                @forelse($groupedRegistrations as $groupIndex => $group)
                <!-- Group Header -->
                <tr class="bg-blue-100 font-heading font-bold text-center">
                    <td colspan="4" class="px-4 py-2 text-text-dark">Group {{ $loop->iteration }}</td>
                </tr>

                <!-- Leader Row -->
                @php $leader = $group->first()->leader; @endphp
                <tr class="bg-blue-50 font-semibold">
                    <td class="px-4 py-2 border text-text-dark">{{ $group->first()->leader_enrolment }}</td>
                    <td class="px-4 py-2 border text-text-dark">{{ $leader->full_name ?? '-' }}</td>
                    <td class="px-4 py-2 border text-text-dark">Leader</td>
                    <td class="px-4 py-2 border text-center">
                        <form action="{{ route('coordinator.participant.delete', ['event' => $event->event_id, 'participant' => $group->first()->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this participant?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md shadow-sm transition">🗑 Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Participants -->
                @foreach($group as $reg)
                @if($reg->participant_enrolment !== $group->first()->leader_enrolment)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-text-dark">{{ $reg->participant_enrolment }}</td>
                    <td class="px-4 py-2 border text-text-dark">{{ $reg->participant->full_name ?? '-' }}</td>
                    <td class="px-4 py-2 border text-text-dark">Participant</td>
                    <td class="px-4 py-2 border text-center">
                        <form action="{{ route('coordinator.participant.delete', ['event' => $event->event_id, 'participant' => $reg->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this participant?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md shadow-sm transition">🗑 Delete</button>
                        </form>
                    </td>
                </tr>
                @endif
                @endforeach
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-text-light">No registrations yet.</td>
                </tr>
                @endforelse
                @else
                @forelse($groupedRegistrations as $reg)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-text-dark">{{ $reg->participant_enrolment }}</td>
                    <td class="px-4 py-2 border text-text-dark">{{ $reg->participant->full_name ?? '-' }}</td>
                    <td class="px-4 py-2 border text-text-dark">Solo</td>
                    <td class="px-4 py-2 border text-center">
                        <form action="{{ route('coordinator.participant.delete', ['event' => $event->event_id, 'participant' => $reg->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this participant?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md shadow-sm transition">🗑 Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-text-light">No registrations yet.</td>
                </tr>
                @endforelse
                @endif

            </tbody>
        </table>
    </div>

    <!-- Mail Form -->
    <div class="mt-8 max-w-lg bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-heading font-semibold mb-4 text-text-dark">Send Mail to {{ $event->event_name }} Participants</h2>
        <form action="{{ route('coordinator.mail', ['event' => $event->event_id]) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-heading font-medium mb-1 text-text-dark">Subject</label>
                <input type="text" name="subject"
                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-primary focus:outline-none" required>
            </div>
            <div class="mb-4">
                <label class="block font-heading font-medium mb-1 text-text-dark">Message</label>
                <textarea name="message"
                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-primary focus:outline-none"
                    rows="4" required></textarea>
            </div>
            <button type="submit" class="bg-primary hover:opacity-90 text-white px-4 py-2 rounded-md shadow-sm transition">
                ✉️ Send Mail
            </button>
        </form>
    </div>
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Program Distribution -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-heading font-semibold mb-4 text-text-dark">📊 Program Distribution</h3>
            <canvas id="programChart" height="200"></canvas>
        </div>

        <!-- Gender Distribution -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-heading font-semibold mb-4 text-text-dark">⚧ Gender Distribution</h3>
            <canvas id="genderChart" height="200"></canvas>
        </div>
    </div>


    <!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Program Distribution Bar Chart
        const programCtx = document.getElementById('programChart').getContext('2d');
        new Chart(programCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($programStats->pluck('program_code')) !!},
                datasets: [
                    {
                        label: 'Boys',
                        data: {!! json_encode($programStats->pluck('males')) !!},
                        backgroundColor: '#3B82F6',
                    },
                    {
                        label: 'Girls',
                        data: {!! json_encode($programStats->pluck('females')) !!},
                        backgroundColor: '#EF4444',
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Program-wise Gender Distribution'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // Gender Distribution Pie Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: ['Male', 'Female'],
                datasets: [
                    {
                        data: {!! json_encode([$genderStats['male'] ?? 0, $genderStats['female'] ?? 0]) !!},
                        backgroundColor: ['#3B82F6', '#EF4444'],
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Overall Gender Distribution'
                    }
                }
            }
        });
    });
</script>


</div>
@endsection