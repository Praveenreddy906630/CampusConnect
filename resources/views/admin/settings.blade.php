@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-6 text-text-dark">Settings</h1>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-md">
        {{ session('error') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-md">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-heading font-semibold mb-2 text-text-dark">Registration Start Date</label>
            <input type="date" name="registration_start"
                value="{{ $settings->registration_start }}"
                class="border border-gray-300 p-2 rounded-md w-full focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold mb-2 text-text-dark">Registration End Date</label>
            <input type="date" name="registration_end"
                value="{{ $settings->registration_end }}"
                class="border border-gray-300 p-2 rounded-md w-full focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Max Outdoor Events</label>
            <input type="number" name="max_outdoor_events" value="{{ old('max_outdoor_events', $settings->max_outdoor_events) }}"
                class="w-full border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Max Indoor Events</label>
            <input type="number" name="max_indoor_events" value="{{ old('max_indoor_events', $settings->max_indoor_events) }}"
                class="w-full border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Max Cultural Events</label>
            <input type="number" name="max_cultural_events" value="{{ old('max_cultural_events', $settings->max_cultural_events) }}"
                class="w-full border border-gray-300 px-3 py-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:opacity-90 transition">
            Save Settings
        </button>
    </form>
</div>
@endsection