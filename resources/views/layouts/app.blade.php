<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

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
    </body>
</html>