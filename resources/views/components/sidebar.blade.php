<div class="flex h-screen w-full bg-[#f8fafc] text-slate-600 overflow-hidden" 
     x-data="{ isMobileOpen: false, isCollapsed: false }" 
     x-init="$watch('isMobileOpen', value => { if(value) document.body.style.overflow = 'hidden'; else document.body.style.overflow = 'auto'; })"
     x-cloak>

    <div x-show="isMobileOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         @click="isMobileOpen = false"
         class="fixed inset-0 z-[80] bg-white/60 backdrop-blur-md md:hidden">
    </div>

    <aside 
        :class="{
            'translate-x-0 w-[280px] shadow-[20px_0_50px_rgba(0,0,0,0.05)]': isMobileOpen, 
            '-translate-x-full': !isMobileOpen,
            'md:w-72': !isCollapsed,
            'md:w-24': isCollapsed
        }"
        class="fixed inset-y-0 left-0 z-[90] flex flex-col bg-white border-r border-slate-200 transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] md:relative md:translate-x-0">
        
        <div class="h-20 flex items-center px-6 shrink-0 border-b border-slate-100 relative overflow-hidden bg-white sticky top-0 z-20">
            <div class="absolute top-0 left-0 w-full h-full bg-indigo-50/50 blur-2xl"></div>
            
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4 group relative z-10 min-w-0">
                <div class="shrink-0 relative">
                    <div class="absolute inset-0 bg-indigo-400 rounded-xl blur opacity-10 group-hover:opacity-30 transition-all"></div>
                    <div class="relative bg-white border border-slate-200 p-2 rounded-xl shadow-sm transition-all group-hover:border-indigo-400 group-hover:shadow-indigo-100">
                         <x-application-logo class="h-6 w-auto text-indigo-600" />
                    </div>
                </div>
                <div x-show="!isCollapsed || isMobileOpen" x-transition:enter="delay-150 duration-300" class="min-w-0 transition-opacity">
                    <p class="text-slate-900 font-black tracking-tighter text-lg uppercase leading-none">
                        SETYO <span class="text-indigo-600 italic font-serif font-light lowercase">Panel</span>
                    </p>
                </div>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto custom-scroll overscroll-contain flex flex-col">
            
            <div class="px-6 mt-8 mb-2" x-show="!isCollapsed || isMobileOpen">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.4em]">Management</p>
            </div>

            <nav class="py-2 px-3 space-y-1 relative z-10">
                @php
                    $menus = [
                        ['name' => 'User Management', 'route' => 'admin.users.index', 'icon' => 'M18 18.72a6 6 0 0 0-3.44-5.15m2.07-3.57a3 3 0 1 0-4.26-4.26m5.63 7.83a7 7 0 1 1-9.42-9.42m0 12.15a6 6 0 0 1-3.44-5.15m2.07-3.57a3 3 0 1 1-4.26-4.26m5.63 7.83a7 7 0 1 0-9.42-9.42'], 
                        ['name' => 'Kapster', 'route' => 'admin.kapsters.index', 'icon' => 'M4 19a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4ZM14 5l-2 5M10 5l2 5M12 10l-4 9M12 10l4 9'], 
                        ['name' => 'Kapster Shifts', 'route' => 'admin.kapster_shifts.index', 'icon' => 'M12 6v6l4 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                        ['name' => 'Service Menu', 'route' => 'admin.services.index', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z'],
                        ['name' => 'Bookings List', 'route' => 'admin.bookings.index', 'icon' => 'M19 4H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm-7 15l-5-5 1.41-1.41L12 16.17l7.59-7.59L21 10l-9 9Z'],
                        ['name' => 'Operating Report', 'route' => 'admin.reports.index', 'icon' => 'M3 3v18h18M7 16l4-4 4 4 6-6'],
                    ];
                @endphp

                @foreach($menus as $menu)
                    @php $isActive = request()->routeIs($menu['route'] . '*'); @endphp
                    <a href="{{ route($menu['route']) }}" 
                       title="{{ $menu['name'] }}"
                       class="group flex items-center p-3 rounded-xl transition-all duration-300 {{ $isActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <div class="flex items-center justify-center w-10 h-10 shrink-0 rounded-lg transition-all {{ $isActive ? 'bg-white/20 text-white' : 'bg-slate-100 group-hover:bg-indigo-50 text-slate-500 group-hover:text-indigo-600' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="{{ $menu['icon'] }}" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span x-show="!isCollapsed || isMobileOpen" x-transition.opacity class="ms-4 text-[13px] font-bold tracking-tight whitespace-nowrap">{{ $menu['name'] }}</span>
                    </a>
                @endforeach

                <div class="p-4 mt-auto border-t border-slate-100 bg-white">
        <x-dropdown align="right" width="64">
            <x-slot name="trigger">
                <button class="w-full flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition-all group outline-none border border-transparent hover:border-slate-200">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="shrink-0 w-10 h-10 rounded-lg bg-gradient-to-tr from-indigo-600 to-indigo-500 flex items-center justify-center text-white font-black text-sm shadow-md group-hover:scale-95 transition-transform uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        
                        <div x-show="!isCollapsed" class="text-left min-w-0 transition-all">
                            <p class="text-[11px] font-black text-slate-900 truncate uppercase leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[7px] text-slate-400 font-bold uppercase mt-1 tracking-widest">Administrator</p>
                        </div>
                    </div>

                    <div x-show="!isCollapsed" class="text-slate-400 group-hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden p-1 shadow-xl">
                    <x-dropdown-link :href="route('profile.edit')" class="text-[10px] font-bold text-slate-600 py-3 hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/></svg>
                            Identity Settings
                        </div>
                    </x-dropdown-link>

                    <div class="h-px bg-slate-100 my-1"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" 
                            class="text-[10px] font-bold text-red-500 hover:bg-red-50 transition-colors" 
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2"/></svg>
                                Terminate Session
                            </div>
                        </x-dropdown-link>
                    </form>
                </div>
            </x-slot>
        </x-dropdown>
    </div>
            </nav>

            <div class="mt-auto p-4 bg-slate-50/50 shrink-0 border-t border-slate-100">
                <div x-show="!isCollapsed || isMobileOpen" class="py-2 rounded-lg bg-white border border-slate-200 text-center shadow-sm">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-tight">WHITE EDITION V.2.1</p>
                </div>
            </div>
        </div>
    </aside>

    <div class="flex flex-col flex-1 min-w-0 overflow-hidden relative">
        
        <header class="h-20 flex items-center py-4 justify-between px-4 md:px-8 bg-white/80 backdrop-blur-xl border-b border-slate-200 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <button @click="isMobileOpen = true" 
                        class="md:hidden p-2.5 rounded-xl bg-white border border-slate-200 text-slate-600 active:scale-95 transition-all shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>

                <button @click="isCollapsed = !isCollapsed" 
                        class="hidden md:flex p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                    <svg :class="isCollapsed ? 'rotate-180' : ''" class="w-5 h-5 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
                
                <h2 class="text-[10px] md:text-sm font-bold text-slate-500 uppercase tracking-[0.2em] hidden xs:block">Management System</h2>
            </div>

            <div class="flex items-center gap-3 bg-slate-100/50 border border-slate-200 px-3 py-1.5 rounded-full">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.3)]"></div>
                <span class="text-[8px] md:text-[10px] font-bold text-slate-500 tracking-widest uppercase">Server Active</span>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto custom-scroll p-4 md:p-8 lg:p-12 relative z-10 bg-[#f8fafc]">
            <div class="max-w-[1440px] mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

<style>
    /* Scrollbar Styling Terang */
    .custom-scroll::-webkit-scrollbar { width: 5px; height: 5px; }
    .custom-scroll::-webkit-scrollbar-track { background: transparent; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scroll::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

    /* Fix iOS Safari Height */
    .h-screen { height: 100vh; height: calc(var(--vh, 1vh) * 100); }
    
    [x-cloak] { display: none !important; }
    * { -webkit-tap-highlight-color: transparent; }
</style>