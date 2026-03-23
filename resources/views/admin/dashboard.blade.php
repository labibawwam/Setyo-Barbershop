<x-app-layout>
    <div x-data="{ isSidebarOpen: false }" class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <x-sidebar>
            <main class="flex-1 flex flex-col min-w-0 bg-[#f8fafc] relative overflow-hidden">
                
                <div class="absolute top-[-10%] right-[-5%] w-[400px] md:w-[700px] h-[400px] md:h-[700px] bg-indigo-500/[0.04] rounded-full blur-[100px] pointer-events-none animate-pulse"></div>
                <div class="absolute bottom-[-10%] left-[10%] w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-purple-500/[0.03] rounded-full blur-[100px] pointer-events-none"></div>
                
                <header class="flex-none px-6 md:px-12 py-5 border-b border-slate-200/60 bg-white/80 backdrop-blur-xl z-30">
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                                <span class="bg-indigo-600 w-2 h-8 rounded-full"></span>
                                Dasbor <span class="text-indigo-600 italic font-serif font-normal lowercase">Sistem</span>
                            </h1>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="hidden md:block text-right">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Koneksi</p>
                                <div class="flex items-center gap-2 justify-end">
                                    <span class="text-[11px] font-bold text-slate-900">Terverifikasi</span>
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)] animate-pulse"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="flex-1 overflow-auto custom-scroll relative z-10">
                    <div class="min-h-full flex flex-col items-center justify-center p-6 md:p-12">
                        
                        <div class="w-full max-w-4xl">
                            <div class="relative flex flex-col items-center">
                                
                                <div class="relative mb-8 group">
                                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-[2.5rem] md:rounded-[3.5rem] blur-xl opacity-20 group-hover:opacity-40 transition-opacity duration-500"></div>
                                    <div class="relative inline-flex items-center justify-center w-28 h-28 md:w-40 md:h-40 rounded-[2.5rem] md:rounded-[3.5rem] bg-white border-4 border-white shadow-2xl overflow-hidden animate-float">
                                        @if(isset($user) && $user->image)
                                            <img src="{{ asset('storage/' . $user->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('gambar/setyo1.jpg') }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="absolute -bottom-2 -right-2 bg-white p-2 rounded-2xl shadow-lg border border-slate-100">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </div>
                                </div>

                                <div class="text-center space-y-2 mb-12">
                                    <p class="text-xs md:text-sm font-black uppercase tracking-[0.4em] text-indigo-500/80 mb-4">Akses Administrator</p>
                                    <h2 class="text-4xl md:text-7xl font-bold text-slate-900 tracking-tighter leading-tight">
                                        Selamat Datang, 
                                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 animate-gradient-x font-serif italic font-normal px-2">
                                            {{ Auth::user()->name }}
                                        </span>
                                    </h2>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full max-w-3xl">
                                    <div class="group p-6 bg-white/60 backdrop-blur-md border border-white rounded-[2rem] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                        <div class="w-10 h-10 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Aktif Sejak</p>
                                        <p class="text-sm text-slate-900 font-bold font-mono">{{ date('H:i') }} <span class="text-[10px] text-slate-400 font-normal">WIB</span></p>
                                    </div>

                                    <div class="group p-6 bg-white/60 backdrop-blur-md border border-white rounded-[2rem] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                        <div class="w-10 h-10 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Tanggal</p>
                                        <p class="text-sm text-slate-900 font-bold font-mono">{{ date('d M Y') }}</p>
                                    </div>

                                    <div class="group p-6 bg-white/60 backdrop-blur-md border border-white rounded-[2rem] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                        <div class="w-10 h-10 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        </div>
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Privilese</p>
                                        <p class="text-sm text-emerald-600 font-bold font-mono uppercase">Full Access</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="flex-none px-8 py-6 z-20 border-t border-slate-200/60 bg-white/80 backdrop-blur-md">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">
                        <div class="flex items-center gap-4">
                            <p>© {{ date('Y') }} Setyo Barbershop</p>
                            <span class="w-[1px] h-3 bg-slate-300"></span>
                            <p class="text-indigo-500 italic">V.2.5.0 Premium White</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span>Powered by Larail & Next.js</span>
                        </div>
                    </div>
                </footer>
            </main>
        </x-sidebar> 
    </div>

    <style>
        body, html { overflow: hidden !important; height: 100vh; width: 100vw; background-color: #f8fafc; }
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
        
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-15px) rotate(2deg); } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        
        .animate-gradient-x { background-size: 200% auto; animation: gradient-x 5s ease-in-out infinite; }
        @keyframes gradient-x { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
    </style>
</x-app-layout>