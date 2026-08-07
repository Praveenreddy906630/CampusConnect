<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Coordinator Panel - CampusConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Roboto&display=swap" rel="stylesheet">

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

        /* Global Styles */
        body {
            font-family: var(--font-body);
            background-color: var(--color-background);
            color: var(--color-text-dark);
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
        }
        
        .btn-primary:hover {
            opacity: 0.9;
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
    </style>
</head>

<body class="bg-background font-body flex overflow-x-hidden w-full">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 z-50 bg-white shadow-md h-screen fixed flex flex-col justify-between transition-all duration-300 ease-in-out -translate-x-full md:translate-x-0">
        <div>
            <!-- Logo / Toggle -->
            <div id="sidebar-header" class="flex items-center justify-between px-4 py-6 text-2xl font-heading font-bold text-text-dark transition-all duration-300">
                <a href="{{ url('/') }}" id="sidebar-title" class="hover:text-primary transition-colors whitespace-nowrap">CampusConnect</a>
                <button onclick="toggleSidebar()" class="text-2xl focus:outline-none text-text-dark hidden md:block" id="toggle-btn-sidebar">☰</button>
                <button onclick="toggleMobileSidebar()" class="text-2xl focus:outline-none text-text-dark md:hidden" id="close-btn-sidebar">✕</button>
            </div>

            <!-- Navigation -->
            <nav id="sidebar-nav" class="flex flex-col text-text-dark">
                <a href="#" data-url="{{ route('coordinator.coordinator_dashboard') }}" onclick="loadCoordinatorPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-gray-100 transition-colors">
                    <span class="text-2xl">📊</span>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="#" data-url="{{ route('coordinator.dashboard') }}" onclick="loadCoordinatorPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-gray-100 transition-colors">
                    <span class="text-2xl">🎭</span>
                    <span class="nav-text">My Events</span>
                </a>
                <form method="POST" action="{{ url('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 py-3 px-4 text-left w-full hover:bg-gray-100 transition-colors text-primary">
                        <span class="text-2xl">🚪</span>
                        <span class="nav-text">Logout</span>
                    </button>
                </form>
            </nav>
        </div>

        <!-- Footer -->
        <!-- <div id="sidebar-footer" class="p-4 text-sm text-center text-text-light transition-all font-body">
            &copy; {{ date('Y') }} CampusConnect
        </div> -->
    </aside>

    <!-- Main Content -->
    <div id="main" class="md:ml-64 flex-1 w-full min-w-0 transition-all duration-300 ease-in-out">
        <!-- Mobile Header/Toggle -->
        <div class="md:hidden flex items-center gap-4 bg-white shadow p-4 mb-4">
            <button onclick="toggleMobileSidebar()" class="text-2xl text-text-dark">☰</button>
            <span class="text-xl font-bold font-heading">CampusConnect</span>
        </div>
        <main class="p-4 md:p-8 overflow-x-auto w-full">
            <div id="coordinator-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Toggle & Page Loader -->
    <script>
        function toggleSidebar() {
            if (window.innerWidth >= 768) {
                const sidebar = document.getElementById('sidebar');
                const main = document.getElementById('main');
                const navTexts = document.querySelectorAll('.nav-text');
                const title = document.getElementById('sidebar-title');
                const footer = document.getElementById('sidebar-footer');

                const isCollapsed = sidebar.classList.contains('w-16');

                if (!isCollapsed) {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-16');
                    main.classList.remove('md:ml-64');
                    main.classList.add('md:ml-16');
                    navTexts.forEach(t => t.classList.add('hidden'));
                    title.classList.add('hidden');
                    if(footer) footer.classList.add('hidden');
                } else {
                    sidebar.classList.remove('w-16');
                    sidebar.classList.add('w-64');
                    main.classList.remove('md:ml-16');
                    main.classList.add('md:ml-64');
                    navTexts.forEach(t => t.classList.remove('hidden'));
                    title.classList.remove('hidden');
                    if(footer) footer.classList.remove('hidden');
                }
            } else {
                toggleMobileSidebar();
            }
        }

        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        }

        function loadCoordinatorPage(event, el) {
            event.preventDefault();
            const url = el.getAttribute('data-url');
            const contentDiv = document.getElementById('coordinator-content');

            // highlight active link
            document.querySelectorAll('#sidebar-nav a').forEach(link => {
                link.classList.remove('bg-gray-200', 'font-semibold');
            });
            el.classList.add('bg-gray-200', 'font-semibold');

            history.pushState({}, '', url);

            // Auto-close sidebar on mobile after clicking a link
            if (window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    sidebar.classList.add('-translate-x-full');
                }
            }

            fetch(url)
                .then(res => {
                    if (res.redirected) {
                        window.location.href = res.url;
                        return null;
                    }
                    return res.text();
                })
                .then(html => {
                    if (!html) return;
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('#coordinator-content');
                    contentDiv.innerHTML = newContent ? newContent.innerHTML : 'Page not found.';
                });
        }
    </script>
</body>

</html>