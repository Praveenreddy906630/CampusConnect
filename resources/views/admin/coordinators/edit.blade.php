@extends('layouts.admin')

@section('content')
<div class="p-6 font-body">
    <h1 class="text-2xl font-heading font-bold mb-4 text-text-dark">Edit Coordinator</h1>

    <form action="{{ route('admin.coordinators.update', $coordinator->coordinator_id) }}" 
          method="POST" class="max-w-lg" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
            <input type="text" name="name" value="{{ old('name', $coordinator->user->name) }}" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Email</label>
            <input type="email" name="email" value="{{ old('email', $coordinator->user->email) }}" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Password (leave blank to keep current)</label>
            <input type="password" name="password" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <!-- ✅ Multiple Events Dropdown -->
        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Events</label>
            <select name="event_ids[]" 
                    class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" multiple required>
                @foreach($events as $event)
                <option value="{{ $event->event_id }}"
                    {{ in_array($event->event_id, $coordinator->events->pluck('event_id')->toArray()) ? 'selected' : '' }}>
                    {{ $event->event_name }}
                </option>
                @endforeach
            </select>
            <small class="text-text-light">Hold Ctrl (Windows) / Command (Mac) to select multiple events.</small>
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Mobile</label>
            <input type="text" name="mobile" value="{{ old('mobile', $coordinator->mobile) }}" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">Extension</label>
            <input type="text" name="ext" value="{{ old('ext', $coordinator->ext) }}" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none">
        </div>

        <div class="mb-4">
            <label class="block font-heading font-semibold text-text-dark">School</label>
            <input type="text" name="school" value="{{ old('school', $coordinator->school) }}" 
                   class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-primary focus:outline-none" required>
        </div>

        <div class="mb-6">
            <label class="block font-heading font-semibold text-text-dark">Profile Picture</label>
            
            <!-- Current Image -->
            @if($coordinator->profile_pic)
                <img src="{{ asset('storage/'.$coordinator->profile_pic) }}" 
                     class="w-20 h-20 rounded-full mb-2 object-cover border border-gray-300"
                     id="current-image">
            @endif
            
            <!-- Image Preview -->
            <div id="image-preview" class="hidden mb-3">
                <img id="preview" class="w-20 h-20 rounded-full object-cover border border-gray-300" 
                     src="#" alt="Image preview">
                <p class="text-sm text-text-light mt-1">New image preview</p>
            </div>
            
            <!-- File Input -->
            <input type="file" name="profile_pic" id="profile_pic" 
                   class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-primary focus:outline-none"
                   accept="image/*">
        </div>

        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:opacity-90 transition">
            Update Coordinator
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profilePicInput = document.getElementById('profile_pic');
    const imagePreview = document.getElementById('image-preview');
    const previewImage = document.getElementById('preview');
    const currentImage = document.getElementById('current-image');
    
    profilePicInput.addEventListener('change', function() {
        const file = this.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.addEventListener('load', function() {
                previewImage.src = reader.result;
                imagePreview.classList.remove('hidden');
                
                // Hide current image if exists
                if (currentImage) {
                    currentImage.classList.add('hidden');
                }
            });
            
            reader.readAsDataURL(file);
        } else {
            imagePreview.classList.add('hidden');
            
            // Show current image again if exists
            if (currentImage) {
                currentImage.classList.remove('hidden');
            }
        }
    });
});
</script>
@endsection