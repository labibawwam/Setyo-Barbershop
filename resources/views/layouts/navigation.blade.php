<nav x-data="{ open: false }" class="sticky top-0 z-50 backdrop-blur-3xl bg-[#050505]/70 border-b border-white/[0.03] shadow-[0_20px_50px_rgba(0,0,0,0.6)] font-sans">
    <div class="absolute inset-x-0 bottom-0 h-[1px] bg-gradient-to-r from-transparent via-indigo-500/30 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-10">
        <div class="flex justify-between h-22 py-2">

            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-5 focus:outline-none">
                    <div class="relative">
                        <div class="absolute inset-0 bg-indigo-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-40 transition-all duration-700"></div>
                        <div class="relative bg-gradient-to-br from-indigo-600/20 to-purple-600/20 border border-white/10 p-2.5 rounded-2xl backdrop-blur-md transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                             <x-application-logo class="h-9 w-auto text-white" />
                        </div>
                    </div>
                    
                    <div class="hidden lg:block">
                        <p class="text-white font-black tracking-tighter text-2xl leading-none uppercase flex items-center">
                            SETYO <span class="ms-1.5 bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent italic font-serif font-light lowercase tracking-normal transition-all duration-500 group-hover:letter-spacing-1">Panel</span>
                        </p>
                        <div class="flex items-center gap-2 mt-1.5">
                            <span class="w-1 h-1 rounded-full bg-indigo-500 animate-pulse"></span>
                            <p class="text-[8px] font-black tracking-[0.5em] text-slate-500 uppercase">Internal Command Center</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-8">
                
                <div class="hidden xl:flex items-center gap-3 px-4 py-2 bg-white/[0.02] border border-white/[0.05] rounded-2xl backdrop-blur-md group hover:bg-white/[0.05] transition-all">
                    <div class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] group-hover:text-white transition-colors">Server: Active</span>
                </div>

                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-4 p-1.5 pr-4 rounded-[1.5rem] bg-white/[0.02] border border-white/[0.05] hover:bg-white/[0.06] hover:border-indigo-500/30 transition-all duration-500 group">
                            <div class="w-11 h-11 rounded-[1.1rem] bg-gradient-to-tr from-indigo-600 via-indigo-500 to-purple-600 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-indigo-500/20 transition-all duration-500 group-hover:scale-95 group-hover:rounded-2xl">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            
                            <div class="text-left hidden md:block">
                                <p class="text-xs font-black text-white leading-none tracking-tight group-hover:text-indigo-300 transition-colors">{{ Auth::user()->name }}</p>
                                <div class="flex items-center gap-1.5 mt-1.5">
                                    <p class="text-[8px] text-slate-500 font-bold uppercase tracking-widest leading-none">Admin Node</p>
                                    <span class="text-[8px] text-indigo-500/50">•</span>
                                    <span class="text-[8px] text-indigo-400 font-black uppercase tracking-tighter italic">Verified</span>
                                </div>
                            </div>

                            <svg class="w-4 h-4 text-slate-600 group-hover:text-indigo-400 transition-all duration-300 group-hover:translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-[#0a0a0a] border border-white/[0.08] rounded-3xl overflow-hidden shadow-[0_30px_70px_rgba(0,0,0,1)] backdrop-blur-2xl">
                            <div class="px-6 py-6 bg-gradient-to-b from-white/[0.05] to-transparent border-b border-white/[0.05]">
                                <p class="text-[8px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-2">Authenticated User</p>
                                <p class="text-sm font-bold text-white truncate tracking-tight">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <div class="p-3 space-y-1.5">
                                <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-3 rounded-[1.2rem] text-[11px] font-black text-slate-400 hover:text-white hover:bg-indigo-600 transition-all duration-300 py-3.5 px-5 group/item">
                                    <svg class="w-4 h-4 opacity-50 group-hover/item:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    {{ __('Manage Identity') }}
                                </x-dropdown-link>

                                <div class="h-px bg-white/[0.05] my-2 mx-4"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" 
                                            class="flex items-center gap-3 rounded-[1.2rem] text-[11px] font-black text-red-500/80 hover:text-white hover:bg-red-500 transition-all duration-300 py-3.5 px-5 group/logout"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        <svg class="w-4 h-4 rotate-180 opacity-70 group-hover/logout:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        {{ __('Terminate Session') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-3.5 rounded-2xl bg-white/[0.03] text-indigo-400 border border-white/[0.05] transition-all active:scale-90 shadow-xl overflow-hidden group">
                    <div class="absolute inset-0 bg-indigo-500 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <svg class="h-6 w-6 relative z-10" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 8h16M8 16h12" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0 -translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-8"
         class="sm:hidden bg-[#0a0a0a] border-t border-white/[0.05] px-6 pb-12 pt-8 backdrop-blur-3xl shadow-inner">
        
        <div class="flex items-center p-6 bg-white/[0.03] rounded-[2.5rem] border border-white/[0.05] shadow-2xl mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center font-black text-white text-xl shadow-indigo-500/20 shadow-lg">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="ms-5">
                <div class="font-black text-lg text-white tracking-tight leading-none">{{ Auth::user()->name }}</div>
                <div class="font-bold text-[9px] text-indigo-400 uppercase tracking-[0.4em] mt-2 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                    Master Access
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <x-responsive-nav-link :href="route('profile.edit')" class="rounded-2xl border-none text-[11px] font-black text-slate-400 hover:text-white hover:bg-white/[0.05] uppercase tracking-[0.2em] py-5 px-8 transition-all">
                Edit Identification
            </x-responsive-nav-link>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" 
                        class="rounded-2xl border-none text-[11px] font-black text-red-500 hover:bg-red-500/10 uppercase tracking-[0.2em] py-5 px-8 transition-all"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                    Secure Disconnect
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>