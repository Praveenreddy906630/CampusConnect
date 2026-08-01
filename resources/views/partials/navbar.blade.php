<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-black/40 backdrop-blur-md border-b border-white/10 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 lg:h-20">

            <!-- Logo -->
            <div class="flex-shrink-0 cursor-pointer" id="logo">
                <a href="{{ url('/') }}">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-heading font-bold tracking-wider transition-all duration-300 hover:scale-105">
                        <span class="text-2xl animate-bounce inline-block">🎉</span>
                        <span class="text-primary drop-shadow-lg">
                            CampusConnect
                        </span>
                    </h1>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:block">
                <ul class="flex items-center space-x-8 font-body" id="desktop-menu">
                    <li>
                        <a href="{{ url('/events') }}"
                            class="nav-link text-black hover:text-primary transition-all duration-300 font-medium relative group px-2 py-1 rounded-md hover:bg-white/10">
                            Events
                            <span class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-4/5 group-hover:left-[10%] rounded-full"></span>
                        </a>
                    </li>
                    @if(!auth()->check() || auth()->user()->user_type === 'student')
                    <li>
                        <a href="{{ url('/soty/apply') }}"
                            class="nav-link text-black hover:text-primary transition-all duration-300 font-medium relative group px-2 py-1 rounded-md hover:bg-white/10">
                            Student of the Year
                            <span class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-4/5 group-hover:left-[10%] rounded-full"></span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ url('/coordinators') }}"
                            class="nav-link text-black hover:text-primary transition-all duration-300 font-medium relative group px-2 py-1 rounded-md hover:bg-white/10">
                            Coordinators
                            <span class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-4/5 group-hover:left-[10%] rounded-full"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/contact')}}"
                            class="nav-link text-black hover:text-primary transition-all duration-300 font-medium relative group px-2 py-1 rounded-md hover:bg-white/10">
                            Contact
                            <span class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-4/5 group-hover:left-[10%] rounded-full"></span>
                        </a>
                    </li>

                    <!-- Auth Links -->
                    @guest
                    <li>
                        <a href="{{ route('login.form') }}"
                            class="nav-link text-black hover:text-primary transition-all duration-300 font-medium relative group px-2 py-1 rounded-md hover:bg-white/10">
                            Login
                            <span class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-4/5 group-hover:left-[10%] rounded-full"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}"
                            class="bg-primary text-white font-medium px-6 py-2.5 rounded-full hover:bg-red-700 hover:shadow-lg hover:shadow-primary/30 transform hover:scale-110 hover:-translate-y-1 transition-all duration-300 border-2 border-primary hover:border-white/20">
                            Sign Up
                        </a>
                    </li>
                    @endguest

                    @auth
                    <li>
                        <a href="{{ route('my.registrations') }}"
                            class="nav-link text-black hover:text-primary transition-all duration-300 font-medium relative group px-2 py-1 rounded-md hover:bg-white/10">
                            My Registrations
                            <span class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-4/5 group-hover:left-[10%] rounded-full"></span>
                        </a>
                    </li>

                    @if(auth()->user()->user_type === 'admin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link text-black hover:text-primary transition-all duration-300 font-medium relative group px-2 py-1 rounded-md hover:bg-white/10">
                            Admin
                            <span class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-4/5 group-hover:left-[10%] rounded-full"></span>
                        </a>
                    </li>
                    @elseif(auth()->user()->user_type === 'coordinator')
                    <li>
                        <a href="{{ route('coordinator.dashboard') }}"
                            class="nav-link text-black hover:text-primary transition-all duration-300 font-medium relative group px-2 py-1 rounded-md hover:bg-white/10">
                            My Events
                            <span class="absolute -bottom-1 left-1/2 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-4/5 group-hover:left-[10%] rounded-full"></span>
                        </a>
                    </li>
                    @endif

                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-primary text-white font-medium px-6 py-2.5 rounded-full hover:bg-red-700 hover:shadow-lg hover:shadow-primary/30 transform hover:scale-110 hover:-translate-y-1 transition-all duration-300 border-2 border-primary hover:border-white/20">
                                Logout
                            </button>
                        </form>
                    </li>
                    @endauth
                </ul>
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <button type="button"
                    class="mobile-menu-btn text-black hover:text-primary focus:outline-none focus:text-primary transition-all duration-300 p-2 rounded-md hover:bg-white/10 hover:scale-110"
                    aria-expanded="false"
                    aria-label="Toggle navigation menu"
                    id="mobile-menu-btn">
                    <svg class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="hamburger-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div class="lg:hidden hidden bg-black/95 backdrop-blur-md border-t border-white/10 shadow-2xl max-h-[calc(100vh-4rem)] overflow-y-auto"
        id="mobile-menu"
        aria-hidden="true">
        <div class="px-4 py-6 space-y-2" id="mobile-menu-items">
            <a href="{{ url('/') }}"
                class="mobile-nav-link block text-black hover:text-primary font-medium py-3 px-4 rounded-lg hover:bg-white/10 transition-all duration-300 transform hover:translate-x-2">
                <span class="flex items-center">
                    <span class="mr-3">🏠</span> Home
                </span>
            </a>
            <a href="{{ url('/events') }}"
                class="mobile-nav-link block text-black hover:text-primary font-medium py-3 px-4 rounded-lg hover:bg-white/10 transition-all duration-300 transform hover:translate-x-2">
                <span class="flex items-center">
                    <span class="mr-3">🎭</span> Events
                </span>
            </a>
            @if(!auth()->check() || auth()->user()->user_type === 'student')
            <a href="{{ url('/soty/apply') }}"
                class="mobile-nav-link block text-black hover:text-primary font-medium py-3 px-4 rounded-lg hover:bg-white/10 transition-all duration-300 transform hover:translate-x-2">
                <span class="flex items-center">
                    <span class="mr-3">🏆</span> Student of the Year
                </span>
            </a>
            @endif
            <a href="{{ url('/coordinators') }}"
                class="mobile-nav-link block text-black hover:text-primary font-medium py-3 px-4 rounded-lg hover:bg-white/10 transition-all duration-300 transform hover:translate-x-2">
                <span class="flex items-center">
                    <span class="mr-3">👥</span> Coordinators
                </span>
            </a>
            <a href="{{ url('/contact') }}"
                class="mobile-nav-link block text-black hover:text-primary font-medium py-3 px-4 rounded-lg hover:bg-white/10 transition-all duration-300 transform hover:translate-x-2">
                <span class="flex items-center">
                    <span class="mr-3">📞</span> Contact
                </span>
            </a>

            <div class="border-t border-white/20 pt-4 mt-4 space-y-2">
                @guest
                <a href="{{ route('login.form') }}"
                    class="mobile-nav-link block text-black hover:text-primary font-medium py-3 px-4 rounded-lg hover:bg-white/10 transition-all duration-300 transform hover:translate-x-2">
                    <span class="flex items-center">
                        <span class="mr-3">🔑</span> Login
                    </span>
                </a>
                <a href="{{ route('register') }}"
                    class="block bg-primary text-white font-medium px-6 py-3 rounded-full text-center mt-4 hover:bg-red-700 hover:shadow-lg hover:shadow-primary/30 transform hover:scale-105 transition-all duration-300">
                    <span class="flex items-center justify-center">
                        <span class="mr-2">✨</span> Sign Up
                    </span>
                </a>
                @endguest

                @auth
                <a href="{{ route('my.registrations') }}"
                    class="mobile-nav-link block text-black hover:text-primary font-medium py-3 px-4 rounded-lg hover:bg-white/10 transition-all duration-300 transform hover:translate-x-2">
                    <span class="flex items-center">
                        <span class="mr-3">📝</span> My Registrations
                    </span>
                </a>

                @if(auth()->user()->user_type === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="mobile-nav-link block text-black hover:text-primary font-medium py-3 px-4 rounded-lg hover:bg-white/10 transition-all duration-300 transform hover:translate-x-2">
                    <span class="flex items-center">
                        <span class="mr-3">⚙️</span> Admin
                    </span>
                </a>
                @elseif(auth()->user()->user_type === 'coordinator')
                <a href="{{ route('coordinator.dashboard') }}"
                    class="mobile-nav-link block text-black hover:text-primary font-medium py-3 px-4 rounded-lg hover:bg-white/10 transition-all duration-300 transform hover:translate-x-2">
                    <span class="flex items-center">
                        <span class="mr-3">📊</span> My Events
                    </span>
                </a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit"
                        class="w-full bg-primary text-white font-medium px-6 py-3 rounded-full hover:bg-red-700 hover:shadow-lg hover:shadow-primary/30 transform hover:scale-105 transition-all duration-300 flex items-center justify-center">
                        <span class="mr-2">🚪</span> Logout
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Enhanced GSAP Animation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize GSAP timeline for navbar entrance
        const tl = gsap.timeline();

        // Animate navbar entrance with more dramatic effect
        tl.from("#navbar", {
                y: -100,
                opacity: 1,
                duration: 1,
                ease: "elastic.out(1, 0.8)"
            })
            .from("#logo", {
                x: -100,
                opacity: 1,
                rotation: -10,
                duration: 0.8,
                ease: "back.out(1.7)"
            }, "-=0.6")
            .from(".nav-link", {
                y: -30,
                opacity: 1,
                duration: 0.6,
                stagger: 0.1,
                ease: "bounce.out"
            }, "-=0.4");

        // Mobile menu functionality with enhanced animations
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        let isMenuOpen = false;

        mobileMenuBtn.addEventListener('click', function() {
            isMenuOpen = !isMenuOpen;

            if (isMenuOpen) {
                // Show mobile menu
                mobileMenu.classList.remove('hidden');
                mobileMenu.setAttribute('aria-hidden', 'false');
                mobileMenuBtn.setAttribute('aria-expanded', 'true');

                // Animate menu entrance
                gsap.fromTo(mobileMenu, 
                    {
                        opacity: 1,
                        y: -20
                    },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.4,
                        ease: "power3.out"
                    }
                );

                gsap.from(".mobile-nav-link", {
                    opacity: 1,
                    duration: 0.4,
                    stagger: 0.08,
                    delay: 0.1,
                    ease: "power2.out"
                });

                // Rotate hamburger icon
                gsap.to(hamburgerIcon, {
                    rotation: 180,
                    duration: 0.3
                });

            } else {
                // Close mobile menu
                gsap.to(mobileMenu, {
                    opacity: 1,
                    y: -20,
                    duration: 0.3,
                    ease: "power2.in",
                    onComplete: () => {
                        mobileMenu.classList.add('hidden');
                    }
                });

                // Reset hamburger icon
                gsap.to(hamburgerIcon, {
                    rotation: 0,
                    duration: 0.3
                });

                mobileMenu.setAttribute('aria-hidden', 'true');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (isMenuOpen && !mobileMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                mobileMenuBtn.click();
            }
        });

        // Close mobile menu on window resize to desktop
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth >= 1024 && isMenuOpen) {
                    mobileMenu.classList.add('hidden');
                    mobileMenu.setAttribute('aria-hidden', 'true');
                    mobileMenuBtn.setAttribute('aria-expanded', 'false');
                    isMenuOpen = false;
                    gsap.set(hamburgerIcon, { rotation: 0 });
                }
            }, 250);
        });

        // Enhanced navbar scroll effect
        let lastScrollY = window.scrollY;

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;

            if (currentScrollY > 100) {
                gsap.to("#navbar", {
                    backdropFilter: "blur(20px)",
                    borderBottom: "1px solid rgba(197, 1, 15, 0.3)",
                    duration: 0.3
                });
            } else {
                gsap.to("#navbar", {
                    backdropFilter: "blur(10px)",
                    borderBottom: "1px solid rgba(255, 255, 255, 0.1)",
                    duration: 0.3
                });
            }

            lastScrollY = currentScrollY;
        });

        // Enhanced hover animations for desktop nav links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                gsap.to(this, {
                    y: -3,
                    scale: 1.05,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            link.addEventListener('mouseleave', function() {
                gsap.to(this, {
                    y: 0,
                    scale: 1,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });
        });

        // Button hover effects
        document.querySelectorAll('button, .bg-primary').forEach(button => {
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

        // Logo hover animation
        document.getElementById('logo').addEventListener('mouseenter', function() {
            gsap.to(this.querySelector('span:first-child'), {
                rotation: 360,
                scale: 1.2,
                duration: 0.6,
                ease: "power2.out"
            });
        });

        // Mobile nav link hover effects (only for devices with hover capability)
        if (window.matchMedia('(hover: hover)').matches) {
            document.querySelectorAll('.mobile-nav-link').forEach(link => {
                link.addEventListener('mouseenter', function() {
                    gsap.to(this, {
                        x: 10,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });

                link.addEventListener('mouseleave', function() {
                    gsap.to(this, {
                        x: 0,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });
            });
        }
    });
</script>