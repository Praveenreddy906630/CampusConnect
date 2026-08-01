@extends('layouts.app')

@section('title', 'Student of the Year 2025 | CampusConnect')

@section('content')

<!-- Page Header -->
<header class="page-header bg-gradient-to-r from-primary to-red-700 text-white py-16 lg:py-20 text-center relative overflow-hidden" id="soty-header">
    
    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="floating-bg absolute top-10 left-10 w-32 h-32 bg-white rounded-full"></div>
        <div class="floating-bg absolute bottom-10 right-10 w-24 h-24 bg-white rounded-full"></div>
        <div class="floating-bg absolute top-1/2 right-1/4 w-16 h-16 bg-white rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="header-icon text-6xl mb-4">🏆</div>
        <h1 class="header-title text-3xl sm:text-4xl lg:text-5xl font-heading font-bold mb-4">
            Student of the Year <span class="text-yellow-300">2025</span>
        </h1>
        <p class="header-subtitle text-lg sm:text-xl font-body leading-relaxed max-w-2xl mx-auto">
            Apply now for the most prestigious award celebrating academic excellence and outstanding achievements
        </p>
    </div>
</header>

<main class="soty-main max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="flash-message success-message bg-green-50 border-l-4 border-green-400 text-green-800 p-4 mb-6 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <span class="text-2xl mr-3">✅</span>
            <span class="font-body">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="flash-message error-message bg-red-50 border-l-4 border-primary text-red-800 p-4 mb-6 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <span class="text-2xl mr-3">❌</span>
            <span class="font-body">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    @if($soty && !session('success'))
    <div class="flash-message warning-message bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 mb-6 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <span class="text-2xl mr-3">⚠️</span>
            <span class="font-body">You have already submitted your application. Your previous responses are shown below.</span>
        </div>
    </div>
    @endif

    <!-- Application Form -->
    <div class="form-container bg-white shadow-xl rounded-2xl overflow-hidden">
        
        <!-- Form Header -->
        <div class="form-header bg-gradient-to-r from-primary/10 to-primary/20 p-6 lg:p-8 border-b border-gray-100">
            <h2 class="form-title text-2xl lg:text-3xl font-heading font-bold text-text-dark mb-2">
                Application Form
            </h2>
            <p class="form-subtitle text-text-light font-body">
                Please fill in all the required information accurately
            </p>
        </div>

        <form action="{{ url('/soty/apply') }}" method="POST" enctype="multipart/form-data" class="application-form">
            @csrf

            <div class="form-content p-6 lg:p-8 space-y-8">

                <!-- Student Information Section -->
                <div class="form-section">
                    <h3 class="section-title text-xl font-heading font-bold text-text-dark mb-6 flex items-center">
                        <span class="section-icon w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center mr-3 text-primary">👤</span>
                        Student Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Full Name</label>
                            <input type="text" value="{{ $student->full_name }}" 
                                   class="form-input w-full border border-gray-200 p-4 rounded-xl bg-gray-50 font-body text-text-dark" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Enrollment Number</label>
                            <input type="text" value="{{ $student->enroll_no }}" 
                                   class="form-input w-full border border-gray-200 p-4 rounded-xl bg-gray-50 font-body text-text-dark" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Email Address</label>
                            <input type="email" value="{{ $student->email }}" 
                                   class="form-input w-full border border-gray-200 p-4 rounded-xl bg-gray-50 font-body text-text-dark" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Mobile Number</label>
                            <input type="text" value="{{ $student->mobile }}" 
                                   class="form-input w-full border border-gray-200 p-4 rounded-xl bg-gray-50 font-body text-text-dark" readonly>
                        </div>
                    </div>
                </div>

                <!-- Academic Performance Section -->
                <div class="form-section">
                    <h3 class="section-title text-xl font-heading font-bold text-text-dark mb-6 flex items-center">
                        <span class="section-icon w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center mr-3 text-primary">📊</span>
                        Academic Performance
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Even Semester Attendance (%)</label>
                            <input type="number" name="even_attendance"
                                   value="{{ old('even_attendance', $soty->even_attendance ?? '') }}"
                                   step="0.01" min="0" max="100"
                                   class="form-input w-full border border-gray-300 p-4 rounded-xl font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300 {{ $soty ? 'bg-gray-50' : 'bg-white' }}"
                                   {{ $soty ? 'readonly' : '' }}
                                   placeholder="Enter attendance percentage">
                            @error('even_attendance') 
                            <p class="error-message text-primary mt-2 text-sm font-body flex items-center">
                                <span class="mr-1">⚠️</span>{{ $message }}
                            </p> 
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Odd Semester Attendance (%)</label>
                            <input type="number" name="odd_attendance"
                                   value="{{ old('odd_attendance', $soty->odd_attendance ?? '') }}"
                                   step="0.01" min="0" max="100"
                                   class="form-input w-full border border-gray-300 p-4 rounded-xl font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300 {{ $soty ? 'bg-gray-50' : 'bg-white' }}"
                                   {{ $soty ? 'readonly' : '' }}
                                   placeholder="Enter attendance percentage">
                            @error('odd_attendance') 
                            <p class="error-message text-primary mt-2 text-sm font-body flex items-center">
                                <span class="mr-1">⚠️</span>{{ $message }}
                            </p> 
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Even Semester CGPA</label>
                            <input type="number" name="even_cgpa"
                                   value="{{ old('even_cgpa', $soty->even_cgpa ?? '') }}"
                                   step="0.01" min="0" max="10"
                                   class="form-input w-full border border-gray-300 p-4 rounded-xl font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300 {{ $soty ? 'bg-gray-50' : 'bg-white' }}"
                                   {{ $soty ? 'readonly' : '' }}
                                   placeholder="Enter CGPA (0-10)">
                            @error('even_cgpa') 
                            <p class="error-message text-primary mt-2 text-sm font-body flex items-center">
                                <span class="mr-1">⚠️</span>{{ $message }}
                            </p> 
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Odd Semester CGPA</label>
                            <input type="number" name="odd_cgpa"
                                   value="{{ old('odd_cgpa', $soty->odd_cgpa ?? '') }}"
                                   step="0.01" min="0" max="10"
                                   class="form-input w-full border border-gray-300 p-4 rounded-xl font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300 {{ $soty ? 'bg-gray-50' : 'bg-white' }}"
                                   {{ $soty ? 'readonly' : '' }}
                                   placeholder="Enter CGPA (0-10)">
                            @error('odd_cgpa') 
                            <p class="error-message text-primary mt-2 text-sm font-body flex items-center">
                                <span class="mr-1">⚠️</span>{{ $message }}
                            </p> 
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Application Questions Section -->
                <div class="form-section">
                    <h3 class="section-title text-xl font-heading font-bold text-text-dark mb-6 flex items-center">
                        <span class="section-icon w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center mr-3 text-primary">📝</span>
                        Application Questions
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                                1. Details about Co-curricular Activities / Special Achievements
                            </label>
                            <textarea name="details" rows="5" 
                                      class="form-input w-full border border-gray-300 p-4 rounded-xl font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300 resize-none {{ $soty ? 'bg-gray-50' : 'bg-white' }}"
                                      {{ $soty ? 'readonly' : '' }}
                                      placeholder="Describe your co-curricular activities, achievements, awards, competitions, projects, leadership roles, etc.">{{ old('details', $soty->details ?? '') }}</textarea>
                            @error('details') 
                            <p class="error-message text-primary mt-2 text-sm font-body flex items-center">
                                <span class="mr-1">⚠️</span>{{ $message }}
                            </p> 
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                                2. Why do you think you are the right contestant for the award?
                            </label>
                            <textarea name="question" rows="5" 
                                      class="form-input w-full border border-gray-300 p-4 rounded-xl font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300 resize-none {{ $soty ? 'bg-gray-50' : 'bg-white' }}"
                                      {{ $soty ? 'readonly' : '' }}
                                      placeholder="Explain what makes you unique, your contributions, impact, and why you deserve this recognition.">{{ old('question', $soty->question ?? '') }}</textarea>
                            @error('question') 
                            <p class="error-message text-primary mt-2 text-sm font-body flex items-center">
                                <span class="mr-1">⚠️</span>{{ $message }}
                            </p> 
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Document Upload Section -->
                <div class="form-section">
                    <h3 class="section-title text-xl font-heading font-bold text-text-dark mb-6 flex items-center">
                        <span class="section-icon w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center mr-3 text-primary">📎</span>
                        Supporting Documents
                    </h3>
                    
                    <div class="form-group">
                        @if($soty)
                        <div class="document-download bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                            <div class="text-4xl mb-3">📄</div>
                            <p class="text-text-dark font-body mb-4">Your documents have been successfully uploaded</p>
                            <a href="{{ asset('storage/' . $soty->file_location) }}" target="_blank" 
                               class="download-btn inline-flex items-center bg-green-600 text-white px-6 py-3 rounded-full font-heading font-semibold hover:bg-green-700 transition-all duration-300 transform hover:scale-105">
                                <span class="mr-2">📥</span>
                                Download ZIP File
                            </a>
                        </div>
                        @else
                        <div class="file-upload-area border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary transition-colors duration-300">
                            <div class="text-4xl mb-3">📁</div>
                            <label for="file-upload" class="cursor-pointer">
                                <span class="text-lg font-heading font-semibold text-text-dark mb-2 block">Upload Documents</span>
                                <span class="text-text-light font-body text-sm block mb-4">Please upload a ZIP file containing all your supporting documents</span>
                                <span class="upload-btn inline-flex items-center bg-primary text-white px-6 py-3 rounded-full font-heading font-semibold hover:bg-red-700 transition-all duration-300 transform hover:scale-105">
                                    <span class="mr-2">📤</span>
                                    Choose ZIP File
                                </span>
                            </label>
                            <input type="file" id="file-upload" name="file" accept=".zip" class="hidden" onchange="updateFileName(this)">
                            <div id="file-name" class="mt-3 text-sm text-text-light font-body"></div>
                        </div>
                        @error('file') 
                        <p class="error-message text-primary mt-2 text-sm font-body flex items-center">
                            <span class="mr-1">⚠️</span>{{ $message }}
                        </p> 
                        @enderror
                        @endif
                    </div>
                </div>

                <!-- Submit Button -->
                @if(!$soty)
                <div class="form-section">
                    <div class="text-center">
                        <button type="submit" 
                                class="submit-btn bg-primary text-white px-12 py-4 rounded-full font-heading font-bold text-lg shadow-lg hover:bg-red-700 hover:shadow-xl hover:shadow-primary/30 transform hover:scale-105 transition-all duration-300">
                            <span class="mr-2">🚀</span>
                            Submit Application
                        </button>
                        <p class="text-text-light font-body text-sm mt-4">
                            Please review all information before submitting. You cannot edit your application after submission.
                        </p>
                    </div>
                </div>
                @endif

            </div>
        </form>
    </div>

