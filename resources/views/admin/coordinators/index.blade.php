@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-6 text-text-dark">All Coordinators</h1>

    <a href="{{ route('admin.coordinators.create') }}" 
       class="bg-primary hover:opacity-90 text-white px-5 py-2 rounded-lg mb-6 inline-block shadow transition">
       ➕ Add Coordinator
    </a>

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-4 max-w-md mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-heading font-semibold text-text-dark">Profile Picture Preview</h3>
                <button onclick="closeImageModal()" class="text-2xl text-text-light hover:text-text-dark">&times;</button>
            </div>
            <img id="modalImage" src="" alt="Profile preview" class="w-full h-64 object-contain rounded">
            <div class="mt-4 text-center">
                <button onclick="closeImageModal()" class="bg-primary text-white px-4 py-2 rounded-md hover:opacity-90 transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-text-dark uppercase text-left">
                <tr class="bg-gray-100 text-left text-sm font-heading text-text-dark">
                    <th class="px-4 py-3 border">Sr.</th>
                    <th class="px-4 py-3 border">Profile Pic</th>
                    <th class="px-4 py-3 border">Name</th>
                    <th class="px-4 py-3 border">Email</th>
                    <th class="px-4 py-3 border">Events</th>
                    <th class="px-4 py-3 border">Mobile</th>
                    <th class="px-4 py-3 border">School</th>
                    <th class="px-4 py-3 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coordinators as $c)
                <tr class="hover:bg-gray-50 text-sm">
                    <td class="px-4 py-3 border text-center font-medium text-text-dark">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 border text-center">
                        @if($c->profile_pic)
                            @php
                                // Check if the image exists in storage
                                $imagePath = 'storage/' . $c->profile_pic;
                                $imageExists = file_exists(public_path($imagePath)) || 
                                              file_exists(storage_path('app/public/' . $c->profile_pic));
                            @endphp
                            
                            @if($imageExists)
                                <img src="{{ asset('storage/' . $c->profile_pic) }}" 
                                     alt="Profile" 
                                     class="w-12 h-12 rounded-full mx-auto shadow-sm cursor-pointer hover:opacity-80 transition"
                                     onclick="openImageModal('{{ asset('storage/' . $c->profile_pic) }}')">
                            @else
                                <span class="text-text-light italic text-xs">Image not found</span>
                                <div class="text-text-light text-xs mt-1">
                                    Path: {{ $c->profile_pic }}
                                </div>
                            @endif
                        @else
                            <span class="text-text-light italic">No Image</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 border font-semibold text-text-dark">{{ $c->user->name }}</td>
                    <td class="px-4 py-3 border text-text-light">{{ $c->user->email }}</td>

                    <td class="px-4 py-3 border">
                        @if($c->events->isNotEmpty())
                            @foreach($c->events as $event)
                                <span class="inline-block px-2 py-1 bg-gray-200 text-text-dark rounded text-xs mr-1 mb-1">
                                    {{ $event->event_name }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-text-light italic">No Events</span>
                        @endif
                    </td>

                    <td class="px-4 py-3 border text-text-dark">{{ $c->mobile }}</td>
                    <td class="px-4 py-3 border text-text-dark">{{ $c->school }}</td>
                    <td class="px-4 py-3 border text-center space-x-2">
                        <a href="{{ route('admin.coordinators.edit', $c->coordinator_id) }}"
                            class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow transition">
                            ✏️ Edit
                        </a>
                        <button type="button" 
                                onclick="confirmDeleteCoordinator({{ $c->coordinator_id }}, '{{ addslashes($c->user->name) }}', {{ $c->events->count() }})"
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
// Image preview modal functions
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imagePreviewModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imagePreviewModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside the image content
document.getElementById('imagePreviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Function to confirm delete coordinator
function confirmDeleteCoordinator(coordinatorId, coordinatorName, eventCount) {
    let warningHtml = '';
    
    if (eventCount > 0) {
        warningHtml = `
            <div class="text-left">
                <p class="text-red-600 font-semibold mb-3">⚠️ Important Warning:</p>
                <p>This coordinator is currently assigned to <strong>${eventCount} event(s)</strong>.</p>
                <p class="text-sm text-gray-600 mt-2">Deleting this coordinator will remove them from all assigned events.</p>
                <p class="font-semibold text-red-600 mt-4">Are you sure you want to delete coordinator:</p>
                <p class="font-bold text-lg">"${coordinatorName}"</p>
            </div>
        `;
    } else {
        warningHtml = `
            <div class="text-left">
                <p>Are you sure you want to delete coordinator:</p>
                <p class="font-semibold text-red-600 mt-2">"${coordinatorName}"</p>
                <p class="text-sm text-gray-600 mt-2">This action cannot be undone and the coordinator will lose all access.</p>
            </div>
        `;
    }

    Swal.fire({
        title: 'Delete Coordinator?',
        html: warningHtml,
        icon: eventCount > 0 ? 'warning' : 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: eventCount > 0 ? 'Yes, delete anyway!' : 'Yes, delete coordinator!',
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
            // Create a dynamic form to submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/coordinators/${coordinatorId}`;
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
                title: 'Deleting Coordinator...',
                text: 'Please wait while we remove the coordinator account.',
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

@if(session('created'))
    Swal.fire({
        title: 'Coordinator Created!',
        text: '{{ session('created') }}',
        icon: 'success',
        confirmButtonColor: '#3085d6',
    });
@endif

@if(session('updated'))
    Swal.fire({
        title: 'Coordinator Updated!',
        text: '{{ session('updated') }}',
        icon: 'success',
        confirmButtonColor: '#3085d6',
    });
@endif
</script>

<style>
/* Add a subtle animation for the modal */
#imagePreviewModal {
    transition: opacity 0.3s ease;
}
#imagePreviewModal:not(.hidden) {
    display: flex !important;
}
</style>
@endsection