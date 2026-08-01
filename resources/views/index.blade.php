@extends('layouts.app')

@section('title', 'CampusConnect - University Event')

@section('content')

<!-- Hero Section-->
<section class="hero-section relative h-screen overflow-hidden bg-gradient-to-br from-background via-white to-primary/5" id="hero-section">

    <!-- Background Animation Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="floating-element absolute top-20 left-10 w-20 h-20 bg-primary/10 rounded-full"></div>
        <div class="floating-element absolute top-40 right-20 w-16 h-16 bg-primary/20 rounded-full"></div>
        <div class="floating-element absolute bottom-40 left-20 w-12 h-12 bg-primary/15 rounded-full"></div>
        <div class="floating-element absolute bottom-20 right-10 w-24 h-24 bg-primary/5 rounded-full"></div>
    </div>

    <!-- Hero Content -->
    <div class="hero-container relative h-full flex items-center justify-center">
        <div class="hero-content max-w-5xl mx-auto text-center px-4 sm:px-6 lg:px-8">

            <!-- Main Heading -->
            <h1 class="hero-title text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-heading font-bold mb-6 text-text-dark">
                Welcome to
                <span class="text-primary drop-shadow-lg block mt-2">
                    CampusConnect
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="hero-subtitle text-lg sm:text-xl md:text-2xl lg:text-3xl font-body text-text-light mb-8 leading-relaxed max-w-4xl mx-auto">
                Join us for the ultimate celebration of creativity, technology, and culture at our university's flagship event.
            </p>

            <!-- Event Dates -->
            @php
            use App\Models\Setting;

            // Get settings for registration end date
            $settings = Setting::first();
            $registrationEnd = $settings ? $settings->registration_end : null;

            // Format registration end date
            $registrationEndFormatted = $registrationEnd ? \Carbon\Carbon::parse($registrationEnd)->format('F j, Y') : 'To be announced';
            @endphp

            <!-- Event Dates -->
            <div class="event-dates flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-8 mb-10">
                <div class="date-card bg-white backdrop-blur-sm rounded-xl p-6 text-center border border-primary/20 shadow-lg">
                    <p class="text-primary font-heading font-bold text-lg">Registration Ends</p>
                    <p class="text-text-dark font-body text-xl font-semibold">{{ $registrationEndFormatted }}</p>
                    @if($registrationEnd && \Carbon\Carbon::parse($registrationEnd)->isPast())
                    <p class="text-red-500 text-sm mt-1 font-semibold">Registration Closed</p>
                    @elseif($registrationEnd && \Carbon\Carbon::parse($registrationEnd)->isFuture())
                    <p class="text-green-500 text-sm mt-1 font-semibold">
                        {{ \Carbon\Carbon::parse($registrationEnd)->diffForHumans() }}
                    </p>
                    @endif
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="hero-buttons flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ url('/events') }}"
                    class="cta-primary bg-primary text-white px-8 py-4 rounded-full font-heading font-semibold text-lg shadow-xl hover:shadow-primary/30 transform hover:scale-105 hover:-translate-y-1 transition-all duration-300 border-2 border-primary hover:bg-white hover:text-primary">
                    Register Now
                </a>
                <a href="#about"
                    class="cta-secondary bg-transparent text-text-dark px-8 py-4 rounded-full font-heading font-semibold text-lg border-2 border-text-dark hover:bg-text-dark hover:text-white transform hover:scale-105 transition-all duration-300">
                    Learn More
                </a>
            </div>

        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator absolute bottom-8 left-1/2 transform -translate-x-1/2">
            <div class="animate-bounce">
                <svg class="w-6 h-6 text-text-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m0 0l7-7" />
                </svg>
            </div>
        </div>
    </div>

</section>

