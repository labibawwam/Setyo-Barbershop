<x-app-layout>
    <div x-data="{ isSidebarOpen: false }" class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar>

            <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-hidden">
                
                <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>
                <div class="absolute bottom-0 left-1/4 w-[200px] md:w-[400px] h-[200px] md:h-[400px] bg-purple-600/5 blur-[70px] md:blur-[100px] pointer-events-none"></div>
                
                <div class="flex-none px-6 md:px-8 py-6 md:py-8 lg:px-12 border-b border-white/[0.05] bg-[#050505]/50 backdrop-blur-md z-20">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="min-w-0">
                                <h1 class="text-2xl md:text-4xl font-black text-white tracking-tight flex items-center gap-3">
                                    System <span class="text-indigo-500 italic font-serif text-xl md:text-2xl font-normal lowercase tracking-normal">dashboard</span>
                                </h1>
                                <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-slate-500 mt-1 md:mt-2 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-green-500 animate-pulse"></span>
                                    <span class="truncate">Verified Database Management</span>
                                </p>
                            </div>
                        </div>

                        <div class="hidden sm:flex items-center gap-3 px-5 py-2.5 rounded-2xl bg-white/[0.03] border border-white/5">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse shadow-[0_0_10px_rgba(34,197,94,0.5)]"></span>
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">System Active</span>
                        </div>
                    </div>
                </div>

                <div class="flex-1 overflow-hidden flex flex-col relative z-10">
                    <div class="flex-1 overflow-auto custom-scroll px-6 md:px-8 lg:px-12 py-12 overscroll-contain flex flex-col items-center justify-center">
                        <div class="w-full max-w-4xl flex flex-col items-center">
                            <div class="inline-flex items-center justify-center w-24 h-24 md:w-32 md:h-32 rounded-[2.5rem] md:rounded-[3.5rem] bg-gradient-to-tr from-indigo-600/10 via-white/[0.02] to-purple-600/10 border border-white/10 mb-8 md:mb-12 animate-float shadow-[0_0_50px_rgba(99,102,241,0.1)] relative group overflow-hidden">
                                @if(isset($user) && $user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" class="w-full h-full object-cover relative z-10">
                                @else
                                    <img src="{{ asset('gambar/setyo1.jpg') }}" class="w-full h-full object-cover relative z-10">
                                @endif
                            </div>

                            <div class="space-y-2 mb-8 text-center">
                                <h2 class="text-4xl md:text-8xl font-bold text-white tracking-tighter leading-[0.9]">Selamat Datang,</h2>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-400 animate-gradient-x italic font-serif font-light text-3xl md:text-7xl lowercase block">
                                    {{ Auth::user()->name }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4 w-full max-w-2xl px-4 mt-8">
                                <div class="p-5 bg-white/[0.02] border border-white/[0.05] rounded-[1.5rem] text-center">
                                    <p class="text-[8px] font-black uppercase tracking-[0.3em] text-slate-600 mb-1">Server</p>
                                    <p class="text-[10px] text-indigo-400 font-bold">Indonesia, JKT</p>
                                </div>
                                <div class="p-5 bg-white/[0.02] border border-white/[0.05] rounded-[1.5rem] text-center">
                                    <p class="text-[8px] font-black uppercase tracking-[0.3em] text-slate-600 mb-1">Session</p>
                                    <p class="text-[10px] text-purple-400 font-bold">{{ date('H:i') }} WIB</p>
                                </div>
                                <div class="p-5 bg-white/[0.02] border border-white/[0.05] rounded-[1.5rem] text-center">
                                    <p class="text-[8px] font-black uppercase tracking-[0.3em] text-slate-600 mb-1">Date</p>
                                    <p class="text-[10px] text-blue-400 font-bold">{{ date('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-none px-6 py-6 md:px-12 md:py-10 z-20 border-t border-white/[0.05] bg-[#050505]/50 backdrop-blur-sm">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-600">
                            <div class="flex items-center gap-4">
                                <p>© {{ date('Y') }} Setyo Barbershop</p>
                                <span class="w-[1px] h-3 bg-white/10 hidden md:block"></span>
                                <p class="text-indigo-500/40 italic">V.2.1.0 GOLD</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        </x-sidebar> </div>

    <style>
        body, html { overflow: hidden !important; height: 100vh; width: 100vw; background-color: #050505; }
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.3); border-radius: 20px; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-gradient-x { background-size: 200% 200%; animation: gradient-x 8s linear infinite; }
        @keyframes gradient-x { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
    </style>
</x-app-layout>