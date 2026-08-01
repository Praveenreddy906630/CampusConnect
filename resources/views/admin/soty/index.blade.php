@extends('layouts.admin')

@section('content')
<div class="p-6 font-body space-y-6" style="z-index: -50;">
    <h2 class="text-2xl font-heading font-bold text-text-dark">Student of the Year Submissions</h2>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.soty.index') }}"
        class="grid grid-cols-1 md:grid-cols-6 gap-4 bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        {{-- Search --}}
        <div>
            <label class="block text-sm font-heading font-semibold mb-1 text-text-dark">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Enrolment, Name, Email"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        {{-- From Date --}}
        <div>
            <label class="block text-sm font-heading font-semibold mb-1 text-text-dark">From</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        {{-- To Date --}}
        <div>
            <label class="block text-sm font-heading font-semibold mb-1 text-text-dark">To</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        {{-- Gender --}}
        <div>
            <label class="block text-sm font-heading font-semibold mb-1 text-text-dark">Gender</label>
            <select name="gender" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:outline-none">
                <option value="">All Genders</option>
                <option value="M" {{ request('gender')=='M'?'selected':'' }}>Male</option>
                <option value="F" {{ request('gender')=='F'?'selected':'' }}>Female</option>
            </select>
        </div>

        {{-- Program --}}
        <div>
            <label class="block text-sm font-heading font-semibold mb-1 text-text-dark">Program</label>
            <input type="text" name="program" value="{{ request('program') }}"
                placeholder="e.g. B.Tech, MBA"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        {{-- Semester --}}
        <div>
            <label class="block text-sm font-heading font-semibold mb-1 text-text-dark">Semester</label>
            <input type="number" name="semester" value="{{ request('semester') }}"
                placeholder="e.g. 5"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        {{-- Buttons --}}
        <div class="md:col-span-6 flex gap-3 mt-2">
            <button type="submit"
                class="bg-primary hover:opacity-90 text-white px-4 py-2 rounded-lg shadow-sm transition">
                Apply Filters
            </button>
            <a href="{{ route('admin.soty.index') }}"
                class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg shadow-sm transition">
                Reset
            </a>
        </div>
    </form>

    {{-- Delete All --}}
    @if($submissions->count() > 0)
    <form action="{{ route('admin.soty.deleteAll') }}" method="POST" id="deleteAllSubmissionsForm">
        @csrf
        @method('DELETE')
        <button type="button" onclick="confirmDeleteAllSubmissions()"
            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
            Delete All Submissions
        </button>
    </form>
    @endif

    {{-- Submissions Table --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
        <table class="min-w-full border-collapse text-sm">
            <thead class="bg-gray-100 text-text-dark uppercase text-left">
                <tr class="bg-gray-100 uppercase font-heading text-text-dark">
                    <th class="px-4 py-2 border">Enrolment</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Mobile</th>
                    <th class="px-4 py-2 border">Gender</th>
                    <th class="px-4 py-2 border">Program</th>
                    <th class="px-4 py-2 border">Sem</th>
                    <th class="px-4 py-2 border">Even Att.</th>
                    <th class="px-4 py-2 border">Odd Att.</th>
                    <th class="px-4 py-2 border">Even CGPA</th>
                    <th class="px-4 py-2 border">Odd CGPA</th>
                    <th class="px-4 py-2 border">Details</th>
                    <th class="px-4 py-2 border">Question</th>
                    <th class="px-4 py-2 border">Documents</th>
                    <th class="px-4 py-2 border">Submitted At</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse($submissions as $soty)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2 border font-medium">{{ $soty->enrolment_no }}</td>
                    <td class="px-4 py-2 border">{{ $soty->student->full_name ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $soty->student->email ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $soty->student->mobile ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $soty->student->gender ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $soty->student->program_code ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $soty->student->semester ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $soty->even_attendance }}</td>
                    <td class="px-4 py-2 border">{{ $soty->odd_attendance }}</td>
                    <td class="px-4 py-2 border">{{ $soty->even_cgpa }}</td>
                    <td class="px-4 py-2 border">{{ $soty->odd_cgpa }}</td>
                    <td class="px-4 py-2 border text-left">
                        <span title="{{ $soty->details }}">
                            {{ Str::limit($soty->details, 30) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border text-left">
                        <span title="{{ $soty->question }}">
                            {{ Str::limit($soty->question, 30) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border">
                        @if($soty->file_location)
                        <a href="{{ asset('storage/' . $soty->file_location) }}" target="_blank"
                            class="text-primary hover:text-red-800 underline">
                            Download
                        </a>
                        @else
                        <span class="text-text-light">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">{{ $soty->created_at->format('d-m-Y H:i') }}</td>
                    <td class="px-4 py-2 border">
                        <button type="button"
                            onclick="confirmDeleteSubmission({{ $soty->soty_id }}, '{{ addslashes($soty->student->full_name ?? $soty->enrolment_no) }}')"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs shadow-sm">
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="17" class="px-4 py-6 text-center text-text-light">No submissions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $submissions->links('pagination::tailwind') }}
    </div>
</div>

<script>
    // Function to confirm delete all submissions
    function confirmDeleteAllSubmissions() {
        const totalSubmissions = {
            {
                $submissions - > count()
            }
        };

        if (totalSubmissions === 0) {
            Swal.fire({
                title: 'No Submissions',
                text: 'There are no submissions to delete.',
                icon: 'info',
                confirmButtonColor: '#3085d6',
            });
            return;
        }

        Swal.fire({
            title: 'Delete All Submissions?',
            html: `
            <div class="text-left">
                <p class="text-red-600 font-semibold mb-3">⚠️ This will delete ALL Student of the Year submissions!</p>
                <ul class="list-disc list-inside text-sm text-gray-700 mb-4">
                    <li>Total submissions to be deleted: <strong>${totalSubmissions}</strong></li>
                    <li>All student application data will be permanently removed</li>
                    <li>Uploaded documents will be deleted from storage</li>
                    <li>This action cannot be undone</li>
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
                    title: 'Deleting Submissions...',
                    text: 'Please wait while we delete all submissions.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit the form
                document.getElementById('deleteAllSubmissionsForm').submit();
            }
        });
    }

    // Function to confirm delete single submission
    function confirmDeleteSubmission(submissionId, studentName) {
        Swal.fire({
            title: 'Delete Submission?',
            html: `
            <div class="text-left">
                <p>Are you sure you want to delete the SOTY submission for:</p>
                <p class="font-semibold text-red-600 mt-2">"${studentName}"</p>
                <p class="text-sm text-gray-600 mt-2">This action cannot be undone and all submission data including uploaded documents will be permanently deleted.</p>
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
                form.action = `/admin/soty/${submissionId}`;
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
                    title: 'Deleting Submission...',
                    text: 'Please wait while we remove the submission.',
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
        text: '{{ session('
        success ') }}',
        icon: 'success',
        confirmButtonColor: '#3085d6',
    });
    @endif

    @if(session('error'))
    Swal.fire({
        title: 'Error!',
        text: '{{ session('
        error ') }}',
        icon: 'error',
        confirmButtonColor: '#d33',
    });
    @endif

    // Show full text on hover for truncated content
    document.addEventListener('DOMContentLoaded', function() {
        const truncatedCells = document.querySelectorAll('td span[title]');
        truncatedCells.forEach(cell => {
            cell.addEventListener('click', function() {
                Swal.fire({
                    title: 'Full Content',
                    text: this.title,
                    icon: 'info',
                    confirmButtonColor: '#3085d6',
                    width: '600px'
                });
            });
        });
    });
</script>
@endsection