<!-- About Section -->
<section class="about-section py-16 lg:py-24 bg-background" id="about">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="section-title text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-text-dark mb-6">
                About <span class="text-primary">CampusConnect</span>
            </h2>
            <div class="section-divider w-24 h-1 bg-primary mx-auto rounded-full mb-8"></div>
            <p class="section-subtitle text-xl text-text-light font-body max-w-3xl mx-auto leading-relaxed">
                Since 2007, a fusion of campus vibes and creativity that sparks unforgettable moments.
            </p>
        </div>

        <!-- About Content -->
        <div class="about-content grid lg:grid-cols-2 gap-12 items-center mb-16">

            <!-- Text Content -->
            <div class="content-text">
                <h3 class="content-heading text-2xl lg:text-3xl font-heading font-bold text-text-dark mb-6">
                    A Legacy of <span class="text-primary">Excellence</span>
                </h3>
                <p class="content-paragraph text-text-light font-body text-lg leading-relaxed mb-6">
                    Since 2007, CampusConnect has celebrated talent and teamwork, bringing together over 10,000 students from 81 countries. This magnificent event showcases the dedication and creativity cultivated throughout the year.
                </p>
                <p class="content-paragraph text-text-light font-body text-lg leading-relaxed mb-8">
                    CampusConnect is a vibrant blend of excellence, diversity, and camaraderie. Beyond celebrating achievements, it fosters inclusivity, sportsmanship, and a sense of unity, making it one of the most eagerly awaited events of the year.
                </p>

                <!-- Features List -->
                <div class="features-list space-y-4">
                    <div class="feature-item flex items-center">
                        <span class="w-3 h-3 bg-primary rounded-full mr-4"></span>
                        <span class="text-text-dark font-body text-lg">Over 10,000 students 81 countries</span>
                    </div>
                    <div class="feature-item flex items-center">
                        <span class="w-3 h-3 bg-primary rounded-full mr-4"></span>
                        <span class="text-text-dark font-body text-lg">18 years of celebrating excellence since 2007</span>
                    </div>
                    <div class="feature-item flex items-center">
                        <span class="w-3 h-3 bg-primary rounded-full mr-4"></span>
                        <span class="text-text-dark font-body text-lg">Fostering diversity, creativity and unity</span>
                    </div>
                </div>
            </div>

            <!-- Visual Content -->
            <div class="content-visual">
                <div class="visual-card bg-gradient-to-br from-primary/10 to-primary/30 rounded-2xl p-8 h-full flex items-center justify-center min-h-[400px]">
                    <div class="text-center">
                        <div class="visual-emoji text-8xl mb-6">🎉</div>
                        <h4 class="visual-title text-3xl font-heading font-bold text-text-dark mb-4">Join the Celebration</h4>
                        <p class="visual-subtitle text-text-light font-body text-lg">Experience the magic of CampusConnect</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- Gallery Section -->
<section class="gallery-section py-16 lg:py-24 bg-gradient-to-br from-gray-50 to-white" id="gallery">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="gallery-title text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-text-dark mb-6">
                Gallery <span class="text-primary">Moments</span>
            </h2>
            <div class="gallery-divider w-24 h-1 bg-primary mx-auto rounded-full mb-8"></div>
            <p class="gallery-subtitle text-xl text-text-light font-body max-w-3xl mx-auto leading-relaxed">
                Relive the unforgettable moments from previous CampusConnect editions
            </p>
        </div>

        <!-- Gallery Grid -->
        <div class="gallery-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-12">

            <!-- Gallery Item 1 -->
            <div class="gallery-item group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-primary/20 to-primary/40 rounded-2xl overflow-hidden">
                    <div class="w-full h-64 bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                        <span class="text-6xl text-white">🏆</span>
                    </div>
                </div>
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <div class="text-center text-white p-6">
                        <h4 class="text-xl font-bold mb-2">Championship Moments</h4>
                        <p class="text-sm">Celebrating victory and achievement</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 2 -->
            <div class="gallery-item group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-yellow-400 to-red-500 rounded-2xl overflow-hidden">
                    <div class="w-full h-64 bg-gradient-to-br from-yellow-400 to-red-500 flex items-center justify-center">
                        <span class="text-6xl text-white">🎭</span>
                    </div>
                </div>
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <div class="text-center text-white p-6">
                        <h4 class="text-xl font-bold mb-2">Cultural Extravaganza</h4>
                        <p class="text-sm">Vibrant performances and creativity</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 3 -->
            <div class="gallery-item group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-2xl overflow-hidden">
                    <div class="w-full h-64 bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                        <span class="text-6xl text-white">⚽</span>
                    </div>
                </div>
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <div class="text-center text-white p-6">
                        <h4 class="text-xl font-bold mb-2">Sports Action</h4>
                        <p class="text-sm">Thrilling matches and teamwork</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 4 -->
            <div class="gallery-item group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-2xl overflow-hidden">
                    <div class="w-full h-64 bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                        <span class="text-6xl text-white">🎵</span>
                    </div>
                </div>
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <div class="text-center text-white p-6">
                        <h4 class="text-xl font-bold mb-2">Musical Nights</h4>
                        <p class="text-sm">Unforgettable musical performances</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 5 -->
            <div class="gallery-item group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl overflow-hidden">
                    <div class="w-full h-64 bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center">
                        <span class="text-6xl text-white">💃</span>
                    </div>
                </div>
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <div class="text-center text-white p-6">
                        <h4 class="text-xl font-bold mb-2">Dance Performances</h4>
                        <p class="text-sm">Energetic and graceful movements</p>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 6 -->
            <div class="gallery-item group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="aspect-w-16 aspect-h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-2xl overflow-hidden">
                    <div class="w-full h-64 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                        <span class="text-6xl text-white">👥</span>
                    </div>
                </div>
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <div class="text-center text-white p-6">
                        <h4 class="text-xl font-bold mb-2">Team Spirit</h4>
                        <p class="text-sm">Unity and collaboration in action</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- Events Section -->
