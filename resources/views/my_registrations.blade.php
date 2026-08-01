@extends('layouts.app')

@section('title', 'My Registrations | CampusConnect')

@section('content')

<!-- Page Header -->
<header class="page-header bg-gradient-to-r from-primary to-red-700 text-white py-16 lg:py-20 text-center relative overflow-hidden" id="registrations-header">

    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="floating-bg absolute top-10 left-10 w-32 h-32 bg-white rounded-full"></div>
        <div class="floating-bg absolute bottom-10 right-10 w-24 h-24 bg-white rounded-full"></div>
        <div class="floating-bg absolute top-1/2 right-1/4 w-16 h-16 bg-white rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="header-icon text-6xl mb-4">🎟️</div>
        <h1 class="header-title text-3xl sm:text-4xl lg:text-5xl font-heading font-bold mb-4">
            My <span class="text-yellow-300">Registrations</span>
        </h1>
        <p class="header-subtitle text-lg sm:text-xl font-body leading-relaxed max-w-2xl mx-auto">
            Track all your event registrations and participation details
        </p>
    </div>
</header>

<main class="registrations-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">

    @if($registrations->isEmpty())
    <!-- Empty State -->
    <div class="empty-state text-center py-16">
        <div class="empty-icon text-8xl mb-6">📋</div>
        <h2 class="empty-title text-2xl sm:text-3xl font-heading font-bold text-text-dark mb-4">
            No Registrations Yet
        </h2>
        <p class="empty-subtitle text-lg text-text-light font-body mb-8 max-w-md mx-auto leading-relaxed">
            You haven't registered for any events yet. Explore our exciting events and join the fun!
        </p>
        <a href="{{ url('/events') }}"
            class="cta-btn bg-primary text-white px-8 py-4 rounded-full font-heading font-semibold text-lg shadow-lg hover:bg-red-700 hover:shadow-xl hover:shadow-primary/30 transform hover:scale-105 transition-all duration-300">
            <span class="mr-2">🎯</span>
            Browse Events
        </a>
    </div>
    @else

    <!-- Registrations Stats -->
    <div class="stats-section mb-12">
        <div class="stats-grid grid grid-cols-1 sm:grid-cols-1">
            <div class="stat-card bg-white rounded-xl shadow-lg p-6 text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="stat-icon text-3xl mb-3">🎪</div>
                <div class="stat-number text-2xl font-heading font-bold text-primary mb-1">{{ $registrations->count() }}</div>
                <div class="stat-label text-text-light font-body text-sm">Total Registrations</div>
            </div>
            <!-- <div class="stat-card bg-white rounded-xl shadow-lg p-6 text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="stat-icon text-3xl mb-3">👑</div>
                <div class="stat-number text-2xl font-heading font-bold text-primary mb-1">
                    {{ $registrations->where('leader_enrolment', auth()->user()->enrolment_no)->count() }}
                </div>
                <div class="stat-label text-text-light font-body text-sm">As Leader</div>
            </div>
            <div class="stat-card bg-white rounded-xl shadow-lg p-6 text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="stat-icon text-3xl mb-3">🤝</div>
                <div class="stat-number text-2xl font-heading font-bold text-primary mb-1">
                    {{ $registrations->where('leader_enrolment', '!=', auth()->user()->enrolment_no)->count() }}
                </div>
                <div class="stat-label text-text-light font-body text-sm">As Member</div>
            </div> -->
        </div>
    </div>

    <!-- Registrations by Category -->
    <div class="category-stats-section mb-12">
        <div class="stats-grid grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach($categoryStats as $category => $count)
            <div class="stat-card bg-white rounded-xl shadow-lg p-6 text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="stat-icon text-3xl mb-3">
                    @if($category === 'Indoor') 🏠
                    @elseif($category === 'Outdoor') 🌳
                    @else 🎭
                    @endif
                </div>
                <div class="stat-number text-2xl font-heading font-bold text-primary mb-1">{{ $count }}</div>
                <div class="stat-label text-text-light font-body text-sm">{{ $category }} Events</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Registrations Grid -->
    <div class="registrations-grid grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
        @foreach($registrations as $reg)
        @php
        $event = $reg->event;
        $role = $reg->leader_enrolment === auth()->user()->enrolment_no ? 'Leader' : 'Participant';
        @endphp

        <div class="registration-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2 group">

            <!-- Event Image -->
            <div class="event-image-container relative overflow-hidden">
                @if($event->thumbnail_image)
                <img src="{{ asset('storage/' . $event->thumbnail_image) }}"
                    alt="{{ $event->event_name }}"
                    class="event-image w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                <img src="https://source.unsplash.com/600x400/?{{ $event->type }},sports"
                    alt="{{ $event->event_name }}"
                    class="event-image w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110">
                @endif

                <!-- Image Overlay -->
                <div class="image-overlay absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                <!-- Event Type Badge -->
                <div class="event-type-badge absolute top-4 left-4 bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold">
                    {{ ucfirst($event->type) }}
                </div>

                <!-- Registration Date -->
                <div class="registration-date absolute top-4 right-4 bg-white/90 text-text-dark px-3 py-1 rounded-full text-xs font-semibold">
                    {{ $reg->created_at->format('d M') }}
                </div>
            </div>

            <!-- Card Content -->
            <div class="card-content p-6">

                <!-- Event Title -->
                <h2 class="event-title text-xl font-heading font-bold text-text-dark mb-2 group-hover:text-primary transition-colors duration-300">
                    {{ $event->event_name }}
                </h2>

                <!-- Event Details -->
                <!-- <div class="event-details space-y-2 mb-4">
                    <div class="detail-item flex items-center text-sm text-text-light">
                        <span class="detail-icon w-4 h-4 mr-2 text-primary">📍</span>
                        <span class="font-body">{{ $event->venue ?? 'Venue TBD' }}</span>
                    </div>
                    <div class="detail-item flex items-center text-sm text-text-light">
                        <span class="detail-icon w-4 h-4 mr-2 text-primary">📅</span>
                        <span class="font-body">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</span>
                    </div>
                    <div class="detail-item flex items-center text-sm text-text-light">
                        <span class="detail-icon w-4 h-4 mr-2 text-primary">⏰</span>
                        <span class="font-body">{{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</span>
                    </div>
                </div> -->

                <!-- Badges Section -->
                @php
                if ($event->is_group) {
                if ($reg->leader_enrolment === auth()->user()->enrolment_no) {
                $badges = [
                ['text' => 'Leader', 'class' => 'bg-blue-50 text-blue-700 border-blue-200', 'icon' => '👑'],
                ['text' => 'Group Event', 'class' => 'bg-yellow-50 text-yellow-700 border-yellow-200', 'icon' => '👥'],
                ];
                } else {
                $badges = [
                ['text' => 'Member', 'class' => 'bg-green-50 text-green-700 border-green-200', 'icon' => '🤝'],
                ['text' => 'Group Event', 'class' => 'bg-yellow-50 text-yellow-700 border-yellow-200', 'icon' => '👥'],
                ];
                }
                } else {
                $badges = [
                ['text' => 'Solo Event', 'class' => 'bg-purple-50 text-purple-700 border-purple-200', 'icon' => '⭐'],
                ];
                }
                @endphp

                <div class="badges-section mb-4">
                    <div class="badges-grid flex flex-wrap gap-2">
                        @foreach ($badges as $badge)
                        <span class="badge inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full border {{ $badge['class'] }}">
                            <span class="mr-1">{{ $badge['icon'] }}</span>
                            {{ $badge['text'] }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <!-- Group Members Section -->
                @if($event->is_group)
                <div class="group-members-section mt-4">
                    <div class="members-header flex items-center justify-between mb-3">
                        <h4 class="font-heading font-semibold text-text-dark text-sm flex items-center">
                            <span class="mr-2">👥</span>
                            Team Members ({{ $event->registrations->count() }})
                        </h4>
                        <span class="text-xs text-text-light bg-gray-100 px-2 py-1 rounded-full">
                            Group Event
                        </span>
                    </div>

                    <div class="members-list bg-gray-50 rounded-lg p-3 border border-gray-200">
                        @foreach($event->registrations as $index => $member)
                        <div class="member-item flex items-center justify-between py-2 {{ $index > 0 ? 'border-t border-gray-200' : '' }}">
                            <div class="member-info flex items-center">
                                <div class="member-avatar w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-xs font-semibold mr-3">
                                    {{ substr($member->participant?->full_name ?? 'N', 0, 1) }}
                                </div>
                                <div>
                                    <span class="member-name font-semibold text-text-dark text-sm block">
                                        {{ $member->participant?->full_name ?? 'N/A' }}
                                    </span>
                                    <span class="member-enroll text-text-light text-xs">
                                        {{ $member->participant_enrolment }}
                                    </span>
                                </div>
                            </div>
                            @if($member->leader_enrolment === $member->participant_enrolment)
                            <span class="leader-badge text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full flex items-center">
                                <span class="mr-1">👑</span>
                                Leader
                            </span>
                            @else
                            <span class="member-badge text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                                Member
                            </span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Registration Info -->
                <div class="registration-info mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-text-light font-body flex items-center">
                        <span class="mr-2">📝</span>
                        Registered on {{ $reg->created_at->format('d M, Y \a\t H:i') }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
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
                opacity: 1,
                duration: 0.8,
                ease: "power2.out",
                delay: 0.5
            });

            gsap.from(".empty-subtitle", {
                y: 20,
                opacity: 1,
                duration: 0.6,
                ease: "power2.out",
                delay: 0.7
            });

            gsap.from(".cta-btn", {
                scale: 0,
                duration: 0.6,
                ease: "back.out(1.7)",
                delay: 0.9
            });
        }

        // Stats Section Animation
        gsap.from(".stat-card", {
            opacity: 1,
            duration: 0.8,
            stagger: 0.2,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".stats-section",
                start: "top 80%",
                toggleActions: "play none none reverse"
            }
        });

        // Registration Cards Animation
        gsap.from(".registration-card", {
            opacity: 1,
            duration: 0.8,
            stagger: 0.1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".registrations-grid",
                start: "top 80%",
                toggleActions: "play none none reverse"
            }
        });

        // Card Content Animation
        gsap.from(".event-title", {
            y: 20,
            opacity: 0,
            duration: 0.6,
            stagger: 0.05,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".registrations-grid",
                start: "top 70%",
                toggleActions: "play none none reverse"
            }
        });

        gsap.from(".badge", {
            scale: 0,
            opacity: 0,
            duration: 0.4,
            stagger: 0.05,
            ease: "back.out(1.7)",
            scrollTrigger: {
                trigger: ".registrations-grid",
                start: "top 60%",
                toggleActions: "play none none reverse"
            }
        });

        // Member list animations
        gsap.from(".member-item", {
            opacity: 1,
            duration: 0.5,
            stagger: 0.1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: ".registrations-grid",
                start: "top 60%",
                toggleActions: "play none none reverse"
            }
        });

        // Card Hover Effects
        document.querySelectorAll('.registration-card, .stat-card').forEach(card => {
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
        document.querySelectorAll('.cta-btn').forEach(button => {
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

        // Member avatar hover effects
        document.querySelectorAll('.member-avatar').forEach(avatar => {
            avatar.addEventListener('mouseenter', function() {
                gsap.to(this, {
                    scale: 1.1,
                    duration: 0.2,
                    ease: "power2.out"
                });
            });

            avatar.addEventListener('mouseleave', function() {
                gsap.to(this, {
                    scale: 1,
                    duration: 0.2,
                    ease: "power2.out"
                });
            });
        });
    });
</script>

<style>
    /* Enhanced shadow effects */
    .registration-card:hover,
    .stat-card:hover {
        box-shadow: 0 20px 40px rgba(197, 1, 15, 0.1);
    }

    /* Member list styling */
    .members-list {
        transition: all 0.3s ease;
    }

    .member-item {
        transition: all 0.2s ease;
    }

    .member-item:hover {
        background-color: rgba(197, 1, 15, 0.05);
        border-radius: 6px;
    }

    .member-avatar {
        transition: all 0.2s ease;
        font-weight: 600;
    }

    /* Badge styling */
    .leader-badge,
    .member-badge {
        font-weight: 600;
        letter-spacing: 0.025em;
    }

    /* Enhanced card styling */
    .registration-card {
        transition: all 0.3s ease;
    }

    .group-members-section {
        border-top: 1px solid #e5e7eb;
        padding-top: 1rem;
    }
</style>
@endsection