<div class="relative">
    <div x-show="isSidebarOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="isSidebarOpen = false" 
         class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm md:hidden"
         style="display: none;">
    </div>

    <aside 
        :class="isSidebarOpen ? 'w-72 translate-x-0' : '-translate-x-full md:translate-x-0 md:w-24'"
        class="fixed md:relative inset-y-0 left-0 z-50 bg-[#050505] border-r border-white/[0.05] p-4 md:p-6 transition-all duration-300 ease-in-out h-screen overflow-hidden flex flex-col">
        
        <div class="absolute top-0 left-0 w-full h-32 bg-indigo-600/5 blur-[50px] pointer-events-none"></div>

        <div class="mb-8 relative z-10">
            <div class="flex justify-end md:hidden mb-4">
                <button @click="isSidebarOpen = false" class="p-2 text-slate-500 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-4 focus:outline-none min-w-0">
                    <div class="relative shrink-0">
                        <div class="absolute inset-0 bg-indigo-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-40 transition-all duration-700"></div>
                        <div class="relative bg-gradient-to-br from-indigo-600/20 to-purple-600/20 border border-white/10 p-2.5 rounded-2xl backdrop-blur-md transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                             <x-application-logo class="h-7 w-auto text-white" />
                        </div>
                    </div>
                    
                    <div x-show="isSidebarOpen" 
                         x-transition:enter="transition delay-150 duration-300 opacity-0" 
                         x-transition:enter-end="opacity-100" 
                         class="min-w-0">
                        <p class="text-white font-black tracking-tighter text-xl leading-none uppercase">
                            SETYO <span class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent italic font-serif font-light lowercase">Panel</span>
                        </p>
                    </div>
                </a>

                <button @click="isSidebarOpen = !isSidebarOpen" 
                        class="hidden md:flex p-2 rounded-xl bg-white/5 border border-white/10 text-indigo-400 hover:bg-indigo-500 hover:text-white transition-all active:scale-95 shadow-lg">
                    <svg class="w-4 h-4 transition-transform duration-500" :class="{'rotate-180': !isSidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="isSidebarOpen" x-transition.opacity class="mb-4 px-4 relative z-10 hidden md:block">
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.4em]">Management</p>
        </div>

        <nav class="space-y-1.5 relative z-10 flex-1 overflow-y-auto custom-scroll pr-1">
            @php
                $menus = [
                    ['name' => 'User Management', 'route' => 'admin.users.index', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ['name' => 'Kapster', 'route' => 'admin.kapsters.index', 'icon' => 'M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758L5 19m0-14l4.121 4.121M12 12L9.121 9.121'],
                    ['name' => 'Kapster Shifts', 'route' => 'admin.kapster_shifts.index', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['name' => 'Service Menu', 'route' => 'admin.services.index', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                    ['name' => 'Bookings List', 'route' => 'admin.bookings.index', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['name' => 'Operating Report', 'route' => 'admin.reports.index', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1.01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ];
            @endphp

            @foreach($menus as $menu)
                @php $isActive = request()->routeIs($menu['route'] . '*'); @endphp
                <a href="{{ route($menu['route']) }}" 
                   class="group flex items-center p-3 rounded-2xl transition-all duration-300 {{ $isActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-gray-500 hover:bg-white/[0.03] hover:text-white' }}">
                    <div class="flex items-center justify-center w-10 h-10 shrink-0 rounded-xl transition-all duration-300 {{ $isActive ? 'bg-white/20 text-white' : 'bg-white/5 group-hover:bg-indigo-500/20 text-gray-600 group-hover:text-indigo-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="{{ $menu['icon'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <span x-show="isSidebarOpen" x-transition:enter="transition delay-150 duration-200 opacity-0" class="ms-4 text-[13px] font-bold tracking-tight whitespace-nowrap">{{ $menu['name'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="mt-auto pt-6 space-y-3 relative z-20">
            <x-dropdown align="right" width="64">
                <x-slot name="trigger">
                    <button class="w-full flex items-center gap-3 p-2 rounded-2xl bg-white/[0.03] border border-white/[0.05] hover:bg-white/[0.06] transition-all group">
                        <div class="shrink-0 w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-black text-sm shadow-lg group-hover:scale-95 transition-transform">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div x-show="isSidebarOpen" x-transition:enter="transition delay-150 duration-200 opacity-0" class="text-left flex-1 min-w-0">
                            <p class="text-[11px] font-black text-white truncate leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[7px] text-slate-500 font-bold uppercase mt-1 tracking-widest">Administrator</p>
                        </div>
                        <svg x-show="isSidebarOpen" class="w-3 h-3 text-slate-600 group-hover:text-indigo-400 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7" stroke-width="3"/></svg>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <div class="mb-2 bg-[#0a0a0a] border border-white/[0.08] rounded-2xl overflow-hidden backdrop-blur-3xl p-1 shadow-2xl">
                        <x-dropdown-link :href="route('profile.edit')" class="text-[10px] font-bold text-slate-400 hover:text-white rounded-xl py-3 transition-all">Identity Settings</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="text-[10px] font-bold text-red-500 hover:bg-red-500/10 rounded-xl py-3 transition-all" onclick="event.preventDefault(); this.closest('form').submit();">Terminate Session</x-dropdown-link>
                        </form>
                    </div>
                </x-slot>
            </x-dropdown>

            <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/[0.05] text-center backdrop-blur-md shadow-inner">
                <p x-show="isSidebarOpen" x-transition:enter="transition delay-200 opacity-0" class="text-[9px] font-black text-gray-600 uppercase mb-1 tracking-widest">Status</p>
                <p class="text-[10px] font-bold text-indigo-400" x-text="isSidebarOpen ? 'GOLD EDITION V.2.1' : 'V.2.1'"></p>
            </div>
        </div>
    </aside>
</div>