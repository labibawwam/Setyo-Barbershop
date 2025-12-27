<aside class="w-72 min-h-screen bg-[#050505] border-r border-white/[0.05] p-6 hidden md:block relative z-40">
    <div class="absolute top-0 left-0 w-full h-32 bg-indigo-600/5 blur-[50px] pointer-events-none"></div>

    <div class="mb-10 px-4">
        <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.4em]">Main Management</p>
    </div>

    <nav class="space-y-2 relative z-10">
        @php
            $menus = [
                ['name' => 'User Management', 'route' => 'admin.users.index', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['name' => 'Hair Artist (Kapster)', 'route' => 'admin.kapsters.index', 'icon' => 'M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758L5 19m0-14l4.121 4.121M12 12L9.121 9.121'],
                ['name' => 'Service Menu', 'route' => 'admin.services.index', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                ['name' => 'Kapster Shifts', 'route' => 'admin.kapster_shifts.index', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['name' => 'Bookings List', 'route' => 'admin.bookings.index', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                // MENU BARU: Operating Report
                ['name' => 'Operating Report', 'route' => 'admin.reports.index', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ];
        @endphp

        @foreach($menus as $menu)
            @php $isActive = request()->routeIs($menu['route'] . '*'); @endphp
            <a href="{{ route($menu['route']) }}" 
               class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 {{ $isActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-gray-500 hover:bg-white/[0.03] hover:text-white' }}">
                
                <div class="flex items-center justify-center w-10 h-10 rounded-xl mr-4 transition-all duration-300 {{ $isActive ? 'bg-white/20 text-white shadow-inner' : 'bg-white/5 text-gray-600 group-hover:bg-indigo-500/20 group-hover:text-indigo-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}"></path>
                    </svg>
                </div>

                <span class="text-[13px] font-bold tracking-tight">{{ $menu['name'] }}</span>

                @if($isActive)
                    <div class="ml-auto w-1.5 h-1.5 bg-white rounded-full shadow-[0_0_8px_#ffffff]"></div>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="absolute bottom-8 left-0 w-full px-10">
        <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/[0.05] text-center">
            <p class="text-[9px] font-black text-gray-600 uppercase tracking-widest mb-1">System Status</p>
            <p class="text-[10px] font-bold text-indigo-400">GOLD EDITION V.2.1</p>
        </div>
    </div>
</aside>