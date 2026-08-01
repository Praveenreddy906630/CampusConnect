<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
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
    body {
      font-family: var(--font-body);
      background-color: var(--color-background);
      color: var(--color-text-dark);
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

<body class="flex bg-background">
  <!-- ✅ Preloader -->
  <div id="preloader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-[var(--color-background)]">
    <div class="flex flex-col items-center gap-4">
      <div class="w-12 h-12 border-4 border-[var(--color-primary)] border-t-transparent rounded-full animate-spin"></div>
      <p class="text-[var(--color-text-dark)] font-body font-medium">Loading...</p>
    </div>
  </div>

  <!-- Sidebar -->
    <aside id="sidebar" class="w-64 z-1 bg-white shadow-md h-screen fixed flex flex-col justify-between transition-all duration-300 ease-in-out">

        <div>
            <!-- Logo / Toggle -->
            <div id="sidebar-header"
                class="flex items-center justify-between px-4 py-6 text-2xl font-bold text-text-dark font-heading">
                <a href="{{ url('/') }}" id="sidebar-title"
                    class="hover:text-primary transition-colors whitespace-nowrap">
                    CampusConnect
                </a>
                <button onclick="toggleSidebar()" class="text-2xl focus:outline-none text-text-dark" id="toggle-btn-sidebar">☰</button>
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
  <div id="main" class="ml-64 flex-1 transition-all duration-300 ease-in-out">
    <main class="p-8">
      <div id="admin-content">
        @yield('content')
      </div>
    </main>
  </div>

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
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('main');
      const navTexts = document.querySelectorAll('.nav-text');
      const title = document.getElementById('sidebar-title');
      const footer = document.getElementById('sidebar-footer');

      const isCollapsed = sidebar.classList.contains('w-16');
      if (!isCollapsed) {
        sidebar.classList.replace('w-64', 'w-16');
        main.classList.replace('ml-64', 'ml-16');
        navTexts.forEach(t => t.classList.add('hidden'));
        title.classList.add('hidden');
        if (footer) footer.classList.add('hidden');
      } else {
        sidebar.classList.replace('w-16', 'w-64');
        main.classList.replace('ml-16', 'ml-64');
        navTexts.forEach(t => t.classList.remove('hidden'));
        title.classList.remove('hidden');
        if (footer) footer.classList.remove('hidden');
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

      fetch(url)
        .then(res => res.text())
        .then(html => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const newContent = doc.querySelector('#admin-content');
          contentDiv.innerHTML = newContent ? newContent.innerHTML : 'Page not found.';
        });
    }
  </script>
</body>
</html>
