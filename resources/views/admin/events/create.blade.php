@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-6 text-text-dark">Add New Event</h1>

    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-xl shadow">
        @csrf

        {{-- ✅ Error Messages --}}
        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg font-body">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div>
            <label class="block text-sm font-medium text-text-dark">Event Name</label>
            <input type="text" name="event_name" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none mt-1"
                placeholder="Enter event name">
        </div>

        <div>
            <label class="block text-sm font-medium text-text-dark">Type</label>
            <select name="type" required
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none mt-1">
                <option value="">Select type</option>
                <option value="indoor">Indoor</option>
                <option value="outdoor">Outdoor</option>
                <option value="cultural">Cultural</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-dark">Description</label>
            <textarea name="description" rows="3"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none mt-1"
                placeholder="Enter description"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-dark">Venue</label>
            <input type="text" name="venue"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none mt-1"
                placeholder="Enter event venue">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-text-dark">Date</label>
                <input type="date" name="event_date" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none mt-1">
            </div>
            <div>
                <label class="block text-sm font-medium text-text-dark">Time</label>
                <input type="time" name="event_time" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none mt-1">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-dark">Event Mode</label>
            <select name="is_group" id="is_group"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none mt-1">
                <option value="0">Solo</option>
                <option value="1">Group</option>
            </select>
        </div>

        <div id="max_group_size_container" class="hidden">
            <label for="max_group_size" class="block text-sm font-medium text-text-dark">Maximum Group Size</label>
            <input type="number" name="max_group_size" id="max_group_size" min="1"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none mt-1">
        </div>

        <div>
            <label class="block text-sm font-medium text-text-dark">Max Participants</label>
            <input type="number" name="max_participants" min="1"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none mt-1"
                placeholder="Enter max participants">
        </div>

        <div class="flex items-center gap-2">
            <input type="hidden" name="registration_open" value="0">
            <input type="checkbox" name="registration_open" id="registration_open" value="1"
                class="h-4 w-4 text-primary border-gray-300 rounded">
            <label for="registration_open" class="text-text-dark">Registration Open?</label>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-dark">Thumbnail Image</label>
            <input type="file" name="thumbnail_image" accept="image/*"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none mt-1">
        </div>

        {{-- Carousel Images --}}
        @for($i=1; $i<=5; $i++)
            <div>
                <label for="carousel_image_{{ $i }}" class="text-text-dark">Carousel Image {{ $i }}</label>
                <input type="file" name="carousel_image_{{ $i }}" id="carousel_image_{{ $i }}" accept="image/*"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:outline-none mt-1">
            </div>
        @endfor

        <div class="flex justify-between items-center pt-6 border-t">
            <a href="{{ route('admin.events.index') }}" class="px-4 py-2 bg-gray-300 text-text-dark rounded-lg hover:bg-gray-400">
                ← Back
            </a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:opacity-90">
                Save Event
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('is_group').addEventListener('change', function () {
        const maxGroup = document.getElementById('max_group_size_container');
        if (this.value === '1') {
            maxGroup.classList.remove('hidden');
        } else {
            maxGroup.classList.add('hidden');
        }
    });
</script>
@endsection
