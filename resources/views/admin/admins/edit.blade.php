@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-4 text-text-dark">Edit Admin</h1>

    <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-heading font-semibold text-text-dark">Name</label>
            <input type="text" name="name" value="{{ old('name', $admin->name) }}" 
                   class="border border-gray-300 w-full p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div>
            <label class="block font-heading font-semibold text-text-dark">Email</label>
            <input type="email" name="email" value="{{ old('email', $admin->email) }}" 
                   class="border border-gray-300 w-full p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div>
            <label class="block font-heading font-semibold text-text-dark">Password (leave blank to keep current)</label>
            <input type="password" name="password" 
                   class="border border-gray-300 w-full p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <div>
            <label class="block font-heading font-semibold text-text-dark">Confirm Password</label>
            <input type="password" name="password_confirmation" 
                   class="border border-gray-300 w-full p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:opacity-90 transition">
            Update Admin
        </button>
    </form>
</div>
@endsection