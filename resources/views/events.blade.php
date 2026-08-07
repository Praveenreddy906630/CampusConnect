@extends('layouts.app')

@section('title', 'Events | Galore 2025')

@section('content')

<!-- Page Header -->
<header class="page-header bg-gradient-to-r from-primary to-red-700 text-white py-16 lg:py-20 text-center relative overflow-hidden w-full" id="events-header">

    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="floating-bg absolute top-10 left-10 w-32 h-32 bg-white rounded-full"></div>
        <div class="floating-bg absolute bottom-10 right-10 w-24 h-24 bg-white rounded-full"></div>
        <div class="floating-bg absolute top-1/2 right-1/4 w-16 h-16 bg-white rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h1 class="header-title text-4xl sm:text-5xl lg:text-6xl font-heading font-bold mb-6">
            Our <span class="text-yellow-300">Events</span>
        </h1>
        <p class="header-subtitle text-lg sm:text-xl lg:text-2xl font-body leading-relaxed max-w-2xl mx-auto">
            Explore sports, cultural and fun activities at Galore 2025
        </p>
    </div>
</header>

<main class="events-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">

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

    @php
    $types = [
    'outdoor' => [
    'title' => 'Outdoor Sports',
    'icon' => '🏟️',
    'description' => 'Feel the adrenaline rush in our exciting outdoor sporting competitions'
    ],
    'indoor' => [
    'title' => 'Indoor Sports',
    'icon' => '🏛️',
    'description' => 'Strategic thinking and precision in our competitive indoor games'
    ],
    'cultural' => [
    'title' => 'Cultural Events',
    'icon' => '🎭',
    'description' => 'Showcase your creativity through diverse cultural competitions'
    ]
    ];
    @endphp

    <!-- All Categories in One Row for Desktop -->
    <div class="categories-overview grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-6 mb-16">
        @foreach($types as $typeKey => $typeData)
        @php
        $filteredEvents = $events->where('type', $typeKey);
        @endphp

        @if($filteredEvents->count())
        <div class="category-preview bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center transform hover:-translate-y-2">
            <div class="category-icon text-4xl mb-3">{{ $typeData['icon'] }}</div>
            <h3 class="category-title text-xl lg:text-2xl font-heading font-bold text-text-dark mb-2">
                {{ $typeData['title'] }}
            </h3>
            <p class="category-description text-sm text-text-light font-body mb-4 leading-relaxed">
                {{ $typeData['description'] }}
            </p>
            <div class="event-count text-primary font-semibold text-sm mb-4">
                {{ $filteredEvents->count() }} {{ Str::plural('Event', $filteredEvents->count()) }}
            </div>
            <a href="/events#{{ $typeKey }}-section" target="_self" class="view-events-btn bg-primary text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-red-700 transition-all duration-300 transform hover:scale-105">
                View Events
            </a>
        </div>
        @endif
        @endforeach
    </div>

    @foreach($types as $typeKey => $typeData)
    @php
    $filteredEvents = $events->where('type', $typeKey);
    @endphp

    @if($filteredEvents->count())
    <section class="event-category-section mb-16 lg:mb-20" data-category="{{ $typeKey }}" id="{{ $typeKey }}-section">

        <!-- Category Header -->
        <div class="category-header text-center mb-12">
            <div class="category-icon text-5xl mb-3">{{ $typeData['icon'] }}</div>
            <h2 class="category-title text-2xl sm:text-3xl lg:text-4xl font-heading font-bold text-text-dark mb-4">
                {{ $typeData['title'] }}
            </h2>
            <div class="category-divider w-20 h-1 bg-primary mx-auto rounded-full mb-4"></div>
            <p class="category-description text-base sm:text-lg text-text-light font-body max-w-xl mx-auto leading-relaxed">
                {{ $typeData['description'] }}
            </p>
        </div>

        <!-- Events Grid -->
        <!-- <div class="events-grid grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @foreach($filteredEvents as $event)
            <div class="event-card bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2 group">

                <div class="event-image-container relative overflow-hidden">
                    @if($event->thumbnail_image)
                    <img src="{{ asset('storage/' . $event->thumbnail_image) }}"
                        alt="{{ $event->event_name }}"
                        class="event-image w-full h-40 object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                    <img src="https://source.unsplash.com/600x400/?{{ $event->type }},sports"
                        alt="{{ $event->event_name }}"
                        class="event-image w-full h-40 object-cover transition-transform duration-500 group-hover:scale-110">
                    @endif

                    <div class="image-overlay absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="category-badge absolute top-3 left-3 bg-primary text-white px-2 py-1 rounded-full text-xs font-semibold">
                        {{ ucfirst($event->type) }}
                    </div>
                </div>

                <div class="event-content p-4">
                    <h3 class="event-title text-lg font-heading font-bold text-text-dark mb-2 group-hover:text-primary transition-colors duration-300">
                        {{ $event->event_name }}
                    </h3>

                    <p class="event-description text-text-light font-body mb-3 leading-relaxed line-clamp-2 text-sm">
                        {{ $event->description }}
                    </p>

                    <div class="event-details space-y-1 mb-4">
                        <div class="detail-item flex items-center text-xs text-text-light">
                            <span class="detail-icon w-4 h-4 mr-2 text-primary">📍</span>
                            <span class="font-body">{{ $event->venue ?? 'Venue TBD' }}</span>
                        </div>
                        <div class="detail-item flex items-center text-xs text-text-light">
                            <span class="detail-icon w-4 h-4 mr-2 text-primary">📅</span>
                            <span class="font-body">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                        </div>
                        <div class="detail-item flex items-center text-xs text-text-light">
                            <span class="detail-icon w-4 h-4 mr-2 text-primary">⏰</span>
                            <span class="font-body">{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('event.register', $event->event_id) }}"
                        class="register-btn block text-center bg-primary text-white py-2 px-4 rounded-full font-heading font-semibold text-sm hover:bg-red-700 hover:shadow-lg hover:shadow-primary/30 transform hover:scale-105 transition-all duration-300">
                        Register Now
                    </a>
                </div>
            </div>
            @endforeach
        <div class="events-grid grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

            @foreach($filteredEvents as $event)
            <div class="event-card bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2 group">

                <!-- Event Image -->
                <div class="event-image-container relative overflow-hidden h-48 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center shrink-0">
                    @if($event->thumbnail_image)
                    <img src="{{ asset('storage/' . $event->thumbnail_image) }}"
                        alt="{{ $event->event_name }}"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        class="event-image absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 z-10">
                    <!-- Fallback Content (Hidden initially if image exists) -->
                    <div class="fallback-content hidden absolute inset-0 flex-col items-center justify-center text-white/50 z-0">
                        <span class="text-4xl mb-2">📸</span>
                        <span class="text-sm font-semibold px-4 text-center">{{ Str::limit($event->event_name, 30) }}</span>
                    </div>
                    @else
                    <!-- Fallback Content (Always visible) -->
                    <div class="fallback-content absolute inset-0 flex flex-col items-center justify-center text-white/50 z-0">
                        <span class="text-4xl mb-2">📸</span>
                        <span class="text-sm font-semibold px-4 text-center">{{ Str::limit($event->event_name, 30) }}</span>
                    </div>
                    @endif

                    <!-- Image Overlay -->
                    <div class="image-overlay absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <!-- Category Badge -->
                    <div class="category-badge absolute top-3 left-3 bg-primary text-white px-3 py-1 rounded-full text-xs font-semibold shadow z-30">
                        {{ ucfirst($event->type) }}
                    </div>
                </div>

                <!-- Event Content -->
                <div class="event-content p-5 flex flex-col flex-1 bg-white relative z-30">
                    <div class="flex-1">
                        <h3 class="event-title text-lg font-heading font-bold text-text-dark mb-3 group-hover:text-primary transition-colors duration-300 line-clamp-1" title="{{ $event->event_name }}">
                            {{ $event->event_name }}
                        </h3>

                        <!-- Key Metadata Grid -->
                        <div class="event-details grid grid-cols-2 gap-y-2 gap-x-2 mb-3">
                            <div class="detail-item flex items-center text-xs text-text-light">
                                <span class="w-4 h-4 mr-1.5 flex-shrink-0 text-primary">📅</span>
                                <span class="font-body line-clamp-1 text-gray-700 font-medium">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="detail-item flex items-center text-xs text-text-light">
                                <span class="w-4 h-4 mr-1.5 flex-shrink-0 text-primary">⏰</span>
                                <span class="font-body line-clamp-1 text-gray-700 font-medium">{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</span>
                            </div>
                            <div class="detail-item flex items-center text-xs text-text-light">
                                <span class="w-4 h-4 mr-1.5 flex-shrink-0 text-primary">📍</span>
                                <span class="font-body line-clamp-1 text-gray-700 font-medium" title="{{ $event->venue }}">{{ $event->venue ?? 'TBD' }}</span>
                            </div>
                            <div class="detail-item flex items-center text-xs text-text-light">
                                <span class="w-4 h-4 mr-1.5 flex-shrink-0 text-primary">👥</span>
                                <span class="font-body line-clamp-1 text-gray-700 font-medium">{{ $event->max_participants ?? 'Unlimited' }} Seats</span>
                            </div>
                        </div>

                        <!-- Organizer -->
                        <div class="organizer flex items-center text-xs text-text-light mb-3">
                             <span class="w-4 h-4 mr-1.5 flex-shrink-0 text-primary">🏢</span>
                             <span class="font-body line-clamp-1 font-semibold text-gray-800">
                                @if(isset($event->coordinators) && $event->coordinators->count() > 0)
                                    {{ $event->coordinators->first()->name }}
                                @else
                                    CampusConnect
                                @endif
                             </span>
                        </div>

                        <p class="event-description text-gray-500 font-body mb-4 leading-relaxed line-clamp-2 text-xs md:text-sm">
                            {{ $event->description }}
                        </p>
                    </div>

                    <!-- Register Button & Status Footer -->
                    <div class="event-footer flex items-center justify-between mt-auto border-t border-gray-100 pt-4">
                        <div class="registration-status">
                            @if($event->registration_open)
                            <span class="inline-flex items-center text-green-600 text-xs font-semibold">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5 shadow-sm shadow-green-200"></span>Open
                            </span>
                            @else
                            <span class="inline-flex items-center text-red-600 text-xs font-semibold">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-1.5 shadow-sm shadow-red-200"></span>Closed
                            </span>
                            @endif
                        </div>

                        @if($event->registration_open)
                        <a href="{{ route('event.register', $event->event_id) }}"
                            class="register-btn text-center bg-primary text-white py-2 px-5 rounded-full font-heading font-bold text-xs hover:bg-red-700 hover:shadow-lg hover:shadow-primary/30 transform hover:scale-105 transition-all duration-300">
                            Register Now →
                        </a>
                        @endif
                    </div>
                </div>

            </div>
            @endforeach

        </div>

        <!-- Category Footer -->
        <div class="category-footer text-center mt-8">
            <p class="text-text-light font-body text-sm">
                <span class="text-primary font-semibold">{{ $filteredEvents->count() }}</span>
                {{ Str::plural('event', $filteredEvents->count()) }} available in {{ $typeData['title'] }}
            </p>
        </div>

    </section>
    @endif
    @endforeach


</main>

<!-- GSAP Animation Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Register GSAP plugins
        gsap.registerPlugin(ScrollTrigger);

        // Set default preferences for better performance
        gsap.defaults({
            ease: "power2.out"
        });

        // Remove initial hiding of elements - let ScrollTrigger handle it
        // Only set will-change for performance
        gsap.set([".header-title", ".header-subtitle", ".category-preview",
            ".event-card", ".category-icon", ".category-title",
            ".category-divider", ".category-description", ".category-footer",
            ".cta-title", ".cta-subtitle", ".btn-primary", ".btn-secondary"
        ], {
            willChange: "transform, opacity"
        });

        // Header Animations
        const headerTl = gsap.timeline();

        headerTl.from(".header-title", {
                y: 80,
                opacity: 0,
                duration: 1.2,
                ease: "power3.out"
            })
            .from(".header-subtitle", {
                y: 40,
                opacity: 0,
                duration: 1,
                ease: "power2.out"
            }, "-=0.7");

        // Floating background elements
        gsap.to(".floating-bg", {
            y: -30,
            x: 20,
            rotation: 360,
            duration: 15,
            ease: "sine.inOut",
            repeat: -1,
            yoyo: true,
            stagger: {
                amount: 3,
                from: "random"
            }
        });

        // Category Preview Cards Animation
        gsap.from(".category-preview", {
            opacity: 1,
            duration:0.5,
            stagger: 0.15,
            force3D: true,
            scrollTrigger: {
                trigger: ".categories-overview",
                start: "top 85%",
                end: "bottom 20%",
                markers: false
            }
        });

        // FIXED category section animations - removed initial hiding
        gsap.utils.toArray('.event-category-section').forEach((section, index) => {
            // Master timeline for each section
            const sectionTl = gsap.timeline({
                scrollTrigger: {
                    trigger: section,
                    start: "top 85%", // Increased from 80% to trigger earlier
                    end: "bottom 15%",
                    toggleActions: "play play none reverse", // FIX: play on enter and re-enter
                    markers: false,
                    invalidateOnRefresh: true // Ensures recalculation on resize
                }
            });

            // Category Icon 
            sectionTl.from(section.querySelector('.category-icon'), {
                scale: 0,
                rotation: 180,
                opacity: 0,
                duration:0.5,
                ease: "back.out(1.7)"
            });

            // Category Title
            sectionTl.from(section.querySelector('.category-title'), {
                y: 40,
                opacity: 0,
                duration:0.5,
                ease: "power2.out"
            }, "-=0.3");

            // Category Divider
            sectionTl.from(section.querySelector('.category-divider'), {
                scaleX: 0,
                opacity: 0,
                duration:0.5,
                ease: "power2.out"
            }, "-=0.4");

            // Category Description
            sectionTl.from(section.querySelector('.category-description'), {
                y: 20,
                opacity: 0,
                duration: 0.6,
                ease: "power2.out"
            }, "-=0.2");

            // Event Cards Animation 
            // const eventCards = section.querySelectorAll('.event-card');
            // sectionTl.fromTo(eventCards, {
            //     y: 50,
            //     opacity: 0
            // }, {
            //     y: 0,
            //     opacity: 1,
            //     duration: 0.2,
            //     stagger: {
            //         amount: 0.6,
            //         from: "start"
            //     },
            //     ease: "power2.out"
            // }, "-=0.2");

            // Category Footer
            sectionTl.from(section.querySelector('.category-footer'), {
                y: 20,
                opacity: 0,
                duration: 0.6,
                ease: "power2.out"
            }, "+=0.2");
        });

        // // CTA Section Animation 
        // const ctaTl = gsap.timeline({
        //     scrollTrigger: {
        //         trigger: ".events-cta",
        //         start: "top 85%",
        //         toggleActions: "play play none reverse", // FIX: play on enter and re-enter
        //         markers: false
        //     }
        // });

        // ctaTl.from(".cta-title", {
        //         y: 30,
        //         opacity: 0,
        //         duration:0.5
        //     })
        //     .from(".cta-subtitle", {
        //         y: 20,
        //         opacity: 0,
        //         duration: 0.6
        //     }, "-=0.3")
        //     .from(".btn-primary, .btn-secondary", {
        //         y: 20,
        //         opacity: 0,
        //         duration: 0.6,
        //         stagger: 0.15,
        //         ease: "back.out(1.7)"
        //     }, "-=0.2");

        // Refresh ScrollTrigger after all animations are set up
        setTimeout(() => {
            ScrollTrigger.refresh();
        }, 100);

        // Optimized hover effects
        let hoverTimeout;

        const createHoverHandler = (element, yValue = -5) => {
            return function() {
                clearTimeout(hoverTimeout);
                gsap.killTweensOf(this);
                gsap.to(this, {
                    y: yValue,
                    duration: 0.3,
                    ease: "power2.out"
                });
            };
        };

        const createLeaveHandler = () => {
            return function() {
                hoverTimeout = setTimeout(() => {
                    gsap.killTweensOf(this);
                    gsap.to(this, {
                        y: 0,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                }, 50);
            };
        };

        // Card Hover Enhancements
        document.querySelectorAll('.event-card, .category-preview').forEach(card => {
            card.addEventListener('mouseenter', createHoverHandler(card, -5));
            card.addEventListener('mouseleave', createLeaveHandler());
        });

        // Button Hover Effects
        document.querySelectorAll('.register-btn, .view-events-btn, .btn-primary, .btn-secondary').forEach(button => {
            button.addEventListener('mouseenter', function() {
                gsap.killTweensOf(this);
                gsap.to(this, {
                    scale: 1.05,
                    duration: 0.2,
                    ease: "power2.out"
                });
            });

            button.addEventListener('mouseleave', function() {
                gsap.killTweensOf(this);
                gsap.to(this, {
                    scale: 1,
                    duration: 0.2,
                    ease: "power2.out"
                });
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    gsap.to(window, {
                        duration: 1.2,
                        scrollTo: {
                            y: target,
                            offsetY: 80,
                            autoKill: true
                        },
                        ease: "power2.inOut"
                    });
                }
            });
        });

        // Handle page resize and load events
        window.addEventListener('load', function() {
            ScrollTrigger.refresh();
        });

        window.addEventListener('resize', function() {
            ScrollTrigger.refresh();
        });

    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Select all internal links that start with #
    const scrollLinks = document.querySelectorAll('a[href^="#"]');
    
    scrollLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            const targetId = this.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                e.preventDefault(); // stop normal anchor behavior
                // Smooth scroll to the target section
                window.scrollTo({
                    top: targetElement.offsetTop - 80, // adjust for header height
                    behavior: "smooth"
                });
            }
        });
    });
});
</script>


<style>
    /* Line clamp utility for text truncation */
    .line-clamp-2 {
        display: -webkit-box;
        --webkit-line-clamp: 2;
        --webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Enhanced shadow effects */
    .event-card:hover,
    .category-preview:hover {
        box-shadow: 0 15px 30px rgba(197, 1, 15, 0.1);
    }
    html {
    scroll-behavior: smooth; /* fallback for modern browsers */
}
</style>

@endsection