<section class="events-section py-16 lg:py-24 bg-gradient-to-r from-primary/5 to-primary/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="events-title text-3xl sm:text-4xl lg:text-5xl font-heading font-bold text-text-dark mb-6">
                Our <span class="text-primary">Events</span>
            </h2>
            <div class="events-divider w-24 h-1 bg-primary mx-auto rounded-full mb-8"></div>
            <p class="events-subtitle text-xl text-text-light font-body max-w-3xl mx-auto leading-relaxed">
                Experience the thrill across {{ $eventCounts->sum() }} exciting competitions in {{ $eventCounts->count() }} categories
            </p>
        </div>

        <!-- Dynamic Events Grid -->
        <div class="events-grid grid lg:grid-cols-3 gap-8 lg:gap-8">

            @php
            // Define category configurations
            $categoryConfig = [
            'outdoor' => [
            'title' => 'Outdoor Events',
            'icon' => '🏟️',
            'description' => 'Feel the adrenaline rush in our outdoor sporting competitions.',
            'class' => 'outdoor-events'
            ],
            'indoor' => [
            'title' => 'Indoor Events',
            'icon' => '🏛️',
            'description' => 'Strategic thinking and precision in our indoor competitions.',
            'class' => 'indoor-events'
            ],
            'cultural' => [
            'title' => 'Cultural Events',
            'icon' => '🎭',
            'description' => 'Showcase your creativity through diverse cultural competitions.',
            'class' => 'cultural-events'
            ]
            ];

            // Define sport/activity icons
            $eventIcons = [
            // Sports icons
            'cricket' => '🏏',
            'volleyball' => '🏐',
            'football' => '⚽',
            'basketball' => '🏀',
            'dodgeball' => '🤾',
            'carrom' => '🎯',
            'chess' => '♟️',
            'badminton' => '🏸',
            'table tennis' => '🏓',
            'tennis' => '🎾',
            'kabaddi' => '🤼',
            'tug of war' => '🪢',
            // Cultural icons
            'digital photo' => '📸',
            'photography' => '📸',
            'artistry' => '🎨',
            'drawing' => '🎨',
            'painting' => '🎨',
            'singing' => '🎤',
            'music' => '🎵',
            'public speaking' => '🗣️',
            'debate' => '🗣️',
            'rangoli' => '🌸',
            'dance' => '💃',
            'drama' => '🎭',
            'theatre' => '🎭',
            'poetry' => '📝',
            'writing' => '✍️',
            'quiz' => '🧠',
            'cooking' => '👨‍🍳',
            'fashion' => '👗',
            'coding' => '💻',
            'robotics' => '🤖',
            // Default fallback
            'default' => '🏆'
            ];
            @endphp

            @foreach($eventsByType as $type => $events)
            @if(isset($categoryConfig[$type]))
            <div class="event-category {{ $categoryConfig[$type]['class'] }} bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">

                <!-- Category Header -->
                <div class="flex items-center mb-6">
                    <div class="icon-bg bg-primary/10 p-4 rounded-full mr-4">
                        <span class="category-icon text-3xl">{{ $categoryConfig[$type]['icon'] }}</span>
                    </div>
                    <div>
                        <h3 class="category-title text-2xl font-heading font-bold text-text-dark">{{ $categoryConfig[$type]['title'] }}</h3>
                        <p class="text-sm text-primary font-semibold">({{ $events->count() }} {{ Str::plural('Event', $events->count()) }})</p>
                    </div>
                </div>

                <!-- Category Description -->
                <p class="category-description text-text-light font-body mb-6 leading-relaxed">
                    {{ $categoryConfig[$type]['description'] }}
                </p>

                <!-- Events List -->
                <div class="events-list space-y-3 max-h-80 overflow-y-auto">
                    @foreach($events as $event)
                    @php
                    // Get appropriate icon for the event
                    $eventName = strtolower($event->event_name);
                    $icon = $eventIcons['default']; // default icon

                    foreach($eventIcons as $key => $value) {
                    if(str_contains($eventName, $key)) {
                    $icon = $value;
                    break;
                    }
                    }

                    // Registration status
                    $isRegistrationOpen = $event->registration_open;
                    $registrationCount = $event->registrations->count();
                    $maxParticipants = $event->max_participants;
                    $isFull = $maxParticipants && $registrationCount >= $maxParticipants;
                    @endphp

                    <div class="event-item bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-lg transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <a href="{{ url('/events/' . $event->event_id . '/register') }}">
                                <div class="flex items-center flex-1">
                                    <span class="mr-3 text-lg">{{ $icon }}</span>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-body font-semibold text-text-dark">
                                            {{ $event->event_name }}
                                        </h4>


                                        <!-- @if($event->venue)
                                    <p class="text-xs text-text-light">📍 {{ $event->venue }}</p>
                                    @endif
                                    @if($event->event_date)
                                    <p class="text-xs text-text-light">📅 {{ \Carbon\Carbon::parse($event->event_date)->format('M j, Y') }}</p>
                                    @endif -->
                                    </div>
                                </div>
                            </a>

                        <!-- Registration Status
                                        <div class="flex flex-col items-end ml-2">
                                            @if($isFull)
                                                <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full font-semibold">Full</span>
                                            @elseif($isRegistrationOpen)
                                                <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full font-semibold">Open</span>
                                            @else
                                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full font-semibold">Closed</span>
                                            @endif
                                            
                                            @if($maxParticipants)
                                                <span class="text-xs text-text-light mt-1">{{ $registrationCount }}/{{ $maxParticipants }}</span>
                                            @else
                                                <span class="text-xs text-text-light mt-1">{{ $registrationCount }} registered</span>
                                            @endif

                                            @if($event->is_group)
                                                <span class="text-xs text-primary mt-1">👥 Group</span>
                                            @endif
                                        </div> -->
                    </div>

                    @if($event->description && strlen($event->description) > 0)
                    <p class="text-xs text-text-light mt-2 line-clamp-2">{{ Str::limit($event->description, 80) }}</p>
                    @endif
                </div>
                @endforeach

                @if($events->isEmpty())
                <div class="text-center py-8 text-text-light">
                    <p class="text-lg">🎯</p>
                    <p class="text-sm mt-2">No events available yet</p>
                </div>
                @endif
            </div>

            <!-- Category Footer -->
            @if($events->isNotEmpty())
            <div class="mt-6 pt-6 border-t border-gray-100">
                <a href="{{ url('/events?type=' . $type) }}"
                    class="block text-center text-primary hover:text-primary-dark font-semibold text-sm transition-colors duration-200">
                    View All {{ $categoryConfig[$type]['title'] }} →
                </a>
            </div>
            @endif
        </div>
        @endif
        @endforeach

        @if($eventsByType->isEmpty())
        <!-- No Events Found -->
        <div class="col-span-3 text-center py-16">
            <div class="text-6xl mb-6">🎪</div>
            <h3 class="text-2xl font-heading font-bold text-text-dark mb-4">Events Coming Soon!</h3>
            <p class="text-text-light font-body text-lg max-w-md mx-auto">
                We're preparing some amazing events for you. Stay tuned for updates!
            </p>
        </div>
        @endif

    </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section py-16 lg:py-24 bg-gradient-to-r from-primary to-red-700 text-white relative overflow-hidden">

    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="floating-bg absolute top-10 left-10 w-32 h-32 bg-white rounded-full"></div>
        <div class="floating-bg absolute bottom-10 right-10 w-24 h-24 bg-white rounded-full"></div>
        <div class="floating-bg absolute top-1/2 left-1/4 w-16 h-16 bg-white rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">

        <h2 class="cta-title text-3xl sm:text-4xl lg:text-5xl font-heading font-bold mb-6">
            Ready to Join <span class="text-yellow-300">CampusConnect</span>?
        </h2>

        <p class="cta-subtitle text-lg sm:text-xl font-body mb-8 max-w-2xl mx-auto leading-relaxed">
            Don't miss out on this incredible celebration of talent, creativity, and unity. Register now and be part of something extraordinary!
        </p>

        <div class="cta-buttons flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
            <a href="{{ url('/events') }}"
                class="btn-cta bg-white text-primary px-8 py-4 rounded-full font-heading font-semibold text-lg shadow-2xl hover:shadow-white/30 transform hover:scale-105 hover:-translate-y-1 transition-all duration-300">
                Register for Events
            </a>
            <a href="{{ url('/soty/apply') }}"
                class="btn-secondary bg-transparent text-white px-8 py-4 rounded-full font-heading font-semibold text-lg border-2 border-white hover:bg-white hover:text-primary transform hover:scale-105 transition-all duration-300">
                Apply for SOTY
            </a>
        </div>

    </div>
