@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-6 text-text-dark">
        All Students
    </h1>

    <!-- Search & Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4 text-text-dark">Search & Filters</h2>

        <form method="GET" class="flex flex-col md:flex-row md:items-center gap-4 flex-wrap">
            <!-- Search Input -->
            <input type="text" name="search" placeholder="🔍 Search by name, email, enrolment..."
                value="{{ request('search') }}"
                class="border border-gray-300 px-3 py-2 rounded-md flex-1
                   placeholder-text-light placeholder-italic
                   focus:ring-2 focus:ring-primary focus:border-primary focus:outline-none">

            <!-- Program Filter -->
            <select name="program_code"
                class="border border-gray-300 px-3 py-2 rounded-md
                   focus:ring-2 focus:ring-primary focus:outline-none">
                <option value="">📚 All Programs</option>
                @foreach(\App\Models\Student::select('program_code')->distinct()->get() as $prog)
                <option value="{{ $prog->program_code }}"
                    {{ request('program_code') == $prog->program_code ? 'selected' : '' }}>
                    {{ $prog->program_code }}
                </option>
                @endforeach
            </select>

            <!-- Gender Filter -->
            <select name="gender"
                class="border border-gray-300 px-3 py-2 rounded-md
                   focus:ring-2 focus:ring-primary focus:outline-none">
                <option value="">⚧ All Genders</option>
                <option value="M" {{ request('gender')=='M'?'selected':'' }}>Male</option>
                <option value="F" {{ request('gender')=='F'?'selected':'' }}>Female</option>
            </select>

            <!-- Semester Filter -->
            <select name="semester"
                class="border border-gray-300 px-3 py-2 rounded-md
                   focus:ring-2 focus:ring-primary focus:outline-none">
                <option value="">🎓 All Semesters</option>
                @for($i=1; $i<=8; $i++)
                    <option value="{{ $i }}" {{ request('semester')==$i?'selected':'' }}>{{ $i }}</option>
                    @endfor
            </select>

            <!-- Submit Button -->
            <button type="submit"
                class="bg-primary text-white px-4 py-2 rounded-md hover:opacity-90 transition">
                Apply
            </button>
        </form>
    </div>

    <!-- Action Buttons Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4 text-text-dark">Student Actions</h2>

        <div class="flex flex-col md:flex-row md:items-center gap-4 flex-wrap">
            <!-- Export CSV -->
            <a href="{{ route('admin.students.export') }}"
                class="px-4 py-2 bg-primary text-white rounded-md shadow-sm hover:opacity-90 transition flex items-center justify-center">
                📤 Export CSV
            </a>

            <!-- Import CSV -->
            <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" class="flex gap-2 items-center" id="importForm">
                @csrf
                <input type="file" name="csv_file" id="csvFile"
                    class="border border-gray-300 px-2 py-1 rounded-md text-sm focus:ring-2 focus:ring-primary focus:outline-none">
                <button type="submit"
                    class="px-4 py-2 bg-primary text-white rounded-md shadow-sm hover:opacity-90 transition flex items-center justify-center">
                    📥 Import CSV
                </button>
            </form>

            <!-- Delete All Students -->
            <form action="{{ route('admin.students.deleteAll') }}" method="POST" id="deleteAllForm">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmDeleteAll()"
                    class="px-4 py-2 bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700 transition flex items-center justify-center">
                    🗑 Delete All Students
                </button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto border rounded-md shadow-sm">
        <table class="min-w-full border-collapse text-sm">
            <thead class="bg-gray-100 text-text-dark font-heading">
                <tr>
                    <th class="px-4 py-3 border text-left">Enrolment Number</th>
                    <th class="px-4 py-3 border text-left">Name</th>
                    <th class="px-4 py-3 border text-left">Program Code</th>
                    <th class="px-4 py-3 border text-left">Gender</th>
                    <th class="px-4 py-3 border text-left">Phone</th>
                    <th class="px-4 py-3 border text-left">Email</th>
                    <th class="px-4 py-3 border text-left">Department Code</th>
                    <th class="px-4 py-3 border text-left">School Code</th>
                    <th class="px-4 py-3 border text-left">School Name</th>
                    <th class="px-4 py-3 border text-left">Semester</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($students as $student)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $student->enroll_no }}</td>
                    <td class="px-4 py-2 border">{{ $student->full_name }}</td>
                    <td class="px-4 py-2 border">{{ $student->program_code }}</td>
                    <td class="px-4 py-2 border">{{ $student->gender }}</td>
                    <td class="px-4 py-2 border">{{ $student->mobile }}</td>
                    <td class="px-4 py-2 border">{{ $student->email }}</td>
                    <td class="px-4 py-2 border">{{ $student->dept_code}}</td>
                    <td class="px-4 py-2 border">{{ $student->school_code}}</td>
                    <td class="px-4 py-2 border">{{ $student->school_name}}</td>
                    <td class="px-4 py-2 border">{{ $student->semester}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-4 py-6 text-center text-text-light">
                        No students found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
// Function to confirm delete all students
function confirmDeleteAll() {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete ALL students permanently! This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete all!',
        cancelButtonText: 'Cancel',
        input: 'text',
        inputLabel: 'To confirm, type "DELETE" below:',
        inputPlaceholder: 'Type DELETE here...',
        inputValidator: (value) => {
            if (value !== 'DELETE') {
                return 'You must type DELETE to confirm!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form if confirmed
            document.getElementById('deleteAllForm').submit();
        }
    });
}

// Import CSV confirmation
document.getElementById('importForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('csvFile');
    
    if (fileInput.files.length === 0) {
        e.preventDefault();
        Swal.fire({
            title: 'No file selected!',
            text: 'Please select a CSV file to import.',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
        });
        return;
    }

    e.preventDefault();
    
    Swal.fire({
        title: 'Import CSV?',
        text: 'This will import student data from the selected CSV file.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, import!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form if confirmed
            this.submit();
        }
    });
});

// Success messages for import/export/delete
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