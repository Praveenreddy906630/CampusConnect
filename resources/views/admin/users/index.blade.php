@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-6 text-text-dark">
        Users
    </h1>

    <!-- Delete All Users Button -->
    <form action="{{ route('admin.users.deleteAll') }}" method="POST" id="deleteAllUsersForm">
        @csrf
        @method('DELETE')
        <button type="button" onclick="confirmDeleteAllUsers()" 
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors">
            Delete All Users
        </button>
    </form><br>

    <!-- Users Table -->
    <div class="overflow-x-auto border rounded-md shadow-sm">
        <table class="min-w-full text-left text-sm font-body">
            <thead class="bg-gray-100 text-text-dark uppercase text-left">
                <tr class="font-heading">
                    <th class="px-4 py-3 border text-text-dark">
                        <a href="{{ route('admin.users.index', ['sort_by' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                            Name {!! request('sort_by') == 'name' ? (request('direction') == 'asc' ? '&#9650;' : '&#9660;') : '' !!}
                        </a>
                    </th>
                    <th class="px-4 py-3 border text-text-dark">
                        <a href="{{ route('admin.users.index', ['sort_by' => 'email', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                            Email {!! request('sort_by') == 'email' ? (request('direction') == 'asc' ? '&#9650;' : '&#9660;') : '' !!}
                        </a>
                    </th>
                    <th class="px-4 py-3 border text-text-dark">Enrolment No</th>
                    <th class="px-4 py-3 border text-text-dark">
                        <a href="{{ route('admin.users.index', ['sort_by' => 'user_type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                            Role {!! request('sort_by') == 'user_type' ? (request('direction') == 'asc' ? '&#9650;' : '&#9660;') : '' !!}
                        </a>
                    </th>
                    <th class="px-4 py-3 border text-text-dark">
                        <a href="{{ route('admin.users.index', ['sort_by' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                            Joined {!! request('sort_by') == 'created_at' || !request('sort_by') ? (request('direction') == 'asc' ? '&#9650;' : '&#9660;') : '' !!}
                        </a>
                    </th>
                    <th class="px-4 py-3 border text-text-dark">Outdoor Events</th>
                    <th class="px-4 py-3 border text-text-dark">Indoor Events</th>
                    <th class="px-4 py-3 border text-text-dark">Cultural Events</th>
                    <th class="px-4 py-3 border text-text-dark">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 text-center">
                    <td class="px-4 py-2 border text-text-dark">{{ $user->name }}</td>
                    <td class="px-4 py-2 border text-text-dark">{{ $user->email }}</td>
                    <td class="px-4 py-2 border text-text-dark">{{ $user->enrolment_no ?? '-' }}</td>
                    <td class="px-4 py-2 border">
                        <span class="px-2 py-1 text-xs rounded-full 
                        {{ $user->user_type === 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($user->user_type) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border text-text-dark">{{ $user->created_at->format('d M, Y') }}</td>
                    <td class="px-4 py-2 border text-text-dark">{{ $user->events_count['outdoor'] ?? 0 }} / {{ $user->max_allowed['outdoor'] ?? 0 }}</td>
                    <td class="px-4 py-2 border text-text-dark">{{ $user->events_count['indoor'] ?? 0 }} / {{ $user->max_allowed['indoor'] ?? 0 }}</td>
                    <td class="px-4 py-2 border text-text-dark">{{ $user->events_count['cultural'] ?? 0 }} / {{ $user->max_allowed['cultural'] ?? 0 }}</td>
                    <td class="px-4 py-2 border">
                        <button type="button" onclick="confirmDeleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')" 
                                class="text-red-600 hover:text-red-800 transition-colors font-medium">
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-6 text-center text-text-light">
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

<script>
// Function to confirm delete all users
function confirmDeleteAllUsers() {
    Swal.fire({
        title: 'Delete All Non-Admin Users?',
        html: `
            <div class="text-left">
                <p class="text-red-600 font-semibold mb-3">This action will permanently delete all non-admin users!</p>
                <ul class="list-disc list-inside text-sm text-gray-700 mb-4">
                    <li>All user accounts except admin accounts will be deleted</li>
                    <li>This action cannot be undone</li>
                    <li>All user data, events, and records will be lost</li>
                </ul>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete all users!',
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
                title: 'Deleting Users...',
                text: 'Please wait while we delete all non-admin users.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit the form
            document.getElementById('deleteAllUsersForm').submit();
        }
    });
}

// Function to confirm delete single user
function confirmDeleteUser(userId, userName) {
    Swal.fire({
        title: 'Delete User?',
        html: `
            <div class="text-left">
                <p>Are you sure you want to delete the user:</p>
                <p class="font-semibold text-red-600 mt-2">"${userName}"</p>
                <p class="text-sm text-gray-600 mt-2">This action cannot be undone and all user data will be permanently deleted.</p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete user!',
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
            form.action = `/admin/users/${userId}`;
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
                title: 'Deleting User...',
                text: 'Please wait while we delete the user.',
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

// Show warning if trying to delete when no users exist
document.getElementById('deleteAllUsersForm').addEventListener('submit', function(e) {
    @if($users->count() === 0)
        e.preventDefault();
        Swal.fire({
            title: 'No Users Found',
            text: 'There are no users to delete.',
            icon: 'info',
            confirmButtonColor: '#3085d6',
        });
    @endif
});
</script>
@endsection