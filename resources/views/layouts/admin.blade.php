<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Admin Panel - CampusConnect</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Roboto&display=swap" rel="stylesheet">
  
  <!-- GSAP -->
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
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
            black: 'var(--color-black)',
          },
          fontFamily: {
            heading: 'var(--font-heading)',
            body: 'var(--font-body)',
          },
        },
      },
    }
  </script>

  <style>
    :root {
      --color-primary: #c5010f;
      --color-background: #ffffff;
      --color-text-dark: #333333;
      --color-text-light: #666666;
      --color-white: #ffffff;
      --color-black: #000000;

      --font-heading: 'Poppins', sans-serif;
      --font-body: 'Roboto', sans-serif;
    }
    html, body {
      max-width: 100vw;
      overflow-x: hidden;
    }
    body {
      font-family: var(--font-body);
      background-color: var(--color-background);
      color: var(--color-text-dark);
      font-size: 14px; /* Decreased default font size */
    }
    @media (min-width: 768px) {
      body {
        font-size: 16px;
      }
    }
    h1, h2, h3, h4, h5, h6 {
      font-family: var(--font-heading);
    }
    .btn-primary {
      background-color: var(--color-primary);
      color: var(--color-white);
    }
    .btn-primary:hover { opacity: 0.9; }
    .text-primary { color: var(--color-primary); }
    .text-secondary { color: var(--color-text-light); }
    .bg-primary { background-color: var(--color-primary); }
  </style>
</head>

