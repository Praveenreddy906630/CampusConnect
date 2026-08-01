@extends('layouts.app')

@section('title', 'Event Coordinators | CampusConnect')

@section('content')

<!-- Page Header -->
<header class="page-header bg-gradient-to-r from-primary to-red-700 text-white py-16 lg:py-20 text-center relative overflow-hidden" id="coordinators-header">
    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="floating-bg absolute top-10 left-10 w-32 h-32 bg-white rounded-full"></div>
        <div class="floating-bg absolute bottom-10 right-10 w-24 h-24 bg-white rounded-full"></div>
        <div class="floating-bg absolute top-1/2 right-1/4 w-16 h-16 bg-white rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="header-icon text-6xl mb-4">👥</div>
        <h1 class="header-title text-3xl sm:text-4xl lg:text-5xl font-heading font-bold mb-4">
            Event <span class="text-yellow-300">Coordinators</span>
        </h1>
        <p class="header-subtitle text-lg sm:text-xl font-body leading-relaxed max-w-2xl mx-auto">
            Meet the dedicated team members organizing and managing CampusConnect events
        </p>
    </div>
</header>

<main class="coordinators-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
    @if($coordinators->isEmpty())
    <!-- Empty State -->
    <div class="empty-state text-center py-16">
        <div class="empty-icon text-8xl mb-6">👤</div>
        <h2 class="empty-title text-2xl sm:text-3xl font-heading font-bold text-text-dark mb-4">
            No Coordinators Found
        </h2>
        <p class="empty-subtitle text-lg text-text-light font-body max-w-md mx-auto leading-relaxed">
            Event coordinators information will be available soon.
        </p>
    </div>
    @else
    <!-- Coordinators Grid -->
    <div class="coordinators-grid grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8" id="coordinatorsGrid">
        @foreach($coordinators as $coordinator)
        <div class="coordinator-card-wrapper">
            <a href="{{ route('coordinators.show', $coordinator->coordinator_id) }}"
                class="coordinator-card block bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group h-full flex flex-col"
                data-name="{{ strtolower($coordinator->user->name) }}"
                data-school="{{ strtolower($coordinator->school) }}"
                data-events="{{ strtolower($coordinator->events->pluck('event_name')->join(' ')) }}">

                <!-- Events Section (Top, Highly Highlighted) -->
                <div class="events-section bg-gradient-to-r from-primary/30 to-red-300 px-4 sm:px-6 py-4 sm:py-6 rounded-t-2xl flex-1">
                    <div class="events-header flex items-center mb-3 sm:mb-4">
                        <span class="events-icon text-xl sm:text-2xl mr-2 animate-bounce">🎯</span>
                        <span class="events-label font-heading font-bold text-text-dark text-sm sm:text-base">
                            Coordinating Events
                        </span>
                    </div>

                    @if($coordinator->events->count() > 0)
                    <div class="events-list grid grid-cols-1 gap-2 sm:gap-3">
                        @foreach($coordinator->events as $event)
                        <div class="event-item flex items-center justify-between bg-white rounded-lg sm:rounded-xl px-3 py-2 sm:px-4 sm:py-3 shadow-sm hover:shadow-md transition-all duration-300 group">
                            <!-- Event Name -->
                            <span class="event-name font-heading font-bold text-text-dark text-xs sm:text-sm md:text-base group-hover:text-primary transition-colors duration-300 truncate">
                                {{ $event->event_name }}
                            </span>

                            <!-- Event Type Badge -->
                            <span class="event-type text-xs font-semibold text-white px-2 py-1 rounded-full flex-shrink-0 ml-2
                             {{ $event->type === 'indoor' ? 'bg-blue-600' : ($event->type === 'outdoor' ? 'bg-green-600' : 'bg-yellow-500') }} 
                             shadow-sm">
                                {{ ucfirst($event->type) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="no-events text-center py-2">
                        <span class="text-xs sm:text-sm font-body text-text-light italic">No events assigned yet</span>
                    </div>
                    @endif
                </div>

                <!-- Profile Section -->
                <div class="profile-section relative p-4 flex items-center gap-3 sm:gap-4 bg-white/50 backdrop-blur-sm">
                    <div class="profile-image-container w-12 h-12 sm:w-16 sm:h-16 flex-shrink-0">
                        @if($coordinator->profile_pic)
                        <img src="{{ asset('storage/'.$coordinator->profile_pic) }}"
                            class="profile-image w-full h-full rounded-full object-cover border-2 border-white shadow-md transition-transform duration-300 hover:scale-105"
                            alt="{{ $coordinator->user->name }}">
                        @else
                        <div class="profile-placeholder w-full h-full rounded-full bg-gradient-to-br from-primary/30 to-primary/50 border-2 border-white flex items-center justify-center shadow-md transition-transform duration-300 hover:scale-105">
                            <span class="text-base sm:text-lg font-heading font-bold text-primary">
                                {{ substr($coordinator->user->name, 0, 1) }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="coordinator-info flex-1 min-w-0">
                        <h2 class="coordinator-name text-base sm:text-lg font-heading font-bold text-text-dark mb-1 truncate">
                            {{ $coordinator->user->name }}
                        </h2>
                        <p class="coordinator-school text-xs sm:text-sm text-text-light truncate">
                            {{ $coordinator->school }}
                        </p>
                    </div>
                </div>

                <!-- Contact Details -->
                <div class="contact-section px-4 sm:px-6 py-3 bg-white/30 backdrop-blur-sm flex flex-col sm:flex-row sm:justify-start sm:gap-4 space-y-1 sm:space-y-0">
                    <div class="contact-item flex items-center text-xs sm:text-sm text-text-dark/80">
                        <span class="contact-icon w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2 text-primary">📱</span>
                        <span class="font-body font-medium truncate">{{ $coordinator->mobile }}</span>
                    </div>
                    @if($coordinator->ext)
                    <div class="contact-item flex items-center text-xs sm:text-sm text-text-dark/80">
                        <span class="contact-icon w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2 text-primary">📞</span>
                        <span class="font-body font-medium">Ext: {{ $coordinator->ext }}</span>
                    </div>
                    @endif
                </div>

                <!-- View Profile Footer -->
                <div class="view-profile-footer bg-primary/5 px-4 sm:px-6 py-3 text-center group-hover:bg-primary transition-colors duration-300">
                    <span class="view-profile-text font-heading font-semibold text-primary group-hover:text-white transition-colors duration-300 text-xs sm:text-sm">
                        View Full Profile →
                    </span>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <!-- No Results Message -->
    <div id="noResults" class="no-results text-center py-16 hidden">
        <div class="no-results-icon text-6xl mb-4">🔍</div>
        <h3 class="no-results-title text-xl font-heading font-bold text-text-dark mb-2">No Results Found</h3>
        <p class="no-results-text text-text-light font-body">Try adjusting your search criteria or filters.</p>
    </div>
    @endif
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

        // Empty State Animation
        if (document.querySelector('.empty-state')) {
            gsap.from(".empty-icon", {
                scale: 0,
                rotation: 180,
                duration: 1,
                ease: "back.out(1.7)",
                delay: 0.3
            });

            gsap.from(".empty-title", {
                y: 30,
                opacity: 0,
                duration: 0.8,
                ease: "power2.out",
                delay: 0.5
            });

            gsap.from(".empty-subtitle", {
                y: 20,
                opacity: 0,
                duration: 0.6,
                ease: "power2.out",
                delay: 0.7
            });
        }

        // Coordinator Cards Animation
        gsap.from(".coordinator-card", {
            y: 0,
            opacity: 1,
            duration: 0.8,
            stagger: 0.1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".coordinators-grid",
                start: "top 80%",
                toggleActions: "play none none reverse"
            }
        });

        // Card Elements Animation
        gsap.from(".profile-image, .profile-placeholder", {
            scale: 0,
            rotation: 180,
            duration: 0.6,
            stagger: 0.05,
            ease: "back.out(1.7)",
            scrollTrigger: {
                trigger: ".coordinators-grid",
                start: "top 70%",
                toggleActions: "play none none reverse"
            }
        });

        gsap.from(".coordinator-name", {
            y: 20,
            opacity: 1,
            duration: 0.6,
            stagger: 0.05,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".coordinators-grid",
                start: "top 60%",
                toggleActions: "play none none reverse"
            }
        });

        gsap.from(".contact-item", {
            x: -20,
            opacity: 1,
            duration: 0.5,
            stagger: 0.05,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".coordinators-grid",
                start: "top 50%",
                toggleActions: "play none none reverse"
            }
        });

        gsap.from(".event-item", {
            y: 15,
            opacity: 1,
            duration: 0.4,
            stagger: 0.05,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".coordinators-grid",
                start: "top 40%",
                toggleActions: "play none none reverse"
            }
        });

        // Card Hover Effects
        document.querySelectorAll('.coordinator-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                gsap.to(this, {
                    y: -8,
                    duration: 0.3,
                    ease: "power2.out"
                });

                gsap.to(this.querySelector('.profile-image, .profile-placeholder'), {
                    scale: 1.1,
                    rotation: 5,
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

                gsap.to(this.querySelector('.profile-image, .profile-placeholder'), {
                    scale: 1,
                    rotation: 0,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });
        });
    });
</script>

<style>
    /* Enhanced styling */
    .coordinator-card:hover {
        box-shadow: 0 20px 40px rgba(197, 1, 15, 0.1);
    }

    .status-indicator {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    /* Custom scrollbar for mobile */
    .coordinators-grid::-webkit-scrollbar {
        width: 4px;
    }

    .coordinators-grid::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .coordinators-grid::-webkit-scrollbar-thumb {
        background: var(--color-primary);
        border-radius: 4px;
    }

    /* Improved responsive behavior */
    @media (max-width: 640px) {
        .coordinator-card-wrapper {
            margin-bottom: 1rem;
        }
    }
</style>

@endsection