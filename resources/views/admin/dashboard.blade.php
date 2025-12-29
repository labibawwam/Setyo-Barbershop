<x-app-layout>
    <div x-data="{ isSidebarOpen: false }" class="flex h-screen w-full overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-hidden">
            
            <div class="lg:hidden flex items-center justify-between px-6 py-4 bg-[#050505]/50 backdrop-blur-xl border-b border-white/5 relative z-[60]">
                
                
                <button @click="isSidebarOpen = true" class="p-2 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-90 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[250px] md:w-[500px] h-[250px] md:h-[500px] bg-purple-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>

            <div class="flex-1 flex items-center justify-center px-6 md:px-12 relative z-10 overflow-y-auto custom-scrollbar">
                <div class="w-full max-w-4xl flex flex-col items-center py-12">
                    
                    <div class="inline-flex items-center justify-center w-20 h-20 md:w-32 md:h-32 rounded-[2.5rem] md:rounded-[3.5rem] bg-gradient-to-tr from-indigo-600/10 via-white/[0.02] to-purple-600/10 border border-white/10 mb-8 md:mb-12 animate-float shadow-[0_0_50px_rgba(99,102,241,0.1)] relative group overflow-hidden">
                        <div class="absolute inset-0 bg-indigo-500/5 blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        <img src="{{ asset('gambar/setyo1.jpg') }}" alt="Logo" class="w-full h-full object-cover relative z-10">
                    </div>

                    <div class="space-y-2 mb-8 text-center">
                        <h2 class="text-4xl md:text-8xl font-bold text-white tracking-tighter leading-[0.9]">
                            Selamat Datang,
                        </h2>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-400 animate-gradient-x italic font-serif font-light text-3xl md:text-7xl lowercase block">
                            {{ Auth::user()->name }}
                        </span>
                    </div>

                    <p class="text-slate-400 text-xs md:text-lg leading-relaxed max-w-xl font-light mb-8 md:mb-12 opacity-70 tracking-wide text-center px-4">
                        Otoritas penuh sistem internal <span class="text-white font-medium italic">Setyo Barbershop</span> telah aktif. Siap untuk mengelola layanan elite hari ini?
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4 w-full max-w-2xl px-4">
                        <div class="group p-4 bg-white/[0.01] border border-white/[0.05] rounded-[1.5rem] md:rounded-[2rem] transition-all duration-500 hover:bg-white/[0.03] text-center">
                            <p class="text-[8px] md:text-[9px] font-black uppercase tracking-[0.3em] text-slate-600 mb-1">Server</p>
                            <p class="text-[10px] md:text-xs text-indigo-400 font-bold">Indonesia, JKT</p>
                        </div>
                        <div class="group p-4 bg-white/[0.01] border border-white/[0.05] rounded-[1.5rem] md:rounded-[2rem] transition-all duration-500 hover:bg-white/[0.03] text-center">
                            <p class="text-[8px] md:text-[9px] font-black uppercase tracking-[0.3em] text-slate-600 mb-1">Session</p>
                            <p class="text-[10px] md:text-xs text-purple-400 font-bold">{{ date('H:i') }} WIB</p>
                        </div>
                        <div class="group p-4 bg-white/[0.01] border border-white/[0.05] rounded-[1.5rem] md:rounded-[2rem] transition-all duration-500 hover:bg-white/[0.03] text-center">
                            <p class="text-[8px] md:text-[9px] font-black uppercase tracking-[0.3em] text-slate-600 mb-1">Date</p>
                            <p class="text-[10px] md:text-xs text-blue-400 font-bold">{{ date('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-none px-6 py-6 md:px-12 md:py-10 z-20">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-600">
                    <div class="flex items-center gap-4">
                        <p>© {{ date('Y') }} Setyo Barbershop</p>
                        <span class="w-[1px] h-3 bg-white/10 hidden md:block"></span>
                        <p class="text-indigo-500/40 italic">V.2.1.0 GOLD</p>
                    </div>
                    <div class="flex items-center gap-3 glass-status px-4 py-2 rounded-full border border-white/[0.03]">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-green-500"></span>
                        </span>
                        <p class="tracking-[0.2em] text-[8px] md:text-[10px]">Cloud Synchronized</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        /* Mengizinkan scroll di mobile agar konten tidak terpotong */
        @media (max-width: 1024px) {
            body, html { overflow: auto; height: auto; }
            .flex.h-screen { height: auto; min-height: 100vh; overflow: visible; }
            main { height: auto; min-height: 100vh; overflow: visible; }
        }

        @media (min-width: 1025px) {
            body, html { overflow: hidden; height: 100vh; }
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.1); border-radius: 10px; }

        .glass-status { background: rgba(0, 0, 0, 0.2); backdrop-filter: blur(5px); }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(1deg); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }

        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 12s linear infinite;
        }
        @keyframes gradient-x {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        main { animation: fadeIn 1.2s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); filter: blur(10px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }
    </style>
</x-app-layout>