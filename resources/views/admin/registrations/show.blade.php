@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-6 text-text-dark">{{ $event->event_name }} Registrations</h1>

    <!-- 🔍 Search & Filters -->
    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Search by name or enrolment"
            class="border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">

        <select name="gender" class="border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">
            <option value="">All Genders</option>
            <option value="male" {{ request('gender')=='male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ request('gender')=='female' ? 'selected' : '' }}>Female</option>
        </select>

        <select name="program_code" class="border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">
            <option value="">All Programs</option>
            @foreach($programCodes as $code)
            <option value="{{ $code }}" {{ request('program_code')==$code ? 'selected' : '' }}>
                {{ $code }}
            </option>
            @endforeach
        </select>

        <input type="date" name="from_date" value="{{ request('from_date') }}"
            class="border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">
        <input type="date" name="to_date" value="{{ request('to_date') }}"
            class="border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">

        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:opacity-90 transition">Apply</button>
        <a href="{{ route('admin.registrations.show', $event->event_id) }}"
            class="px-4 py-2 bg-gray-300 text-text-dark rounded-md hover:bg-gray-400 transition">Reset</a>
    </form>

    <!-- 📊 Charts Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Gender Distribution Chart Card -->
        <div class="bg-white shadow rounded-lg p-4 flex flex-col">
            <h3 class="font-heading font-semibold mb-3 text-text-dark">Gender Distribution</h3>
            <div class="w-full h-64">
                <canvas id="genderChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Program Distribution Chart Card -->
        <div class="bg-white shadow rounded-lg p-4 flex flex-col">
            <h3 class="font-heading font-semibold mb-3 text-text-dark">Program Distribution</h3>
            <div class="w-full h-64">
                <canvas id="programChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Program Stats Table -->
    <div class="bg-white shadow rounded-lg p-4 mb-6 overflow-x-auto">
        <h3 class="font-heading font-semibold mb-3 text-text-dark">Registrations by Program</h3>
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-3 py-2 border text-text-dark font-heading">Program Code</th>
                    <th class="px-3 py-2 border text-text-dark font-heading">Males</th>
                    <th class="px-3 py-2 border text-text-dark font-heading">Females</th>
                    <th class="px-3 py-2 border text-text-dark font-heading">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programStats as $stat)
                <tr>
                    <td class="px-3 py-2 border text-text-dark">{{ $stat->program_code }}</td>
                    <td class="px-3 py-2 border text-text-dark">{{ $stat->males }}</td>
                    <td class="px-3 py-2 border text-text-dark">{{ $stat->females }}</td>
                    <td class="px-3 py-2 border text-text-dark font-semibold">{{ $stat->total }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-3 py-2 text-center text-text-light">No stats yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Delete All Registrations -->
    <form action="{{ route('admin.registrations.deleteAll', $event->event_id) }}" method="POST" id="deleteAllRegistrationsForm">
        @csrf
        @method('DELETE')
        <button type="button" onclick="confirmDeleteAllRegistrations()"
            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition mb-6">
            Delete All Registrations
        </button>
    </form>

    <!-- Registrations Table -->
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-3 border text-left text-text-dark font-heading">Enrolment</th>
                    <th class="px-4 py-3 border text-left text-text-dark font-heading">Name</th>
                    <th class="px-4 py-3 border text-left text-text-dark font-heading">Role</th>
                    <th class="px-4 py-3 border text-left text-text-dark font-heading">Registered At</th>
                    <th class="px-4 py-3 border text-left text-text-dark font-heading">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groups as $leaderEnrol => $regs)
                @if($event->is_group)
                <!-- Group Header -->
                <tr class="bg-blue-200 font-bold">
                    <td colspan="5" class="px-4 py-2 text-center">
                        Group {{ $loop->iteration }}
                    </td>
                </tr>

                <!-- Leader -->
                @php $leader = $regs->first()->leader; @endphp
                <tr class="bg-blue-100 font-semibold">
                    <td class="px-4 py-2 border">{{ $leaderEnrol }}</td>
                    <td class="px-4 py-2 border">{{ $leader->full_name ?? '-' }}</td>
                    <td class="px-4 py-2 border">Leader</td>
                    <td class="px-4 py-2 border">{{ $regs->first()->created_at->format('d M, Y H:i') }}</td>
                    <td class="px-4 py-2 border">
                        <button type="button" 
                            onclick="confirmDeleteRegistration({{ $regs->first()->id }}, '{{ addslashes($leader->full_name ?? 'Leader') }}', 'leader')"
                            class="text-red-600 hover:underline font-medium">
                            Delete
                        </button>
                    </td>
                </tr>

                <!-- Participants -->
                @foreach($regs as $reg)
                @if($reg->participant_enrolment !== $leaderEnrol)
                <tr>
                    <td class="px-4 py-2 border">{{ $reg->participant_enrolment }}</td>
                    <td class="px-4 py-2 border">{{ $reg->participant->full_name ?? '-' }}</td>
                    <td class="px-4 py-2 border">Participant</td>
                    <td class="px-4 py-2 border">{{ $reg->created_at->format('d M, Y H:i') }}</td>
                    <td class="px-4 py-2 border">
                        <button type="button" 
                            onclick="confirmDeleteRegistration({{ $reg->id }}, '{{ addslashes($reg->participant->full_name ?? 'Participant') }}', 'participant')"
                            class="text-red-600 hover:underline font-medium">
                            Delete
                        </button>
                    </td>
                </tr>
                @endif
                @endforeach

                @else
                <!-- Solo Event (no leader/participants distinction) -->
                @foreach($regs as $reg)
                <tr>
                    <td class="px-4 py-2 border">{{ $reg->participant_enrolment }}</td>
                    <td class="px-4 py-2 border">{{ $reg->participant->full_name ?? '-' }}</td>
                    <td class="px-4 py-2 border">Solo</td>
                    <td class="px-4 py-2 border">{{ $reg->created_at->format('d M, Y H:i') }}</td>
                    <td class="px-4 py-2 border">
                        <button type="button" 
                            onclick="confirmDeleteRegistration({{ $reg->id }}, '{{ addslashes($reg->participant->full_name ?? 'Participant') }}', 'solo')"
                            class="text-red-600 hover:underline font-medium">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
                @endif
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-text-light">No registrations yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gender Distribution Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: {!! json_encode([
                        $genderStats['male'] ?? 0,
                        $genderStats['female'] ?? 0
                    ]) !!},
                    backgroundColor: ['#3B82F6', '#EC4899'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Program Distribution Chart
        const programCtx = document.getElementById('programChart').getContext('2d');
        new Chart(programCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($programStats->pluck('program_code')) !!},
                datasets: [{
                    label: 'Total Registrations',
                    data: {!! json_encode($programStats->pluck('total')) !!},
                    backgroundColor: '#c5010f',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });

    // Function to confirm delete all registrations
    function confirmDeleteAllRegistrations() {
        const totalRegistrations = {{ $groups->count() }};
        
        if (totalRegistrations === 0) {
            Swal.fire({
                title: 'No Registrations',
                text: 'There are no registrations to delete for this event.',
                icon: 'info',
                confirmButtonColor: '#3085d6',
            });
            return;
        }

        Swal.fire({
            title: 'Delete All Registrations?',
            html: `
                <div class="text-left">
                    <p class="text-red-600 font-semibold mb-3">This will delete ALL registrations for:</p>
                    <p class="font-bold text-lg mb-4">"{{ $event->event_name }}"</p>
                    <ul class="list-disc list-inside text-sm text-gray-700 mb-4">
                        <li>Total registrations affected: <strong>${totalRegistrations}</strong></li>
                        <li>This action cannot be undone</li>
                        <li>All registration data will be permanently deleted</li>
                    </ul>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete all!',
            cancelButtonText: 'Cancel',
            input: 'text',
            inputLabel: 'To confirm, type "DELETE ALL" below:',
            inputPlaceholder: 'Type DELETE ALL here...',
            inputValidator: (value) => {
                if (value !== 'DELETE ALL') {
                    return 'You must type DELETE ALL to confirm!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading indicator
                Swal.fire({
                    title: 'Deleting Registrations...',
                    text: 'Please wait while we delete all registrations.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                document.getElementById('deleteAllRegistrationsForm').submit();
            }
        });
    }

    // Function to confirm delete single registration
    function confirmDeleteRegistration(registrationId, participantName, role) {
        const roleText = role === 'leader' ? ' (Group Leader)' : 
                        role === 'participant' ? ' (Participant)' : 
                        ' (Solo Participant)';

        Swal.fire({
            title: 'Delete Registration?',
            html: `
                <div class="text-left">
                    <p>Are you sure you want to delete the registration for:</p>
                    <p class="font-semibold text-red-600 mt-2">"${participantName}"${roleText}</p>
                    <p class="text-sm text-gray-600 mt-2">This action cannot be undone and the registration will be permanently removed from the event.</p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Cancel',
            input: 'text',
            inputLabel: 'Type "DELETE" to confirm:',
            inputPlaceholder: 'Type DELETE here...',
            inputValidator: (value) => {
                if (value !== 'DELETE') {
                    return 'You must type DELETE to confirm!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a dynamic form to submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/registrations/${registrationId}`;
                form.style.display = 'none';
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add method spoofing
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                // Add to document and submit
                document.body.appendChild(form);
                
                // Show loading indicator
                Swal.fire({
                    title: 'Deleting Registration...',
                    text: 'Please wait while we remove the registration.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                form.submit();
            }
        });
    }

    // Success/Error messages from backend
    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonColor: '#3085d6',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonColor: '#d33',
        });
    @endif
</script>
@endsection