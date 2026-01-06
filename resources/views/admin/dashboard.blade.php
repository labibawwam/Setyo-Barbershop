<x-app-layout>
    <div x-data="{ isSidebarOpen: false }" class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <x-sidebar>

            <main class="flex-1 flex flex-col min-w-0 bg-[#f8fafc] relative overflow-hidden">
                
                <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-500/[0.03] blur-[80px] md:blur-[120px] pointer-events-none"></div>
                <div class="absolute bottom-0 left-1/4 w-[200px] md:w-[400px] h-[200px] md:h-[400px] bg-purple-500/[0.02] blur-[70px] md:blur-[100px] pointer-events-none"></div>
                
                <div class="flex-none px-6 md:px-8 py-6 md:py-8 lg:px-12 border-b border-slate-200 bg-white/70 backdrop-blur-md z-20">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="min-w-0">
                                <h1 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                                    System <span class="text-indigo-600 italic font-serif text-xl md:text-2xl font-normal lowercase tracking-normal">dashboard</span>
                                </h1>
                                <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-slate-400 mt-1 md:mt-2 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.4)]"></span>
                                    <span class="truncate">Verified Database Management</span>
                                </p>
                            </div>
                        </div>

                       
                    </div>
                </div>

                <div class="flex-1 overflow-hidden flex flex-col relative z-10">
                    <div class="flex-1 overflow-auto custom-scroll px-6 md:px-8 lg:px-12 py-12 overscroll-contain flex flex-col items-center justify-center">
                        <div class="w-full max-w-4xl flex flex-col items-center">
                            
                            <div class="inline-flex items-center justify-center w-24 h-24 md:w-32 md:h-32 rounded-[2.5rem] md:rounded-[3.5rem] bg-white border border-slate-200 mb-8 md:mb-12 animate-float shadow-xl shadow-slate-200 relative group overflow-hidden">
                                @if(isset($user) && $user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" class="w-full h-full object-cover relative z-10">
                                @else
                                    <img src="{{ asset('gambar/setyo1.jpg') }}" class="w-full h-full object-cover relative z-10">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500/10 to-transparent"></div>
                            </div>

                            <div class="space-y-2 mb-8 text-center">
                                <h2 class="text-4xl md:text-8xl font-bold text-slate-900 tracking-tighter leading-[0.9]">Selamat Datang,</h2>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 animate-gradient-x italic font-serif font-light text-3xl md:text-7xl lowercase block">
                                    {{ Auth::user()->name }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4 w-full max-w-2xl px-4 mt-8">
                                <div class="p-5 bg-white border border-slate-200 rounded-[1.5rem] text-center shadow-sm hover:shadow-md transition-shadow">
                                    <p class="text-[8px] font-black uppercase tracking-[0.3em] text-slate-400 mb-1">Session</p>
                                    <p class="text-[11px] text-indigo-600 font-bold font-mono">{{ date('H:i') }} WIB</p>
                                </div>
                                <div class="p-5 bg-white border border-slate-200 rounded-[1.5rem] text-center shadow-sm hover:shadow-md transition-shadow">
                                    <p class="text-[8px] font-black uppercase tracking-[0.3em] text-slate-400 mb-1">Date</p>
                                    <p class="text-[11px] text-slate-900 font-bold font-mono">{{ date('d M Y') }}</p>
                                </div>
                                <div class="p-5 bg-white border border-slate-200 rounded-[1.5rem] text-center shadow-sm hover:shadow-md transition-shadow">
                                    <p class="text-[8px] font-black uppercase tracking-[0.3em] text-slate-400 mb-1">Role</p>
                                    <p class="text-[11px] text-purple-600 font-bold font-mono">ADMINISTRATOR</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-none px-6 py-6 md:px-12 md:py-10 z-20 border-t border-slate-200 bg-white/50 backdrop-blur-sm">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400">
                            <div class="flex items-center gap-4">
                                <p>© {{ date('Y') }} Setyo Barbershop</p>
                                <span class="w-[1px] h-3 bg-slate-200 hidden md:block"></span>
                                <p class="text-indigo-500/60 italic font-bold">V.2.1.0 WHITE</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        </x-sidebar> 
    </div>

    <style>
        body, html { overflow: hidden !important; height: 100vh; width: 100vw; background-color: #f8fafc; }
        
        /* Scrollbar Soft */
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 20px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        
        .animate-gradient-x { background-size: 200% 200%; animation: gradient-x 8s linear infinite; }
        @keyframes gradient-x { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>