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
                /* Perubahan: Warna latar belakang dashboard menjadi terang (Slate 50) */
                background-color: #f8fafc; 
                font-family: 'Inter', sans-serif;
            }

            /* Perubahan: Scrollbar disesuaikan untuk tema terang agar lebih kontras */
            .custom-scroll::-webkit-scrollbar { width: 5px; }
            .custom-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
            .custom-scroll::-webkit-scrollbar-thumb { 
                background: #cbd5e1; 
                border-radius: 10px; 
            }
            .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        </style>
    </head>
    
    <body class="antialiased h-full text-slate-800">
        <div x-data="{ isSidebarOpen: true }" class="flex h-full overflow-hidden bg-white">
            
            {{ $slot }}

        </div>

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