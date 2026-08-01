@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-4 text-text-dark">Add Coordinator</h1>

    <form action="{{ route('admin.coordinators.store') }}" method="POST" class="max-w-lg" enctype="multipart/form-data">
        @csrf

        @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Password</label>
            <input type="password" name="password" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        {{-- 🔽 Changed from single select to multi-select --}}
        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Events</label>
            <select name="event_ids[]" 
                    class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" multiple required>
                @foreach($events as $event)
                    <option value="{{ $event->event_id }}" {{ collect(old('event_ids'))->contains($event->event_id) ? 'selected' : '' }}>
                        {{ $event->event_name }}
                    </option>
                @endforeach
            </select>
            <small class="text-text-light">Hold <kbd>Ctrl</kbd> (Windows) or <kbd>Cmd</kbd> (Mac) to select multiple</small>
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Mobile</label>
            <input type="text" name="mobile" value="{{ old('mobile') }}" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Extension</label>
            <input type="text" name="ext" value="{{ old('ext') }}" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">School</label>
            <input type="text" name="school" value="{{ old('school') }}" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div class="mb-6">
            <label class="block font-heading font-semibold text-text-dark">Profile Picture</label>
            <input type="file" name="profile_pic" 
                   class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:opacity-90 transition">
            Add Coordinator
        </button>
    </form>
</div>
@endsection