</main>

<!-- GSAP Animation Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Register GSAP plugins
    gsap.registerPlugin(ScrollTrigger);

    // Header Animations
    const headerTl = gsap.timeline();
    
    headerTl.from(".header-icon", {
        scale: 0,
        rotation: 180,
        duration: 0.8,
        ease: "back.out(1.7)"
    })
    .from(".header-title", {
        y: 50,
        opacity: 0,
        duration: 0.8,
        ease: "power3.out"
    }, "-=0.4")
    .from(".header-subtitle", {
        y: 30,
        opacity: 0,
        duration: 0.6,
        ease: "power2.out"
    }, "-=0.3");

    // Floating background elements
    gsap.to(".floating-bg", {
        y: -30,
        x: 20,
        rotation: 360,
        duration: 10,
        ease: "none",
        repeat: -1,
        stagger: 2
    });

    // Flash Messages Animation
    gsap.from(".flash-message", {
        x: -50,
        opacity: 0,
        duration: 0.6,
        ease: "power2.out",
        stagger: 0.2
    });

    // Form Container Animation
    gsap.from(".form-container", {
        y: 50,
        opacity: 0,
        duration: 0.8,
        ease: "power2.out",
        delay: 0.3
    });

    // Form Sections Animation
    gsap.from(".form-section", {
        y: 30,
        opacity: 0,
        duration: 0.6,
        stagger: 0.2,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".form-content",
            start: "top 80%",
            toggleActions: "play none none reverse"
        }
    });

    // Section Icons Animation
    gsap.from(".section-icon", {
        scale: 0,
        rotation: 360,
        duration: 0.6,
        stagger: 0.1,
        ease: "back.out(1.7)",
        scrollTrigger: {
            trigger: ".form-content",
            start: "top 70%",
            toggleActions: "play none none reverse"
        }
    });

    // Form Groups Animation
    gsap.from(".form-group", {
        y: 20,
        opacity: 0,
        duration: 0.5,
        stagger: 0.05,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".form-content",
            start: "top 60%",
            toggleActions: "play none none reverse"
        }
    });

    // Submit Button Animation
    gsap.from(".submit-btn", {
        scale: 0,
        rotation: 10,
        duration: 0.8,
        ease: "back.out(1.7)",
        scrollTrigger: {
            trigger: ".submit-btn",
            start: "top 90%",
            toggleActions: "play none none reverse"
        }
    });

    // Input Focus Effects
    document.querySelectorAll('.form-input').forEach(input => {
        if (!input.readOnly) {
            input.addEventListener('focus', function() {
                gsap.to(this, {
                    scale: 1.02,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });
            
            input.addEventListener('blur', function() {
                gsap.to(this, {
                    scale: 1,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });
        }
    });

    // Button Hover Effects
    document.querySelectorAll('.submit-btn, .download-btn, .upload-btn').forEach(button => {
        button.addEventListener('mouseenter', function() {
            gsap.to(this, {
                scale: 1.05,
                y: -2,
                duration: 0.3,
                ease: "power2.out"
            });
        });
        
        button.addEventListener('mouseleave', function() {
            gsap.to(this, {
                scale: 1,
                y: 0,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });

});

// File Upload Function
function updateFileName(input) {
    const fileName = document.getElementById('file-name');
    if (input.files.length > 0) {
        fileName.textContent = `Selected: ${input.files[0].name}`;
        fileName.classList.add('text-green-600');
    } else {
        fileName.textContent = '';
        fileName.classList.remove('text-green-600');
    }
}
</script>

<style>
/* Custom form styling */
.form-input:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(197, 1, 15, 0.1);
}

.file-upload-area:hover {
    background-color: rgba(197, 1, 15, 0.02);
}

/* Enhanced shadows */
.form-container {
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
}

.submit-btn:hover {
    box-shadow: 0 15px 30px rgba(197, 1, 15, 0.3);
}
</style>

@endsection