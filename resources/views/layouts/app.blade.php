<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/hamburger.js'])

        <style>
            body, html {
                height: 100%;
                overflow: hidden; 
                background-color: #050505;
                font-family: 'Inter', sans-serif;
            }

            .custom-scroll::-webkit-scrollbar { width: 4px; }
            .custom-scroll::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); }
            .custom-scroll::-webkit-scrollbar-thumb { 
                background: rgba(99, 102, 241, 0.2); 
                border-radius: 10px; 
            }
            .custom-scroll::-webkit-scrollbar-thumb:hover { background: rgba(99, 102, 241, 0.5); }
        </style>
    </head>
    <body class="antialiased h-full text-slate-300">
        <div x-data="{ isSidebarOpen: true }" class="flex h-full overflow-hidden">
            
            {{ $slot }}

        </div>

    <!-- load Alpine and init store -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('sidebar', {
            isOpen: window.innerWidth >= 768,
            toggle() { this.isOpen = !this.isOpen },
            open() { this.isOpen = true },
            close() { this.isOpen = false },
        });

        window.addEventListener('resize', () => {
            Alpine.store('sidebar').isOpen = window.innerWidth >= 768;
        });

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') Alpine.store('sidebar').isOpen = false;
        });
    });
    </script>
    </body>
</html>