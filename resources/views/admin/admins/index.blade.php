@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-6 text-text-dark">All Admins</h1>

    <a href="{{ route('admin.admins.create') }}" 
       class="bg-primary hover:opacity-90 text-white px-5 py-2 rounded-lg mb-6 inline-block shadow transition">
       + Add Admin
    </a>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-text-dark uppercase text-left">
                <tr class="bg-gray-100 text-left text-sm font-heading text-text-dark">
                    <th class="px-4 py-3 border">Sr.</th>
                    <th class="px-4 py-3 border">Name</th>
                    <th class="px-4 py-3 border">Email</th>
                    <th class="px-4 py-3 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr class="hover:bg-gray-50 text-sm">
                    <td class="px-4 py-3 border text-center font-medium text-text-dark">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 border font-semibold text-text-dark">{{ $admin->name }}</td>
                    <td class="px-4 py-3 border text-text-light">{{ $admin->email }}</td>
                    <td class="px-4 py-3 border text-center space-x-2">
                        <a href="{{ route('admin.admins.edit', $admin->id) }}"
                            class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow transition">
                            ✏️ Edit
                        </a>
                        <button type="button" 
                                onclick="confirmDeleteAdmin({{ $admin->id }}, '{{ addslashes($admin->name) }}')"
                                class="inline-flex items-center gap-1 px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded shadow transition">
                            🗑️ Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
// Function to confirm delete admin
function confirmDeleteAdmin(adminId, adminName) {
    // Check if user is trying to delete themselves
    const currentAdminId = {{ Auth::id() }};
    if (adminId === currentAdminId) {
        Swal.fire({
            title: 'Cannot Delete Your Own Account',
            text: 'You cannot delete your own admin account for security reasons.',
            icon: 'error',
            confirmButtonColor: '#d33',
        });
        return;
    }

    Swal.fire({
        title: 'Delete Admin?',
        html: `
            <div class="text-left">
                <p>Are you sure you want to delete the admin account for:</p>
                <p class="font-semibold text-red-600 mt-2">"${adminName}"</p>
                <p class="text-sm text-gray-600 mt-2">This action cannot be undone and the admin will lose all access privileges.</p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete admin!',
        cancelButtonText: 'Cancel',
        input: 'text',
        inputLabel: 'To confirm, type "DELETE ADMIN" below:',
        inputPlaceholder: 'Type DELETE ADMIN here...',
        inputValidator: (value) => {
            if (value !== 'DELETE ADMIN') {
                return 'You must type DELETE ADMIN to confirm!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a dynamic form to submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/admins/${adminId}`;
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
                title: 'Deleting Admin...',
                text: 'Please wait while we remove the admin account.',
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

// Show success message for admin creation
@if(session('created'))
    Swal.fire({
        title: 'Admin Created!',
        text: '{{ session('created') }}',
        icon: 'success',
        confirmButtonColor: '#3085d6',
    });
@endif

// Show success message for admin update
@if(session('updated'))
    Swal.fire({
        title: 'Admin Updated!',
        text: '{{ session('updated') }}',
        icon: 'success',
        confirmButtonColor: '#3085d6',
    });
@endif
</script>
@endsection