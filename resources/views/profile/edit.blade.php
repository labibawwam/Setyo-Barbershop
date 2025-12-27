<x-app-layout>
    <div class="flex h-screen w-full overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-600/5 blur-[120px] pointer-events-none"></div>

            <div class="flex-none px-8 py-10 lg:px-12 z-20 border-b border-white/[0.03] bg-[#050505]/40 backdrop-blur-md">
                <div class="flex justify-between items-center max-w-7xl mx-auto">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-black text-white tracking-tighter flex items-center gap-3">
                            Account <span class="text-indigo-500 italic font-serif text-2xl md:text-3xl font-normal lowercase tracking-normal">settings</span>
                        </h2>
                        <p class="text-[9px] font-bold uppercase tracking-[0.3em] text-slate-500 mt-1 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                            Elite Member Control Panel
                        </p>
                    </div>
                    <div class="hidden md:block text-right">
                        <p class="text-[10px] font-black text-white uppercase tracking-widest">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] text-slate-600 uppercase italic">Authorized Access</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto custom-scroll relative z-10 px-8 lg:px-12 py-12">
                <div class="max-w-7xl mx-auto">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                        
                        <div class="lg:col-span-4 lg:sticky lg:top-0 space-y-6">
                            <div class="glass-card p-8 rounded-[2.5rem] border border-white/5 bg-white/[0.02] backdrop-blur-xl shadow-2xl">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-24 h-24 rounded-[2.2rem] bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-4xl font-black text-white shadow-2xl mb-6 animate-float">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <h3 class="text-2xl font-bold text-white tracking-tight">{{ Auth::user()->name }}</h3>
                                    <span class="px-4 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-[9px] text-indigo-400 font-black uppercase tracking-widest mt-3">
                                        {{ Auth::user()->role ?? 'Elite Member' }}
                                    </span>
                                    
                                    <div class="w-full h-px bg-white/5 my-8"></div>
                                    
                                    <div class="space-y-5 w-full">
                                        <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.2em]">
                                            <span class="text-slate-500 font-bold">Joined Since</span>
                                            <span class="text-slate-300">{{ Auth::user()->created_at->format('M Y') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.2em]">
                                            <span class="text-slate-500 font-bold">Security</span>
                                            <span class="text-green-500 font-bold">Protected</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 rounded-[2rem] bg-indigo-600/10 border border-indigo-500/20 group hover:bg-indigo-600/15 transition-all">
                                <h4 class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="2"/></svg>
                                    Security Protocol
                                </h4>
                                <p class="text-[11px] text-slate-400 leading-relaxed italic opacity-80 group-hover:opacity-100 transition-opacity">
                                    Enkripsi tingkat tinggi aktif. Data profil Anda diamankan di cloud Setyo Barbershop.
                                </p>
                            </div>
                        </div>

                        <div class="lg:col-span-8 space-y-10 pb-20">
                            
                            <section class="glass-card p-8 md:p-12 rounded-[3.5rem] border border-white/5 bg-white/[0.01] hover:bg-white/[0.02] transition-all duration-500 shadow-2xl">
                                <div class="mb-10">
                                    <h3 class="text-2xl font-bold text-white tracking-tight italic font-serif">Identity <span class="text-indigo-500">Master</span></h3>
                                    <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-widest">Update your basic member information</p>
                                </div>
                                <div class="max-w-xl">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </section>

                            <section class="glass-card p-8 md:p-12 rounded-[3.5rem] border border-white/5 bg-white/[0.01] hover:bg-white/[0.02] transition-all duration-500 shadow-2xl">
                                <div class="mb-10">
                                    <h3 class="text-2xl font-bold text-white tracking-tight italic font-serif">Secret <span class="text-purple-500">Access</span></h3>
                                    <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-widest">Maintain your private encryption key</p>
                                </div>
                                <div class="max-w-xl">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </section>

                            <section class="p-8 md:p-12 rounded-[3.5rem] border border-red-500/10 bg-red-500/[0.02] hover:bg-red-500/[0.04] transition-all duration-500">
                                <div class="mb-10">
                                    <h3 class="text-2xl font-bold text-red-500 tracking-tight italic font-serif uppercase tracking-tighter">Terminal <span class="text-white opacity-40">Removal</span></h3>
                                    <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-widest">Permanently disconnect your account</p>
                                </div>
                                <div class="max-w-xl">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </section>

                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-none px-8 py-6 lg:px-12 border-t border-white/[0.03] bg-[#050505]/60 backdrop-blur-xl z-20">
                <div class="flex justify-between items-center text-[9px] font-black uppercase tracking-[0.3em] text-slate-600">
                    <p>© {{ date('Y') }} Setyo Barbershop — Internal Portal</p>
                    <p class="text-indigo-500/40 italic">Cloud Synchronized Access</p>
                </div>
            </div>
        </main>
    </div>

    <style>
        /* Force full screen layout */
        body, html { 
            overflow: hidden; 
            height: 100vh; 
            width: 100vw;
            background-color: #050505; 
            -webkit-font-smoothing: antialiased;
        }

        /* Modern Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { 
            background: rgba(99, 102, 241, 0.15); 
            border-radius: 20px; 
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: rgba(99, 102, 241, 0.4); }

        /* Form Overrides to match theme */
        input[type="text"], input[type="email"], input[type="password"] {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            border-radius: 1.25rem !important;
            color: #fff !important;
            padding: 0.8rem 1.2rem !important;
            font-size: 0.875rem !important;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        input:focus {
            background: rgba(255, 255, 255, 0.06) !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.1) !important;
        }
        label {
            font-size: 0.65rem !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.2em !important;
            color: #475569 !important;
            margin-bottom: 0.75rem !important;
        }
        button[type="submit"] {
            background: linear-gradient(135deg, #6366f1, #7c3aed) !important;
            border-radius: 1.25rem !important;
            color: white !important;
            font-weight: 900 !important;
            text-transform: uppercase !important;
            font-size: 0.65rem !important;
            letter-spacing: 0.25em !important;
            padding: 1rem 2.5rem !important;
            box-shadow: 0 10px 25px -10px rgba(99, 102, 241, 0.4) !important;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
    </style>
</x-app-layout>