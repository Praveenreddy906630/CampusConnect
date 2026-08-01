@extends('layouts.app')

@section('title', 'Event Coordinators | CampusConnect')

@section('content')

<!-- Page Header -->
<header class="page-header bg-gradient-to-r from-primary to-red-700 text-white py-16 lg:py-20 text-center relative overflow-hidden" id="coordinator-header">

    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="floating-bg absolute top-10 left-10 w-32 h-32 bg-white rounded-full"></div>
        <div class="floating-bg absolute bottom-10 right-10 w-24 h-24 bg-white rounded-full"></div>
        <div class="floating-bg absolute top-1/2 right-1/4 w-16 h-16 bg-white rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="header-icon text-6xl mb-4">👤</div>
        <h1 class="header-title text-3xl sm:text-4xl lg:text-5xl font-heading font-bold mb-4">
            Coordinator <span class="text-yellow-300">Profile</span>
        </h1>
        <p class="header-subtitle text-lg sm:text-xl font-body leading-relaxed max-w-2xl mx-auto">
            Meet your dedicated event coordinator
        </p>
    </div>
</header>

<main class="coordinator-main max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">

    <!-- Coordinator Profile Section -->
    <div class="profile-section bg-white rounded-2xl shadow-xl overflow-hidden mb-12">

        <!-- Profile Header -->
        <div class="profile-header bg-gradient-to-r from-primary/10 to-primary/20 p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row items-center lg:items-start space-y-6 lg:space-y-0 lg:space-x-8">

                <!-- Profile Image -->
                <div class="profile-image-container relative">
                    @if($coordinator->profile_pic)
                    <img src="{{ asset('storage/'.$coordinator->profile_pic) }}"
                        alt="{{ $coordinator->user->name }}"
                        class="profile-image w-32 h-32 lg:w-40 lg:h-40 object-cover rounded-full border-4 border-white shadow-xl">
                    @else
                    <div class="profile-placeholder w-32 h-32 lg:w-40 lg:h-40 rounded-full bg-gradient-to-br from-primary/30 to-primary/50 border-4 border-white shadow-xl flex items-center justify-center">
                        <span class="text-4xl lg:text-5xl font-heading font-bold text-white">
                            {{ substr($coordinator->user->name, 0, 1) }}
                        </span>
                    </div>
                    @endif

                    <!-- Status Badge -->
                    <!-- <div class="status-badge absolute -bottom-2 -right-2 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                        <span class="status-dot w-2 h-2 bg-green-300 rounded-full inline-block mr-1 animate-pulse"></span>
                        Active
                    </div> -->
                </div>

                <!-- Profile Info -->
                <div class="profile-info flex-1 text-center lg:text-left">
                    <h1 class="coordinator-name text-3xl lg:text-4xl font-heading font-bold text-text-dark mb-3">
                        {{ $coordinator->user->name }}
                    </h1>

                    <div class="coordinator-details space-y-3">
                        <div class="detail-item flex items-center justify-center lg:justify-start text-text-light">
                            <span class="detail-icon w-5 h-5 mr-3 text-primary">📧</span>
                            <span class="font-body">{{ $coordinator->user->email }}</span>
                        </div>

                        <div class="detail-item flex items-center justify-center lg:justify-start text-text-light">
                            <span class="detail-icon w-5 h-5 mr-3 text-primary">📱</span>
                            <span class="font-body">{{ $coordinator->mobile }}</span>
                        </div>

                        @if($coordinator->ext)
                        <div class="detail-item flex items-center justify-center lg:justify-start text-text-light">
                            <span class="detail-icon w-5 h-5 mr-3 text-primary">📞</span>
                            <span class="font-body">Ext: {{ $coordinator->ext }}</span>
                        </div>
                        @endif

                        <div class="detail-item flex items-center justify-center lg:justify-start text-text-light">
                            <span class="detail-icon w-5 h-5 mr-3 text-primary">🏫</span>
                            <span class="font-body">{{ $coordinator->school }}</span>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="quick-stats flex justify-center lg:justify-start space-x-6 mt-6">
                        <div class="stat-item text-center">
                            <div class="stat-number text-2xl font-heading font-bold text-primary">{{ $coordinator->events->count() }}</div>
                            <div class="stat-label text-xs text-text-light font-body">Events</div>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-number text-2xl font-heading font-bold text-primary">
                                {{ $coordinator->events->pluck('type')->unique()->count() }}
                            </div>
                            <div class="stat-label text-xs text-text-light font-body">Categories</div>
                        </div>
                        <!-- <div class="stat-item text-center">
                            <div class="stat-number text-2xl font-heading font-bold text-primary">
                                {{ $coordinator->events->where('registration_open', true)->count() }}
                            </div>
                            <div class="stat-label text-xs text-text-light font-body">Active</div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Actions -->
        <div class="contact-actions p-6 bg-gray-50 border-t border-gray-100">
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="mailto:{{ $coordinator->user->email }}"
                    class="contact-btn bg-primary text-white px-6 py-3 rounded-xl font-heading font-semibold text-center hover:bg-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <span class="mr-2">📧</span>
                    Send Email
                </a>
                <a href="tel:{{ $coordinator->mobile }}"
                    class="contact-btn bg-blue-600 text-white px-6 py-3 rounded-xl font-heading font-semibold text-center hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <span class="mr-2">📱</span>
                    Call Now
                </a>
                <a href="{{ url('/coordinators') }}"
                    class="contact-btn bg-gray-600 text-white px-6 py-3 rounded-xl font-heading font-semibold text-center hover:bg-gray-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <span class="mr-2">👥</span>
                    All Coordinators
                </a>
            </div>
        </div>
    </div>

    <!-- Events Section -->
    <div class="events-section">
        <div class="section-header text-center mb-12">
            <h2 class="section-title text-3xl lg:text-4xl font-heading font-bold text-text-dark mb-4">
                Coordinated <span class="text-primary">Events</span>
            </h2>
            <div class="section-divider w-24 h-1 bg-primary mx-auto rounded-full mb-6"></div>
            <p class="section-subtitle text-lg text-text-light font-body max-w-2xl mx-auto">
                Events managed and organized by {{ $coordinator->user->name }}
            </p>
        </div>

        @if($coordinator->events->count() > 0)
        <!-- Events Stats -->
        <div class="events-stats grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
            @php
            $eventTypes = $coordinator->events->groupBy('type');
            @endphp

            @foreach(['outdoor' => ['icon' => '🏟️', 'name' => 'Outdoor'], 'indoor' => ['icon' => '🏛️', 'name' => 'Indoor'], 'cultural' => ['icon' => '🎭', 'name' => 'Cultural']] as $type => $info)
            <div class="event-type-stat bg-white rounded-xl shadow-lg p-6 text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="stat-icon text-3xl mb-3">{{ $info['icon'] }}</div>
                <div class="stat-number text-2xl font-heading font-bold text-primary mb-1">
                    {{ $eventTypes->get($type, collect())->count() }}
                </div>
                <div class="stat-label text-text-light font-body text-sm">{{ $info['name'] }} Events</div>
            </div>
            @endforeach
        </div>

        <!-- Events Grid -->
        <div class="events-grid grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            @foreach($coordinator->events as $event)
            <div class="event-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2 group">

                <!-- Event Header -->
                <div class="event-header p-6 pb-4">
                    <div class="flex items-start justify-between mb-4">
                        <div class="event-type-badge">
                            <span class="inline-flex items-center bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-semibold">
                                @if($event->type === 'outdoor') 🏟️
                                @elseif($event->type === 'indoor') 🏛️
                                @else 🎭
                                @endif
                                {{ ucfirst($event->type) }}
                            </span>
                        </div>

                        <!-- <div class="registration-status">
                            @if($event->registration_open)
                            <span class="status-badge bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                                <span class="w-2 h-2 bg-green-500 rounded-full inline-block mr-1"></span>
                                Open
                            </span>
                            @else
                            <span class="status-badge bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">
                                <span class="w-2 h-2 bg-red-500 rounded-full inline-block mr-1"></span>
                                Closed
                            </span>
                            @endif
                        </div> -->
                    </div>

                    <h3 class="event-title text-xl font-heading font-bold text-text-dark mb-3 group-hover:text-primary transition-colors duration-300">
                        {{ $event->event_name }}
                    </h3>

                    <p class="event-description text-text-light font-body leading-relaxed line-clamp-2">
                        {{ $event->description }}
                    </p>
                </div>

                <!-- Event Details -->
                <div class="event-details px-6 pb-4">
                    <div class="details-grid space-y-3">
                        <!-- <div class="detail-row flex items-center text-sm text-text-light">
                            <span class="detail-icon w-5 h-5 mr-3 text-primary">📍</span>
                            <span class="font-body">{{ $event->venue ?? 'Venue TBD' }}</span>
                        </div>

                        <div class="detail-row flex items-center text-sm text-text-light">
                            <span class="detail-icon w-5 h-5 mr-3 text-primary">📅</span>
                            <span class="font-body">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                        </div>

                        <div class="detail-row flex items-center text-sm text-text-light">
                            <span class="detail-icon w-5 h-5 mr-3 text-primary">⏰</span>
                            <span class="font-body">{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</span>
                        </div> -->

                        @if($event->is_group)
                        <div class="detail-row flex items-center text-sm text-text-light">
                            <span class="detail-icon w-5 h-5 mr-3 text-primary">👥</span>
                            <span class="font-body">Group Event (Max: {{ $event->max_group_size }})</span>
                        </div>
                        @else
                        <div class="detail-row flex items-center text-sm text-text-light">
                            <span class="detail-icon w-5 h-5 mr-3 text-primary">⭐</span>
                            <span class="font-body">Solo Event</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Event Footer -->
                <div class="event-footer bg-gray-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        @if($event->registration_open)
                        <div class="flex-1">
                            <!-- Optional left side content -->
                            {{--
            <div class="registrations-count text-sm text-text-light">
                <span class="mr-1">👤</span>
                {{ $event->registrations->count() }} registered
                        </div>
                        --}}
                    </div>
                    <a href="{{ route('event.register', $event->event_id) }}"
                        class="register-link text-primary hover:text-red-700 font-semibold text-sm transition-colors duration-300 ml-auto">
                        Register Now →
                    </a>
                    @else
                    <!-- If registration closed, you can optionally show something else -->
                    <span class="text-sm text-text-light">Registration Closed</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @else
    <!-- No Events State -->
    <div class="no-events text-center py-16">
        <div class="no-events-icon text-8xl mb-6">📅</div>
        <h3 class="no-events-title text-2xl font-heading font-bold text-text-dark mb-4">
            No Events Assigned
        </h3>
        <p class="no-events-subtitle text-lg text-text-light font-body max-w-md mx-auto leading-relaxed">
            This coordinator doesn't have any events assigned yet.
        </p>
    </div>
    @endif
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

        // Profile Section Animation
        gsap.from(".profile-section", {
            y: 50,
            opacity: 0,
            duration: 0.8,
            ease: "power2.out",
            delay: 0.3
        });

        // Profile Image Animation
        gsap.from(".profile-image, .profile-placeholder", {
            scale: 0,
            rotation: 180,
            duration: 0.8,
            ease: "back.out(1.7)",
            delay: 0.5
        });

        // Profile Info Animation
        gsap.from(".coordinator-name", {
            x: -50,
            opacity: 0,
            duration: 0.8,
            ease: "power2.out",
            delay: 0.7
        });

        gsap.from(".detail-item", {
            x: -30,
            opacity: 0,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out",
            delay: 0.9
        });

        gsap.from(".stat-item", {
            y: 20,
            opacity: 0,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out",
            delay: 1.1
        });

        // Contact Actions Animation
        gsap.from(".contact-btn", {
            y: 30,
            opacity: 0,
            duration: 0.6,
            stagger: 0.1,
            ease: "back.out(1.7)",
            delay: 1.3
        });

        // Events Section Animation
        gsap.from(".section-title", {
            y: 40,
            opacity: 0,
            duration: 0.8,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".events-section",
                start: "top 80%",
                toggleActions: "play none none reverse"
            }
        });

        gsap.from(".section-divider", {
            scaleX: 0,
            duration: 0.8,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".events-section",
                start: "top 75%",
                toggleActions: "play none none reverse"
            }
        });

        gsap.from(".section-subtitle", {
            y: 20,
            opacity: 0,
            duration: 0.6,
            ease: "power2.out",
            delay: 0.3,
            scrollTrigger: {
                trigger: ".events-section",
                start: "top 75%",
                toggleActions: "play none none reverse"
            }
        });

        // Events Stats Animation
        gsap.from(".event-type-stat", {
            opacity: 1,
            duration: 0.8,
            stagger: 0.2,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".events-stats",
                start: "top 80%",
                toggleActions: "play none none reverse"
            }
        });

        // Event Cards Animation
        gsap.from(".event-card", {
            y: 60,
            opacity: 1,
            duration: 0.8,
            stagger: 0.2,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".events-grid",
                start: "top 80%",
                toggleActions: "play none none reverse"
            }
        });

        // No Events Animation
        if (document.querySelector('.no-events')) {
            gsap.from(".no-events-icon", {
                scale: 0,
                rotation: 180,
                duration: 1,
                ease: "back.out(1.7)",
                scrollTrigger: {
                    trigger: ".no-events",
                    start: "top 80%",
                    toggleActions: "play none none reverse"
                }
            });

            gsap.from(".no-events-title", {
                y: 30,
                opacity: 0,
                duration: 0.8,
                ease: "power2.out",
                delay: 0.3,
                scrollTrigger: {
                    trigger: ".no-events",
                    start: "top 80%",
                    toggleActions: "play none none reverse"
                }
            });

            gsap.from(".no-events-subtitle", {
                y: 20,
                opacity: 0,
                duration: 0.6,
                ease: "power2.out",
                delay: 0.5,
                scrollTrigger: {
                    trigger: ".no-events",
                    start: "top 80%",
                    toggleActions: "play none none reverse"
                }
            });
        }

        // Card Hover Effects
        document.querySelectorAll('.event-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                gsap.to(this, {
                    y: -8,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            card.addEventListener('mouseleave', function() {
                gsap.to(this, {
                    y: 0,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });
        });

        // Button Hover Effects
        document.querySelectorAll('.contact-btn').forEach(button => {
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
</script>

<style>
    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Enhanced shadows */
    .profile-section,
    .event-card {
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
    }

    .event-card:hover {
        box-shadow: 0 30px 60px rgba(197, 1, 15, 0.1);
    }

    /* Status badge animation */
    .status-dot {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.7;
        }
    }

    /* Contact button effects */
    .contact-btn:hover {
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }
</style>

@endsection