@extends('layouts.app')

@section('title', 'Register for Event | CampusConnect')

@section('content')

<!-- Page Header -->
<header class="page-header bg-gradient-to-r from-primary to-red-700 text-white py-16 lg:py-20 text-center relative overflow-hidden" id="register-header">

    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="floating-bg absolute top-10 left-10 w-32 h-32 bg-white rounded-full"></div>
        <div class="floating-bg absolute bottom-10 right-10 w-24 h-24 bg-white rounded-full"></div>
        <div class="floating-bg absolute top-1/2 right-1/4 w-16 h-16 bg-white rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="header-icon text-6xl mb-4">🎯</div>
        <h1 class="header-title text-3xl sm:text-4xl lg:text-5xl font-heading font-bold mb-4">
            Event <span class="text-yellow-300">Registration</span>
        </h1>
        <p class="header-subtitle text-lg sm:text-xl font-body leading-relaxed max-w-2xl mx-auto">
            Join {{ $event->event_name }} and be part of an amazing experience
        </p>
    </div>
</header>

<main class="register-main max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">

    <!-- Flash Messages -->
    @if(session('success'))
    <div id="successMessage" class="flash-message success-message bg-green-50 border-l-4 border-green-400 text-green-800 p-6 rounded-r-xl shadow-lg mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <span class="text-3xl mr-4">✅</span>
                <div>
                    <strong class="font-heading font-bold">Success!</strong>
                    <span class="block font-body mt-1">{{ session('success') }}</span>
                </div>
            </div>
            <button class="close-btn text-green-800 hover:text-green-900 text-2xl font-bold" onclick="this.parentElement.parentElement.style.display='none';">&times;</button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div id="errorMessage" class="flash-message error-message bg-red-50 border-l-4 border-primary text-red-800 p-6 rounded-r-xl shadow-lg mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <span class="text-3xl mr-4">❌</span>
                <div>
                    <strong class="font-heading font-bold">Oops!</strong>
                    <span class="block font-body mt-1">{{ session('error') }}</span>
                </div>
            </div>
            <button class="close-btn text-red-800 hover:text-red-900 text-2xl font-bold" onclick="this.parentElement.parentElement.style.display='none';">&times;</button>
        </div>
    </div>
    @endif

    @php
    use App\Models\EventRegistration;

    $alreadyRegistered = false;

    if (auth()->check()) {
    $userEnrolment = auth()->user()->enrolment_no;
    $alreadyRegistered = EventRegistration::where('event_id', $event->event_id)
    ->where('participant_enrolment', $userEnrolment)
    ->exists();
    }
    @endphp

    <!-- Event Details Section -->
    <div class="event-details-section bg-white rounded-2xl shadow-xl overflow-hidden mb-12">

        <!-- Event Header -->
        <div class="event-header bg-gradient-to-r from-primary/10 to-primary/20 p-6 lg:p-8 border-b border-gray-100">
            <h2 class="event-title text-3xl lg:text-4xl font-heading font-bold text-text-dark text-center">
                {{ $event->event_name }}
            </h2>
            <div class="event-type-badge mt-4 text-center">
                <span class="inline-flex items-center bg-primary text-white px-4 py-2 rounded-full text-sm font-semibold">
                    <span class="mr-2">
                        @if($event->type === 'outdoor') 🏟️
                        @elseif($event->type === 'indoor') 🏛️
                        @else 🎭
                        @endif
                    </span>
                    {{ ucfirst($event->type) }} Event
                </span>
            </div>
        </div>

        <!-- Carousel Section -->
        <div class="carousel-section p-6 lg:p-8">
            <div class="carousel-container relative w-full mb-6">
                <div id="carousel" class="overflow-hidden rounded-2xl shadow-lg">
                    <div class="carousel-track flex transition-transform duration-500 ease-in-out" style="transform: translateX(0%)">
                        @php
                        $carouselImages = collect([
                        $event->carousel_image_1,
                        $event->carousel_image_2,
                        $event->carousel_image_3,
                        $event->carousel_image_4,
                        $event->carousel_image_5,
                        ])->filter();
                        @endphp

                        @if($carouselImages->count())
                        @foreach($carouselImages as $img)
                        <img src="{{ asset('storage/' . $img) }}" class="carousel-image w-full h-64 lg:h-80 object-cover flex-shrink-0" alt="Event Image">
                        @endforeach
                        @else
                        <img src="{{ asset('storage/' . $event->thumbnail_image) }}" class="carousel-image w-full h-64 lg:h-80 object-cover flex-shrink-0" alt="Event Image">
                        @endif
                    </div>
                </div>

                <!-- Carousel Controls -->
                @if($carouselImages->count() > 1)
                <button id="prev" class="carousel-btn carousel-prev absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 backdrop-blur-sm rounded-full p-3 hover:bg-white shadow-lg transition-all duration-300 transform hover:scale-110">
                    <svg class="w-6 h-6 text-text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button id="next" class="carousel-btn carousel-next absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 backdrop-blur-sm rounded-full p-3 hover:bg-white shadow-lg transition-all duration-300 transform hover:scale-110">
                    <svg class="w-6 h-6 text-text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Carousel Indicators -->
                <div class="carousel-indicators absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    @foreach($carouselImages as $index => $img)
                    <button class="indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-300 {{ $index === 0 ? 'bg-white' : '' }}" data-slide="{{ $index }}"></button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Event Information Grid -->
            <div class="event-info-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                <!-- <div class="info-card bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center mb-2">
                        <span class="info-icon text-2xl mr-3">📅</span>
                        <span class="info-label font-heading font-semibold text-text-dark">Date</span>
                    </div>
                    <span class="info-value font-body text-text-light">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                </div>

                <div class="info-card bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center mb-2">
                        <span class="info-icon text-2xl mr-3">⏰</span>
                        <span class="info-label font-heading font-semibold text-text-dark">Time</span>
                    </div>
                    <span class="info-value font-body text-text-light">{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</span>
                </div>

                <div class="info-card bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center mb-2">
                        <span class="info-icon text-2xl mr-3">📍</span>
                        <span class="info-label font-heading font-semibold text-text-dark">Venue</span>
                    </div>
                    <span class="info-value font-body text-text-light">{{ $event->venue ?? 'TBD' }}</span>
                </div> -->

                <div class="info-card bg-gray-50 rounded-xl p-4 md:col-span-2 lg:col-span-1">
                    <div class="flex items-center mb-2">
                        <span class="info-icon text-2xl mr-3">{{ $event->is_group ? '👥' : '⭐' }}</span>
                        <span class="info-label font-heading font-semibold text-text-dark">Format</span>
                    </div>
                    <span class="info-value font-body text-text-light">{{ $event->is_group ? 'Group Event' : 'Solo Event' }}</span>
                </div>

                @if($event->is_group)
                <div class="info-card bg-gray-50 rounded-xl p-4 md:col-span-2">
                    <div class="flex items-center mb-2">
                        <span class="info-icon text-2xl mr-3">🔢</span>
                        <span class="info-label font-heading font-semibold text-text-dark">Max Team Size</span>
                    </div>
                    <span class="info-value font-body text-text-light">{{ $event->max_group_size }} participants</span>
                </div>
                @endif
                <div class="info-card bg-gray-50 rounded-xl p-4 md:col-span-2 lg:col-span-1">
    <div class="flex items-center mb-2">
        <span class="info-icon text-2xl mr-3">👤</span>
        <span class="info-label font-heading font-semibold text-text-dark">Coordinator</span>
    </div>
    @if($event->coordinators->isNotEmpty())
        <ul class="info-value font-body text-text-light space-y-1">
            @foreach($event->coordinators as $coord)
                <li>
                    {{ $coord->user->name ?? 'Unknown' }}
                    
                </li>
            @endforeach
        </ul>
    @else
        <span class="info-value font-body text-text-light">Not assigned yet</span>
    @endif
</div>

            </div>
            

            <!-- Event Description -->
            <div class="event-description mt-8 p-6 bg-gradient-to-r from-primary/5 to-primary/10 rounded-xl">
                <h3 class="description-title text-xl font-heading font-bold text-text-dark mb-3 flex items-center">
                    <span class="mr-3">📋</span>
                    Event Description
                </h3>
                <p class="description-text font-body text-text-light leading-relaxed">{{ $event->description }}</p>
            </div>
        </div>
    </div>

    <!-- Registration Status Sections -->
    @if(!$event->registration_open)
    <div class="status-section bg-red-50 border-l-4 border-red-500 rounded-r-xl p-8 text-center shadow-lg">
        <div class="status-icon text-6xl mb-4">🚫</div>
        <h3 class="status-title text-2xl font-heading font-bold text-red-700 mb-3">Registrations Closed</h3>
        <p class="status-text font-body text-red-600">Registrations for this event are currently closed. Please check back later or contact the organizers.</p>
    </div>
    @elseif($alreadyRegistered)
    <div class="status-section bg-yellow-50 border-l-4 border-yellow-500 rounded-r-xl p-8 text-center shadow-lg">
        <div class="status-icon text-6xl mb-4">🎉</div>
        <h3 class="status-title text-2xl font-heading font-bold text-yellow-700 mb-3">Already Registered!</h3>
        <p class="status-text font-body text-yellow-600 mb-6">You are already registered for this event. Thank you for registering!</p>
        <a href="{{ route('my.registrations') }}" class="view-registrations-btn bg-yellow-600 text-white px-6 py-3 rounded-full font-heading font-semibold hover:bg-yellow-700 transition-all duration-300 transform hover:scale-105">
            View My Registrations
        </a>
    </div>
    @else
    <!-- Registration Form -->
    <div class="registration-form-section bg-white rounded-2xl shadow-xl overflow-hidden">

        <!-- Form Header -->
        <div class="form-header bg-gradient-to-r from-primary/10 to-primary/20 p-6 lg:p-8 border-b border-gray-100">
            <h3 class="form-title text-2xl lg:text-3xl font-heading font-bold text-text-dark text-center">
                Register for "{{ $event->event_name }}"
            </h3>
            @if($event->is_group)
            <p class="form-subtitle text-text-light font-body text-center mt-3">
                Enter enrollment numbers for each participant (Max: {{ $event->max_group_size }})
            </p>
            <div class="leader-note bg-red-50 border border-red-200 rounded-lg p-4 mt-4">
                <p class="text-red-800 font-body text-sm"><strong>Note:</strong> The first enrollment number is fixed as the <strong>Group Leader</strong> (you).</p>
            </div>
            @endif
        </div>

        <form id="registrationForm" action="{{ route('event.register', $event->event_id) }}" method="POST" class="registration-form">
            @csrf

            <div class="form-content p-6 lg:p-8 space-y-6">

                @if($event->is_group)
                <!-- Group Registration Fields -->

                <!-- Leader Field -->
                <div class="participant-group">
                    <h4 class="group-title text-lg font-heading font-semibold text-text-dark mb-4 flex items-center">
                        <span class="mr-2">👑</span>
                        Group Leader
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Enrollment Number</label>
                            <input type="text" name="enrolment_numbers[]" value="{{ auth()->user()->enrolment_no }}"
                                class="form-input w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 text-text-dark font-body" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Name</label>
                            <input type="text" value="{{ auth()->user()->name }}"
                                class="form-input w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 text-text-dark font-body" readonly>
                        </div>
                    </div>
                </div>

                <!-- Team Members -->
                <div class="participant-group">
                    <h4 class="group-title text-lg font-heading font-semibold text-text-dark mb-4 flex items-center">
                        <span class="mr-2">👥</span>
                        Team Members
                    </h4>
                    @for($i = 2; $i <= $event->max_group_size; $i++)
                        <div class="member-row grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 p-4 bg-gray-50 rounded-xl">
                            <div class="form-group">
                                <label for="enrolment_{{ $i }}" class="form-label block font-heading font-semibold text-text-dark mb-2">
                                    Enrollment No. {{ $i }}
                                </label>
                                <input type="text" name="enrolment_numbers[]" id="enrolment_{{ $i }}"
                                    class="enrolment-input form-input w-full border border-gray-300 rounded-xl px-4 py-3 font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300 uppercase"
                                    placeholder="Enter enrollment number" required>
                            </div>
                            <div class="form-group">
                                <label for="name_{{ $i }}" class="form-label block font-heading font-semibold text-text-dark mb-2">Name</label>
                                <input type="text" name="names[]" id="name_{{ $i }}"
                                    class="name-input form-input w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-100 font-body text-text-dark"
                                    placeholder="Name will appear after verification" readonly>
                            </div>
                        </div>
                        @endfor
                </div>

                @else
                <!-- Solo Registration -->
                <div class="participant-group">
                    <h4 class="group-title text-lg font-heading font-semibold text-text-dark mb-4 flex items-center">
                        <span class="mr-2">⭐</span>
                        Participant Details
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Your Enrollment No.</label>
                            <input type="text" name="enrolment_number" value="{{ auth()->user()->enrolment_no }}"
                                class="form-input w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 text-text-dark font-body" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">Name</label>
                            <input type="text" value="{{ auth()->user()->name }}"
                                class="form-input w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 text-text-dark font-body" readonly>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="button" id="verifyBtn"
                        class="flex-1 bg-primary hover:bg-red-800 text-white py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Verify
                    </button>
                    <button type="button" id="registerBtn" disabled
                        class="flex-1 bg-gray-400 text-white py-3 px-6 rounded-lg transition-all duration-300 opacity-50 cursor-not-allowed flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Register
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif
</main>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            ease: "power2.out"
        });

        // Event Details Animation
        gsap.from(".event-details-section", {
            y: 50,
            opacity: 0,
            duration: 0.8,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".event-details-section",
                start: "top 80%",
                toggleActions: "play none none reverse"
            }
        });

        // Info Cards Animation
        gsap.from(".info-card", {
            y: 30,
            opacity: 0,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".event-info-grid",
                start: "top 80%",
                toggleActions: "play none none reverse"
            }
        });

        // Status Sections Animation
        gsap.from(".status-section", {
            scale: 0.9,
            opacity: 0,
            duration: 0.8,
            ease: "back.out(1.7)",
            scrollTrigger: {
                trigger: ".status-section",
                start: "top 80%",
                toggleActions: "play none none reverse"
            }
        });

        // Registration Form Animation
        gsap.from(".registration-form-section", {
            y: 50,
            opacity: 0,
            duration: 0.8,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".registration-form-section",
                start: "top 80%",
                toggleActions: "play none none reverse"
            }
        });

        // Form Groups Animation
        gsap.from(".participant-group", {
            y: 30,
            opacity: 0,
            duration: 0.6,
            stagger: 0.2,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".form-content",
                start: "top 70%",
                toggleActions: "play none none reverse"
            }
        });

        // Auto-hide flash messages
        setTimeout(() => {
            const successMsg = document.getElementById('successMessage');
            const errorMsg = document.getElementById('errorMessage');
            if (successMsg) gsap.to(successMsg, {
                opacity: 0,
                duration: 0.5,
                onComplete: () => successMsg.style.display = 'none'
            });
            if (errorMsg) gsap.to(errorMsg, {
                opacity: 0,
                duration: 0.5,
                onComplete: () => errorMsg.style.display = 'none'
            });
        }, 5000);

        // Carousel functionality
        const carousel = document.querySelector('.carousel-track');
        const slides = carousel?.children;
        const prev = document.getElementById('prev');
        const next = document.getElementById('next');
        const indicators = document.querySelectorAll('.indicator');
        let currentIndex = 0;

        function showSlide(index) {
            if (!carousel || !slides) return;
            currentIndex = (index + slides.length) % slides.length;
            gsap.to(carousel, {
                x: -currentIndex * 100 + '%',
                duration: 0.5,
                ease: "power2.inOut"
            });

            // Update indicators
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('bg-white', i === currentIndex);
                indicator.classList.toggle('bg-white/50', i !== currentIndex);
            });
        }

        prev?.addEventListener('click', () => showSlide(currentIndex - 1));
        next?.addEventListener('click', () => showSlide(currentIndex + 1));

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => showSlide(index));
        });

        // Auto-slide carousel
        if (slides && slides.length > 1) {
            setInterval(() => showSlide(currentIndex + 1), 5000);
        }

        // Form functionality with SweetAlert2
        const registerBtn = document.getElementById('registerBtn');
        const verifyBtn = document.getElementById('verifyBtn');
        const form = document.getElementById('registrationForm');

        // Collect inputs dynamically
        const enrolmentInputs = Array.from(document.querySelectorAll('.enrolment-input'));
        const nameInputs = Array.from(document.querySelectorAll('.name-input'));

        let verified = false;

        // Verification functionality with SweetAlert2
        verifyBtn?.addEventListener('click', async function() {
            verified = false;
            let allVerified = true;
            let emptyFields = [];
            let invalidEnrolments = [];

            // Show loading state on verify button
            const originalText = verifyBtn.innerHTML;
            verifyBtn.innerHTML = '<span class="mr-2">⏳</span> Verifying...';
            verifyBtn.disabled = true;

            // Reset all input styles
            enrolmentInputs.forEach(input => {
                if (!input.readOnly) {
                    input.classList.remove('border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50');
                }
            });

            // Check for empty fields first
            for (let i = 0; i < enrolmentInputs.length; i++) {
                if (enrolmentInputs[i].readOnly) continue;
                const enrolNo = enrolmentInputs[i].value.trim();
                if (!enrolNo) {
                    emptyFields.push(i + 1);
                }
            }

            if (emptyFields.length > 0) {
                // Show SweetAlert for empty fields
                await Swal.fire({
                    icon: 'warning',
                    title: 'Empty Fields',
                    html: `Please fill enrollment numbers for the following fields: <strong>${emptyFields.join(', ')}</strong>`,
                    confirmButtonColor: '#c5010f',
                    confirmButtonText: 'OK'
                });
                
                verifyBtn.innerHTML = originalText;
                verifyBtn.disabled = false;
                return;
            }

            // Verify each enrolment number
            for (let i = 0; i < enrolmentInputs.length; i++) {
                if (enrolmentInputs[i].readOnly) continue;
                const enrolNo = enrolmentInputs[i].value.trim();

                try {
                    const res = await fetch('{{ url("/get-student-details") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            enrolment_no: enrolNo
                        })
                    });

                    const response = await res.json();
                    if (response.success) {
                        nameInputs[i].value = response.data.full_name;
                        // Add green border to verified input
                        enrolmentInputs[i].classList.add('border-green-500', 'bg-green-50');
                    } else {
                        nameInputs[i].value = '';
                        allVerified = false;
                        invalidEnrolments.push(enrolNo);
                        enrolmentInputs[i].classList.add('border-red-500', 'bg-red-50');
                    }
                } catch (err) {
                    console.error(err);
                    nameInputs[i].value = '';
                    allVerified = false;
                    invalidEnrolments.push(enrolNo + ' (Network Error)');
                    enrolmentInputs[i].classList.add('border-red-500', 'bg-red-50');
                }
            }

            // Reset verify button
            verifyBtn.innerHTML = originalText;
            verifyBtn.disabled = false;

            if (invalidEnrolments.length > 0) {
                // Show SweetAlert for invalid enrolments
                await Swal.fire({
                    icon: 'error',
                    title: 'Verification Failed',
                    html: `The following enrollment numbers are invalid: <strong>${invalidEnrolments.join(', ')}</strong>`,
                    confirmButtonColor: '#c5010f',
                    confirmButtonText: 'OK'
                });
            }

            if (allVerified) {
                verified = true;
                registerBtn.disabled = false;
                
                // CHANGE REGISTER BUTTON TO RED - Visual feedback
                registerBtn.classList.remove('bg-gray-400', 'opacity-50', 'cursor-not-allowed');
                registerBtn.classList.add('bg-red-600', 'hover:bg-red-700', 'hover:shadow-lg', 'text-white');
                registerBtn.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Register Now
                `;
                
                // Add animation to register button
                gsap.to(registerBtn, {
                    scale: 1.05,
                    duration: 0.3,
                    yoyo: true,
                    repeat: 1
                });
                
                // SINGLE-CLICK REGISTRATION: Show success SweetAlert with direct registration option
                const result = await Swal.fire({
                    icon: 'success',
                    title: 'Verification Successful!',
                    html: 'All team members have been verified successfully!<br><br>Do you want to register now?',
                    showCancelButton: true,
                    confirmButtonColor: '#22c55e',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Register Now',
                    cancelButtonText: 'Review Details',
                    reverseButtons: true
                });

                if (result.isConfirmed) {
                    // Show loading state and submit form immediately
                    Swal.fire({
                        title: 'Processing Registration...',
                        text: 'Please wait while we register you for the event.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit the form automatically
                    form.submit();
                }
                
                console.log('Verification completed successfully');
            }
        });

        // Registration button with SweetAlert2 confirmation (for manual click)
        registerBtn?.addEventListener('click', async function() {
            if (verifyBtn && !verified) {
                await Swal.fire({
                    icon: 'warning',
                    title: 'Verification Required',
                    text: 'Please verify all enrollment numbers before registering.',
                    confirmButtonColor: '#c5010f',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // SweetAlert2 confirmation modal
            const result = await Swal.fire({
                title: 'Confirm Registration',
                html: `Are you sure you want to register for <strong>"{{ $event->event_name }}"</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#c5010f',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Register Now!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            });

            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Processing Registration...',
                    text: 'Please wait while we register you for the event.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit the form
                form.submit();
            }
        });

        // Button hover effects
        document.querySelectorAll('.verify-btn, .register-btn, .view-registrations-btn').forEach(button => {
            button.addEventListener('mouseenter', function() {
                if (!this.disabled) {
                    gsap.to(this, {
                        scale: 1.05,
                        y: -2,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                }
            });

            button.addEventListener('mouseleave', function() {
                if (!this.disabled) {
                    gsap.to(this, {
                        scale: 1,
                        y: 0,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                }
            });
        });

        // Input focus effects
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
    });
</script>

<style>
    /* Enhanced form styling */
    .form-input:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(197, 1, 15, 0.1);
    }

    /* Carousel styling */
    .carousel-btn:hover {
        background-color: white;
        transform: scale(1.1);
    }

    /* Enhanced shadows */
    .event-details-section,
    .registration-form-section,
    .status-section {
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
    }

    /* Smooth transitions */
    .carousel-track {
        transition: transform 0.5s ease-in-out;
    }

    /* SweetAlert2 Custom Styles */
    .swal2-confirm-btn {
        background-color: #c5010f !important;
        border: none !important;
        padding: 10px 24px !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
    }

    .swal2-cancel-btn {
        background-color: #6b7280 !important;
        border: none !important;
        padding: 10px 24px !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
    }
</style>
@endsection