<body class="flex bg-background overflow-x-hidden w-full">
  <!-- ✅ Preloader -->
  <div id="preloader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-[var(--color-background)]">
    <div class="flex flex-col items-center gap-4">
      <div class="w-12 h-12 border-4 border-[var(--color-primary)] border-t-transparent rounded-full animate-spin"></div>
      <p class="text-[var(--color-text-dark)] font-body font-medium">Loading...</p>
    </div>
  </div>

  <!-- Sidebar -->
    <aside id="sidebar" class="w-64 z-50 bg-white shadow-md h-screen fixed flex flex-col justify-between transition-all duration-300 ease-in-out -translate-x-full md:translate-x-0">

        <div>
            <!-- Logo / Toggle -->
            <div id="sidebar-header"
                class="flex items-center justify-between px-4 py-6 text-2xl font-bold text-text-dark font-heading">
                <a href="{{ url('/') }}" id="sidebar-title"
                    class="hover:text-primary transition-colors whitespace-nowrap">
                    CampusConnect
                </a>
                <button onclick="toggleSidebar()" class="text-2xl focus:outline-none text-text-dark hidden md:block" id="toggle-btn-sidebar">☰</button>
                <button onclick="toggleMobileSidebar()" class="text-2xl focus:outline-none text-text-dark md:hidden" id="close-btn-sidebar">✕</button>
            </div>

            <!-- Navigation -->
            <nav id="sidebar-nav" class="flex flex-col text-text-dark font-body">

                <a href="#" data-url="{{ url('admin/dashboard') }}" onclick="loadAdminPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-primary hover:text-white transition rounded-md">
                    <span class="text-xl">📊</span>
                    <span class="nav-text">Dashboard</span>
                </a>

                <a href="#" data-url="{{ url('admin/students') }}" onclick="loadAdminPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-primary hover:text-white transition rounded-md">
                    <span class="text-xl">🙎‍♂️</span>
                    <span class="nav-text">Students</span>
                </a>

                <a href="#" data-url="{{ url('admin/users') }}" onclick="loadAdminPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-primary hover:text-white transition rounded-md">
                    <span class="text-xl">👥</span>
                    <span class="nav-text">Users</span>
                </a>

                <a href="#" data-url="{{ url('admin/events') }}" onclick="loadAdminPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-primary hover:text-white transition rounded-md">
                    <span class="text-xl">🎭</span>
                    <span class="nav-text">Events</span>
                </a>

                <a href="#" data-url="{{ url('admin/registrations') }}" onclick="loadAdminPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-primary hover:text-white transition rounded-md">
                    <span class="text-xl">📝</span>
                    <span class="nav-text">Registrations</span>
                </a>

                <a href="#" data-url="{{ url('admin/admins') }}" onclick="loadAdminPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-primary hover:text-white transition rounded-md">
                    <span class="text-xl">👥</span>
                    <span class="nav-text">Manage Admins</span>
                </a>

                <a href="#" data-url="{{ url('admin/coordinators') }}" onclick="loadAdminPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-primary hover:text-white transition rounded-md">
                    <span class="text-xl">🙎‍♂️</span>
                    <span class="nav-text">Coordinators</span>
                </a>

                <a href="#" data-url="{{ url('admin/soty') }}" onclick="loadAdminPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-primary hover:text-white transition rounded-md">
                    <span class="text-xl">🏆</span>
                    <span class="nav-text">Student of the Year</span>
                </a>

                <a href="#" data-url="{{ url('admin/settings') }}" onclick="loadAdminPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-primary hover:text-white transition rounded-md">
                    <span class="text-xl">⚙️</span>
                    <span class="nav-text">Settings</span>
                </a>

                <a href="#" data-url="{{ url('admin/statistics') }}" onclick="loadAdminPage(event, this)"
                    class="flex items-center gap-3 py-3 px-4 hover:bg-primary hover:text-white transition rounded-md">
                    <span class="text-xl">🏆</span>
                    <span class="nav-text">Statistics</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ url('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 py-3 px-4 text-left w-full text-primary hover:bg-[#fde8e8] transition rounded-md">
                        <span class="text-xl">🚪</span>
                        <span class="nav-text">Logout</span>
                    </button>
                </form>
            </nav>
        </div>

        <!-- Footer -->
        <div id="sidebar-footer" class="p-4 text-xs text-center text-text-light font-body">
            {{ date('Y') }} | Built by CampusConnect Team 
        </div>
    </aside>

  <!-- Main Content -->
  <div id="main" class="md:ml-64 flex-1 w-full max-w-[100vw] min-w-0 transition-all duration-300 ease-in-out flex flex-col min-h-screen relative">
    
    <!-- Mobile Top App Bar -->
    <div class="md:hidden sticky top-0 z-40 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100 p-4 shrink-0 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <button onclick="toggleMobileSidebar()" class="text-2xl text-text-dark w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
          ☰
        </button>
        <span class="text-xl font-bold font-heading truncate tracking-tight text-gray-900">CampusConnect</span>
      </div>
      <div>
        <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors text-xl relative">
          🔔
          <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
        </button>
      </div>
    </div>

    <!-- The pb-20 prevents content from hiding behind the bottom nav -->
    <main class="p-4 md:p-8 w-full max-w-full flex-1 overflow-x-hidden pb-24 md:pb-8">
      <div id="admin-content" class="w-full max-w-full overflow-x-auto">
        @yield('content')
      </div>
    </main>
  </div>

  <!-- Mobile Bottom Navigation -->
  <nav class="md:hidden fixed bottom-0 w-full bg-white/95 backdrop-blur-lg border-t border-gray-200 flex justify-around items-center h-16 z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.05)] pb-safe">
    <a href="{{ url('admin/dashboard') }}" class="flex flex-col items-center justify-center w-full h-full text-primary">
      <span class="text-2xl mb-1">🏠</span>
      <span class="text-[10px] font-medium font-body leading-none">Home</span>
    </a>
    <a href="{{ url('admin/events') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-500 hover:text-primary transition-colors">
      <span class="text-2xl mb-1">📅</span>
      <span class="text-[10px] font-medium font-body leading-none">Events</span>
    </a>
    <a href="{{ url('admin/registrations') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-500 hover:text-primary transition-colors">
      <span class="text-2xl mb-1">📝</span>
      <span class="text-[10px] font-medium font-body leading-none">Activity</span>
    </a>
    <a href="{{ url('admin/settings') }}" class="flex flex-col items-center justify-center w-full h-full text-gray-500 hover:text-primary transition-colors">
      <span class="text-2xl mb-1">👤</span>
      <span class="text-[10px] font-medium font-body leading-none">Profile</span>
    </a>
  </nav>

  <!-- ✅ Preloader Script -->
  <script>
    window.onload = () => {
      const preloader = document.getElementById("preloader");

      gsap.to(preloader, {
        opacity: 0,
        duration: 0.8,
        ease: "power2.out",
        onComplete: () => preloader.remove()
      });

      gsap.from("main", {
        y: 40,
        opacity: 0,
        duration: 1,
        delay: 0.5,
        ease: "power3.out"
      });
    };
  </script>

  <!-- ✅ Sidebar + Page Loader -->
  <script>
    function toggleSidebar() {
      // Desktop toggle (w-64 to w-16)
      if (window.innerWidth >= 768) {
          const sidebar = document.getElementById('sidebar');
          const main = document.getElementById('main');
          const navTexts = document.querySelectorAll('.nav-text');
          const title = document.getElementById('sidebar-title');
          const footer = document.getElementById('sidebar-footer');

          const isCollapsed = sidebar.classList.contains('w-16');
          if (!isCollapsed) {
            sidebar.classList.replace('w-64', 'w-16');
            main.classList.replace('md:ml-64', 'md:ml-16');
            navTexts.forEach(t => t.classList.add('hidden'));
            title.classList.add('hidden');
            if (footer) footer.classList.add('hidden');
          } else {
            sidebar.classList.replace('w-16', 'w-64');
            main.classList.replace('md:ml-16', 'md:ml-64');
            navTexts.forEach(t => t.classList.remove('hidden'));
            title.classList.remove('hidden');
            if (footer) footer.classList.remove('hidden');
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

    function loadAdminPage(event, el) {
      event.preventDefault();
      const url = el.getAttribute('data-url');
      const contentDiv = document.getElementById('admin-content');

      document.querySelectorAll('#sidebar-nav a').forEach(link => {
        link.classList.remove('bg-[#f0f0f0]', 'font-semibold');
      });
      el.classList.add('bg-[#f0f0f0]', 'font-semibold');

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
          const newContent = doc.querySelector('#admin-content');
          contentDiv.innerHTML = newContent ? newContent.innerHTML : 'Page not found.';
        });
    }
  </script>
</body>
</html>
