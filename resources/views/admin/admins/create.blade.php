@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-4 text-text-dark">Add New Admin</h1>

    <form action="{{ route('admin.admins.store') }}" method="POST" class="space-y-4">
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
            <label class="block font-heading font-semibold text-text-dark">Name</label>
            <input type="text" name="name" class="border border-gray-300 w-full p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div>
            <label class="block font-heading font-semibold text-text-dark">Email</label>
            <input type="email" name="email" class="border border-gray-300 w-full p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div>
            <label class="block font-heading font-semibold text-text-dark">Password</label>
            <input type="password" name="password" class="border border-gray-300 w-full p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div>
            <label class="block font-heading font-semibold text-text-dark">Confirm Password</label>
            <input type="password" name="password_confirmation" class="border border-gray-300 w-full p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:opacity-90 transition">
            Create Admin
        </button>
    </form>
</div>
@endsection