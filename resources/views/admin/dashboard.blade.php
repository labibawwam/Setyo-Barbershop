<x-app-layout>
    <div class="flex h-screen w-full overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-600/5 blur-[120px] pointer-events-none"></div>

            <div class="flex-1 flex items-center justify-center px-8 lg:px-12 relative z-10">
                <div class="w-full max-w-4xl flex flex-col items-center">
                    
                    <div class="inline-flex items-center justify-center w-24 h-24 md:w-32 md:h-32 rounded-[3.5rem] bg-gradient-to-tr from-indigo-600/10 via-white/[0.02] to-purple-600/10 border border-white/10 mb-12 animate-float shadow-[0_0_50px_rgba(99,102,241,0.1)] relative group overflow-hidden">
                        <div class="absolute inset-0 rounded-[3.5rem] bg-indigo-500/5 blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        <img src="{{ asset('gambar/setyo1.jpg') }}" alt="Logo" class="w-full h-full object-cover relative z-10">
                    </div>

                    <div class="space-y-2 mb-8">
                        <h2 class="text-5xl md:text-8xl font-bold text-white tracking-tighter leading-[0.9]">
                            Selamat Datang,
                        </h2>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-indigo-400 animate-gradient-x italic font-serif font-light text-4xl md:text-7xl lowercase block">
                            {{ Auth::user()->name }}
                        </span>
                    </div>

                    <p class="text-slate-400 text-sm md:text-lg leading-relaxed max-w-xl font-light mb-12 opacity-70 tracking-wide text-center">
                        Otoritas penuh sistem internal <span class="text-white font-medium italic">Setyo Barbershop</span> telah aktif. Siap untuk mengelola layanan elite hari ini?
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full max-w-2xl">
                        <div class="group p-4 bg-white/[0.01] border border-white/[0.05] rounded-[2rem] transition-all duration-500 hover:bg-white/[0.03] text-center">
                            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-600 mb-1">Server</p>
                            <p class="text-xs text-indigo-400 font-bold">Indonesia, JKT</p>
                        </div>
                        <div class="group p-4 bg-white/[0.01] border border-white/[0.05] rounded-[2rem] transition-all duration-500 hover:bg-white/[0.03] text-center">
                            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-600 mb-1">Session</p>
                            <p class="text-xs text-purple-400 font-bold">{{ date('H:i') }} WIB</p>
                        </div>
                        <div class="group p-4 bg-white/[0.01] border border-white/[0.05] rounded-[2rem] transition-all duration-500 hover:bg-white/[0.03] text-center">
                            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-600 mb-1">Date</p>
                            <p class="text-xs text-blue-400 font-bold">{{ date('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-none px-8 py-10 lg:px-12 z-20">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] font-black uppercase tracking-widest text-slate-600">
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
                        <p class="tracking-[0.2em]">Cloud Synchronized</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        body, html { 
            overflow: hidden; 
            height: 100vh; 
            width: 100vw;
            margin: 0;
            background-color: #050505; 
            -webkit-font-smoothing: antialiased;
        }

        .glass-info { background: rgba(255, 255, 255, 0.01); backdrop-filter: blur(10px); }
        .glass-status { background: rgba(0, 0, 0, 0.2); }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
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

        main { animation: fadeIn 1.5s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.98); filter: blur(15px); }
            to { opacity: 1; transform: scale(1); filter: blur(0); }
        }
    </style>
</x-app-layout>