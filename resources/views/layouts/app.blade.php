<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'CampusConnect')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.23.0/sweetalert2.css" integrity="sha512-/j+6zx45kh/MDjnlYQL0wjxn+aPaSkaoTczyOGfw64OB2CHR7Uh5v1AML7VUybUnUTscY5ck/gbGygWYcpCA7w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Extend Tailwind config to support custom variables
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: 'var(--color-primary)',
                        background: 'var(--color-background)',
                        'text-dark': 'var(--color-text-dark)',
                        'text-light': 'var(--color-text-light)',
                        white: 'var(--color-white)',
                        black: 'var(--color-black)'
                    },
                    fontFamily: {
                        heading: 'var(--font-heading)',
                        body: 'var(--font-body)'
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            /* 🎨 Colors */
            --color-primary: #c5010f;
            /* Main brand color */
            --color-background: #ffffff;
            /* Page background */
            --color-text-dark: #333333;
            /* Primary text */
            --color-text-light: #666666;
            /* Secondary text */
            --color-white: #ffffff;
            --color-black: #000000;

            /* 🖋️ Fonts */
            --font-heading: 'Poppins', sans-serif;
            --font-body: 'Roboto', sans-serif;
        }

        /* Loading Screen Styles */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a0105 100%);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        #loading-screen.fade-out {
            opacity: 0;
            transform: scale(1.1);
            pointer-events: none;
        }

        .loader-container {
            position: relative;
            width: 300px;
            height: 300px;
        }

        /* Hexagon Spinner */
        .hexagon-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
        }

        .hexagon {
            width: 100%;
            height: 100%;
            position: relative;
            animation: hexRotate 2s linear infinite;
        }

        @keyframes hexRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .hexagon-inner {
            width: 100%;
            height: 100%;
            position: absolute;
            background: var(--color-primary);
            clip-path: polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%);
            animation: hexPulse 1.5s ease-in-out infinite;
        }

        @keyframes hexPulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(0.9);
                opacity: 0.7;
            }
        }

        /* Orbiting particles */
        .orbit-particle {
            position: absolute;
            width: 8px;
            height: 8px;
            background: var(--color-primary);
            border-radius: 50%;
            box-shadow: 0 0 20px var(--color-primary);
        }

        .orbit-1 {
            top: 50%;
            left: 50%;
            animation: orbit1 3s linear infinite;
        }

        .orbit-2 {
            top: 50%;
            left: 50%;
            animation: orbit2 3s linear infinite;
            animation-delay: -1s;
        }

        .orbit-3 {
            top: 50%;
            left: 50%;
            animation: orbit3 3s linear infinite;
            animation-delay: -2s;
        }

        @keyframes orbit1 {
            0% {
                transform: translate(-50%, -50%) rotate(0deg) translateX(80px) rotate(0deg);
            }
            100% {
                transform: translate(-50%, -50%) rotate(360deg) translateX(80px) rotate(-360deg);
            }
        }

        @keyframes orbit2 {
            0% {
                transform: translate(-50%, -50%) rotate(120deg) translateX(80px) rotate(-120deg);
            }
            100% {
                transform: translate(-50%, -50%) rotate(480deg) translateX(80px) rotate(-480deg);
            }
        }

        @keyframes orbit3 {
            0% {
                transform: translate(-50%, -50%) rotate(240deg) translateX(80px) rotate(-240deg);
            }
            100% {
                transform: translate(-50%, -50%) rotate(600deg) translateX(80px) rotate(-600deg);
            }
        }

        /* Loading text */
        .loading-text {
            position: absolute;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            font-family: var(--font-heading);
            color: var(--color-white);
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.3em;
            text-transform: uppercase;
        }

        .loading-text span {
            display: inline-block;
            animation: textWave 1.5s ease-in-out infinite;
            animation-delay: calc(var(--i) * 0.1s);
        }

        @keyframes textWave {
            0%, 100% {
                transform: translateY(0);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-10px);
                opacity: 1;
            }
        }

        /* Progress bar */
        .progress-bar-container {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 3px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, transparent, var(--color-primary), transparent);
            width: 40%;
            animation: progressSlide 1.5s ease-in-out infinite;
        }

        @keyframes progressSlide {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(350%);
            }
        }

        /* Energy rings */
        .energy-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 2px solid var(--color-primary);
            border-radius: 50%;
            opacity: 0;
            animation: ringExpand 3s ease-out infinite;
        }

        .energy-ring:nth-child(1) {
            animation-delay: 0s;
        }

        .energy-ring:nth-child(2) {
            animation-delay: 1s;
        }

        .energy-ring:nth-child(3) {
            animation-delay: 2s;
        }

        @keyframes ringExpand {
            0% {
                width: 120px;
                height: 120px;
                opacity: 0.8;
            }
            100% {
                width: 250px;
                height: 250px;
                opacity: 0;
            }
        }

        /* Global Styles */
        body {
            font-family: var(--font-body);
            background-color: var(--color-background);
            color: var(--color-text-dark);
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        body.loading {
            overflow: hidden;
        }

        @media (min-width: 1024px) {
            body {
                padding-top: 5rem;
                /* Account for fixed navbar - desktop */
            }
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-heading);
        }

        /* Custom utility classes for better maintainability */
        .btn-primary {
            background-color: var(--color-primary);
            color: var(--color-white);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .text-primary {
            color: var(--color-primary);
        }

        .text-secondary {
            color: var(--color-text-light);
        }

        .bg-primary {
            background-color: var(--color-primary);
        }

        /* Page transition animations */
        .page-enter {
            opacity: 0;
            transform: translateY(20px);
        }

        .page-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        /* Smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
        }

        /* Focus styles for accessibility */
        *:focus {
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
        }

        /* Mobile optimizations for loader */
        @media (max-width: 640px) {
            .loader-container {
                width: 200px;
                height: 200px;
            }

            .hexagon-loader {
                width: 80px;
                height: 80px;
            }

            .loading-text {
                font-size: 1.2rem;
                bottom: 60px;
            }

            .orbit-particle {
                width: 6px;
                height: 6px;
            }

            @keyframes orbit1 {
    0% {
        transform: translate(-50%, -50%) rotate(0deg) translateX(60px) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(360deg) translateX(60px) rotate(-360deg);
    }
}

@keyframes orbit2 {
    0% {
        transform: translate(-50%, -50%) rotate(0deg) translateX(60px) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(360deg) translateX(60px) rotate(-360deg);
    }
}

@keyframes orbit3 {
    0% {
        transform: translate(-50%, -50%) rotate(0deg) translateX(60px) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(360deg) translateX(60px) rotate(-360deg);
    }
}

        }
    </style>
</head>

<body class="loading">

    <!-- Unique Loading Screen -->
    <div id="loading-screen">
        <div class="loader-container">
            <!-- Energy rings -->
            <div class="energy-ring"></div>
            <div class="energy-ring"></div>
            <div class="energy-ring"></div>
            
            <!-- Hexagon spinner -->
            <div class="hexagon-loader">
                <div class="hexagon">
                    <div class="hexagon-inner"></div>
                </div>
            </div>
            
            <!-- Orbiting particles -->
            <div class="orbit-particle orbit-1"></div>
            <div class="orbit-particle orbit-2"></div>
            <div class="orbit-particle orbit-3"></div>
            
            <!-- Loading text with wave animation -->
            <div class="loading-text text-center w-full">
                <div class="mb-2">
                    <span style="--i: 0">C</span>
                    <span style="--i: 1">a</span>
                    <span style="--i: 2">m</span>
                    <span style="--i: 3">p</span>
                    <span style="--i: 4">u</span>
                    <span style="--i: 5">s</span>
                </div>
                <div>
                    <span style="--i: 6">C</span>
                    <span style="--i: 7">o</span>
                    <span style="--i: 8">n</span>
                    <span style="--i: 9">n</span>
                    <span style="--i: 10">e</span>
                    <span style="--i: 11">c</span>
                    <span style="--i: 12">t</span>
                </div>
            </div>
            
            <!-- Progress bar -->
            <div class="progress-bar-container">
                <div class="progress-bar"></div>
            </div>
        </div>
    </div>

    @include('partials.navbar')

    <main class="main-content max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" crossorigin="anonymous"></script>

    <!-- Initialize GSAP ScrollTrigger and page animations -->
    <script>
        // Register ScrollTrigger plugin if GSAP is loaded
        if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);
        }

        // Loading Screen Management
        function hideLoader() {
            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen && loadingScreen.style.display !== 'none') {
                loadingScreen.classList.add('fade-out');
                setTimeout(function() {
                    document.body.classList.remove('loading');
                    loadingScreen.style.display = 'none';
                    animatePageEntrance();
                }, 400);
            }
        }

        if (document.readyState === 'complete') {
            hideLoader();
        } else {
            window.addEventListener('load', hideLoader);
            setTimeout(hideLoader, 1200); // Fail-safe 1.2s timeout
        }

        // Page entrance animation
        function animatePageEntrance() {
            if (typeof gsap !== 'undefined') {
                try {
                    gsap.from(".main-content", {
                        opacity: 0,
                        y: 20,
                        duration: 0.6,
                        ease: "power2.out"
                    });
                    gsap.from("nav", {
                        opacity: 0,
                        y: -15,
                        duration: 0.5,
                        ease: "power2.out"
                    });
                    gsap.from("footer", {
                        opacity: 0,
                        y: 15,
                        duration: 0.5,
                        ease: "power2.out"
                    });
                } catch (e) {
                    console.warn("GSAP entrance animation skipped:", e);
                }
            }
        }

        // Refresh ScrollTrigger on window resize
        window.addEventListener('resize', () => {
            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.refresh();
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

</body>

</html>