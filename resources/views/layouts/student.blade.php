<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'CampusConnect')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#c5010f',
                        background: '#f8fafc',
                        'text-dark': '#1e293b',
                        'text-light': '#64748b',
                    },
                    fontFamily: {
                        heading: 'Poppins, sans-serif',
                        body: 'Roboto, sans-serif'
                    }
                }
            }
        }
    </script>
    <style>
        /* Mobile-app like constraints */
        html, body {
            margin: 0;
            padding: 0;
            width: 100vw;
            overflow-x: hidden;
            background-color: #f8fafc;
            -webkit-tap-highlight-color: transparent;
        }

        /* Hide scrollbar for clean look */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="font-body text-text-dark bg-background pb-20 pt-16">

    {{-- Native Top App Bar --}}
    <header class="fixed top-0 left-0 right-0 h-16 bg-white shadow-sm z-40 px-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            {{-- Hamburger or Logo --}}
            <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold">
                C
            </div>
            <h1 class="font-heading font-bold text-lg text-text-dark">CampusConnect</h1>
        </div>
        <div class="flex items-center gap-3">
            <button class="relative w-10 h-10 rounded-full flex items-center justify-center hover:bg-gray-100 active:bg-gray-200 transition-colors">
                <span class="text-xl">🔔</span>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
            </button>
        </div>
    </header>

    {{-- Main Content Area --}}
    <main class="w-full">
        @yield('content')
    </main>

    {{-- Native Bottom Navigation --}}
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-gray-100 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-50 flex justify-around items-center px-2 pb-safe">
        <a href="{{ url('/') }}" class="flex flex-col items-center justify-center w-16 h-full {{ request()->is('/') ? 'text-primary' : 'text-text-light' }} hover:text-primary transition-colors active:scale-95">
            <span class="text-xl mb-1">🏠</span>
            <span class="text-[10px] font-semibold">Home</span>
        </a>
        <a href="{{ route('events.index') }}" class="flex flex-col items-center justify-center w-16 h-full {{ request()->is('events*') ? 'text-primary' : 'text-text-light' }} hover:text-primary transition-colors active:scale-95">
            <span class="text-xl mb-1">📅</span>
            <span class="text-[10px] font-semibold">Events</span>
        </a>
        <a href="{{ route('my.registrations') }}" class="flex flex-col items-center justify-center w-16 h-full {{ request()->is('my-registrations') ? 'text-primary' : 'text-text-light' }} hover:text-primary transition-colors active:scale-95">
            <span class="text-xl mb-1">🎟️</span>
            <span class="text-[10px] font-semibold">My Tickets</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0 h-full">
            @csrf
            <button type="submit" class="flex flex-col items-center justify-center w-16 h-full text-text-light hover:text-red-500 transition-colors active:scale-95">
                <span class="text-xl mb-1">🚪</span>
                <span class="text-[10px] font-semibold">Logout</span>
            </button>
        </form>
    </nav>

</body>
</html>