</section>

<!-- GSAP Animation Scripts -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Register ScrollTrigger plugin
        gsap.registerPlugin(ScrollTrigger);

        // Hero Section Animation
        const heroTl = gsap.timeline();
        heroTl
            .from('.hero-title', {
                duration: 1,
                y: 100,
                opacity: 0,
                ease: "power3.out"
            })
            .from('.hero-subtitle', {
                duration: 0.8,
                y: 50,
                opacity: 0,
                ease: "power2.out"
            }, "-=0.5")
            .from('.date-card', {
                duration: 0.8,
                scale: 0.8,
                opacity: 0,
                ease: "back.out(1.7)"
            }, "-=0.3")
            .from('.cta-primary', {
                duration: 0.6,
                x: -50,
                opacity: 0,
                ease: "power2.out"
            })
            .from('.cta-secondary', {
                duration: 0.6,
                x: 50,
                opacity: 0,
                ease: "power2.out"
            }, "-=0.4");

        // Animate floating elements in hero section
        gsap.to('.floating-element', {
            y: 20,
            duration: 3,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut",
            stagger: 0.5
        });

        // About Section Animation with ScrollTrigger
        gsap.from('.section-title, .section-divider, .section-subtitle', {
            scrollTrigger: {
                trigger: '.about-section',
                start: 'top 80%',
                end: 'bottom 20%',
                toggleActions: 'play none none reverse'
            },
            duration: 1,
            y: 50,
            opacity: 0,
            stagger: 0.3,
            ease: "power2.out"
        });

        gsap.from('.content-heading', {
            scrollTrigger: {
                trigger: '.content-text',
                start: 'top 70%',
                end: 'bottom 30%',
                toggleActions: 'play none none reverse'
            },
            duration: 0.8,
            x: -50,
            opacity: 0,
            ease: "power2.out"
        });

        gsap.from('.content-paragraph', {
            scrollTrigger: {
                trigger: '.content-text',
                start: 'top 60%',
                end: 'bottom 40%',
                toggleActions: 'play none none reverse'
            },
            duration: 0.8,
            y: 30,
            opacity: 0,
            stagger: 0.2,
            ease: "power2.out"
        });

        gsap.from('.feature-item', {
            scrollTrigger: {
                trigger: '.features-list',
                start: 'top 80%',
                end: 'bottom 20%',
                toggleActions: 'play none none reverse'
            },
            duration: 0.6,
            x: -30,
            opacity: 0,
            stagger: 0.15,
            ease: "power2.out"
        });

        gsap.from('.visual-card', {
            scrollTrigger: {
                trigger: '.content-visual',
                start: 'top 70%',
                end: 'bottom 30%',
                toggleActions: 'play none none reverse'
            },
            duration: 1,
            scale: 0.8,
            opacity: 0,
            ease: "back.out(1.7)"
        });

        // Gallery Section Animation
        gsap.from('.gallery-title, .gallery-divider, .gallery-subtitle', {
            scrollTrigger: {
                trigger: '.gallery-section',
                start: 'top 80%',
                end: 'bottom 20%',
                toggleActions: 'play none none reverse'
            },
            duration: 1,
            y: 50,
            opacity: 1,
            stagger: 0.3,
            ease: "power2.out"
        });

        gsap.from('.gallery-item', {
            scrollTrigger: {
                trigger: '.gallery-grid',
                start: 'top 70%',
                end: 'bottom 30%',
                toggleActions: 'play none none reverse'
            },
            duration: 0.8,
            opacity: 1,
            stagger: 0.15,
            ease: "power2.out"
        });

        // Events Section Animation
        gsap.from('.events-title, .events-divider, .events-subtitle', {
            scrollTrigger: {
                trigger: '.events-section',
                start: 'top 80%',
                end: 'bottom 20%',
                toggleActions: 'play none none reverse'
            },
            duration: 1,
            y: 50,
            opacity: 0,
            stagger: 0.3,
            ease: "power2.out"
        });

        gsap.from('.event-category', {
            scrollTrigger: {
                trigger: '.events-grid',
                start: 'top 70%',
                end: 'bottom 30%',
                toggleActions: 'play none none reverse'
            },
            duration: 0.8,
            opacity: 1,
            stagger: 0.2,
            ease: "power2.out"
        });

        // CTA Section Animation
        gsap.from('.cta-title, .cta-subtitle', {
            scrollTrigger: {
                trigger: '.cta-section',
                start: 'top 80%',
                end: 'bottom 20%',
                toggleActions: 'play none none reverse'
            },
            duration: 1,
            y: 50,
            opacity: 0,
            stagger: 0.3,
            ease: "power2.out"
        });

        gsap.from('.btn-cta, .btn-secondary', {
            scrollTrigger: {
                trigger: '.cta-buttons',
                start: 'top 70%',
                end: 'bottom 30%',
                toggleActions: 'play none none reverse'
            },
            duration: 0.8,
            opacity: 1,
            stagger: 0.2,
            ease: "power2.out"
        });

        // Animate floating background elements in CTA section
        gsap.to('.floating-bg', {
            scrollTrigger: {
                trigger: '.cta-section',
                start: 'top bottom',
                end: 'bottom top',
                scrub: 1
            },
            y: -30,
            rotation: 5,
            stagger: 0.2,
            ease: "none"
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    gsap.to(window, {
                        duration: 1,
                        scrollTo: {
                            y: target,
                            offsetY: 80
                        },
                        ease: "power2.inOut"
                    });
                }
            });
        });

        // Add hover animations to interactive elements
        document.querySelectorAll('.event-item, .gallery-item, .event-category').forEach(item => {
            item.addEventListener('mouseenter', () => {
                gsap.to(item, {
                    duration: 0.3,
                    scale: 1.02,
                    ease: "power2.out"
                });
            });

            item.addEventListener('mouseleave', () => {
                gsap.to(item, {
                    duration: 0.3,
                    scale: 1,
                    ease: "power2.out"
                });
            });
        });
    });
</script>

@endsection