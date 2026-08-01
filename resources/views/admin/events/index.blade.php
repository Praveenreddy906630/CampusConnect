@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-6 text-text-dark">Events</h1>
    <a href="{{ route('admin.events.create') }}"
        class="bg-primary hover:opacity-90 text-white px-5 py-2 rounded-lg mb-6 inline-block shadow transition">
        <span class="text-lg font-bold">+</span> Add Event
    </a>


    <!-- Delete All Events -->
    <form action="{{ route('admin.events.deleteAll') }}" method="POST" class="delete-all-events-form">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="px-4 py-2 bg-red-600 text-white rounded-md shadow-sm hover:bg-red-700 transition flex items-center justify-center">
            🗑 Delete All Events
        </button>
    </form>

    <br>

    <div class="flex justify-between items-center mb-4">
        <div class="flex space-x-2">
            <form action="{{ route('admin.events.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                @csrf
                <input type="file" name="csv_file" class="border rounded p-1 text-sm" required>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                    Import CSV
                </button>
            </form>

            <a href="{{ route('admin.events.export') }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                Export CSV
            </a>
        </div>
    </div>

    {{-- ✅ Success Message --}}
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded font-body relative">
        {{ session('success') }}
        <button onclick="this.parentElement.remove()"
            class="absolute top-2 right-2 text-green-800 hover:text-green-900">&times;</button>
    </div>
    @endif

    {{-- ✅ Events Table --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-text-dark uppercase text-left">
                <tr class="bg-gray-100 text-left text-sm font-heading text-text-dark">
                    <th class="px-4 py-2">Thumbnail</th>
                    <th class="px-4 py-2">
                        <a href="{{ route('admin.events.index', ['sort_by' => 'event_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                            Event Name {!! request('sort_by') == 'event_name' ? (request('direction') == 'asc' ? '&#9650;' : '&#9660;') : '' !!}
                        </a>
                    </th>
                    <th class="px-4 py-2">
                        <a href="{{ route('admin.events.index', ['sort_by' => 'type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                            Type {!! request('sort_by') == 'type' ? (request('direction') == 'asc' ? '&#9650;' : '&#9660;') : '' !!}
                        </a>
                    </th>
                    <th class="px-4 py-2">
                        <a href="{{ route('admin.events.index', ['sort_by' => 'is_group', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                            Mode {!! request('sort_by') == 'is_group' ? (request('direction') == 'asc' ? '&#9650;' : '&#9660;') : '' !!}
                        </a>
                    </th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-2">
                        @if($event->thumbnail_image)
                        <img src="{{ asset('storage/' . $event->thumbnail_image) }}" alt="Thumbnail"
                            class="w-16 h-16 object-cover rounded-md border">
                        @else
                        <span class="text-text-light italic">No Image</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 font-medium text-text-dark">{{ $event->event_name }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold text-white 
                        {{ $event->type == 'indoor' ? 'bg-blue-500' : ($event->type=='outdoor' ? 'bg-green-500' : 'bg-purple-500') }}">
                            {{ ucfirst($event->type) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold text-white
                        {{ $event->is_group ? 'bg-indigo-500' : 'bg-yellow-500' }}">
                            {{ $event->is_group ? 'Group' : 'Solo' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('admin.events.edit', $event->event_id) }}"
                            class="p-2 bg-yellow-400 hover:bg-yellow-500 rounded-md text-white flex items-center justify-center"
                            title="Edit Event">
                            ✏️
                        </a>


                        <form action="{{ route('admin.events.destroy', $event->event_id) }}" method="POST" class="delete-event-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2 bg-red-500 hover:bg-red-600 rounded-md text-white transition"
                                title="Delete Event">
                                🗑
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-6 text-center text-text-light">No events found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    const editEventUrl = "{{ route('admin.events.edit', ':id') }}";
    const updateEventUrl = "{{ route('admin.events.update', ':id') }}";

    document.addEventListener('DOMContentLoaded', function() {
        const isGroupSelect = document.getElementById('is_group');
        const maxGroupContainer = document.getElementById('max_group_size_container');

        if(isGroupSelect) {
            isGroupSelect.addEventListener('change', function() {
                if (this.value === '1') {
                    maxGroupContainer.style.display = 'block';
                } else {
                    maxGroupContainer.style.display = 'none';
                }
            });
        }

        // SweetAlert for single event deletion
        document.querySelectorAll('.delete-event-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#c5010f',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // SweetAlert for bulk deletion
        const deleteAllForm = document.querySelector('.delete-all-events-form');
        if (deleteAllForm) {
            deleteAllForm.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete ALL events! You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#c5010f',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete all!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        }
    });

</script>
@endsection