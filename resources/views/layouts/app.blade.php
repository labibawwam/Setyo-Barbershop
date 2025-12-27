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
            /* Mencegah scroll pada body utama */
            body, html {
                height: 100%;
                overflow: hidden; 
                background-color: #050505;
                font-family: 'Inter', sans-serif;
            }

            /* Custom scrollbar untuk area konten */
            .custom-scroll::-webkit-scrollbar {
                width: 5px;
            }
            .custom-scroll::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.02);
            }
            .custom-scroll::-webkit-scrollbar-thumb {
                background: rgba(99, 102, 241, 0.2);
                border-radius: 10px;
            }
            .custom-scroll::-webkit-scrollbar-thumb:hover {
                background: rgba(99, 102, 241, 0.5);
            }
        </style>
    </head>
    <body class="antialiased h-full">
        <div class="flex flex-col h-full">
            
            <div class="flex-none">
                @include('layouts.navigation')
            </div>

            @isset($header)
                <header class="flex-none bg-[#050505] border-b border-white/[0.05]">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 relative overflow-hidden flex">
                <div class="flex flex-1 h-full overflow-hidden">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>