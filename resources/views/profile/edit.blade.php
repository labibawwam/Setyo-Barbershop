<x-app-layout>
    <div class="flex h-screen w-full overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <main class="flex-1 flex flex-col min-w-0 bg-[#f8fafc] relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-500/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-500/5 blur-[120px] pointer-events-none"></div>

            <div class="flex-none px-6 md:px-12 py-10 lg:py-12 z-20 border-b border-slate-200 bg-white/60 backdrop-blur-md">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center max-w-7xl mx-auto gap-6">
                    
                    <div class="space-y-4 w-full md:w-auto">
                        <div>
                            <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tighter flex items-center gap-3">
                                Account <span class="text-indigo-600 italic font-serif text-2xl md:text-3xl font-normal lowercase tracking-normal">settings</span>
                            </h2>
                            <p class="text-[9px] font-bold uppercase tracking-[0.3em] text-slate-400 mt-2 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                                Elite Member Control Panel
                            </p>
                        </div>

                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl font-bold text-[10px] text-slate-500 uppercase tracking-widest hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-500/50 transition-all duration-300 group shadow-sm">
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                            {{ __('Return to Hub') }}
                        </a>
                    </div>

                    <div class="flex md:flex-col items-center md:items-end gap-4 md:gap-1 w-full md:w-auto border-t border-slate-100 md:border-none pt-6 md:pt-0">
                        <div class="md:text-right flex-1 md:flex-none">
                            <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[8px] text-slate-400 uppercase italic tracking-tighter mt-1">Authorized Node Access</p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center">
                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex-1 overflow-y-auto custom-scroll relative z-10 px-8 lg:px-12 py-12">
                <div class="max-w-7xl mx-auto">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                        
                        <div class="lg:col-span-4 lg:sticky lg:top-0 space-y-6">
                            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-24 h-24 rounded-[2.2rem] bg-gradient-to-tr from-indigo-600 to-indigo-500 flex items-center justify-center text-4xl font-black text-white shadow-xl shadow-indigo-100 mb-6 animate-float">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <h3 class="text-2xl font-bold text-slate-900 tracking-tight">{{ Auth::user()->name }}</h3>
                                    <span class="px-4 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-[9px] text-indigo-600 font-black uppercase tracking-widest mt-3">
                                        {{ Auth::user()->role ?? 'Elite Member' }}
                                    </span>
                                    
                                    <div class="w-full h-px bg-slate-100 my-8"></div>
                                    
                                    <div class="space-y-5 w-full">
                                        <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.2em]">
                                            <span class="text-slate-400 font-bold">Joined Since</span>
                                            <span class="text-slate-700">{{ Auth::user()->created_at->format('M Y') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.2em]">
                                            <span class="text-slate-400 font-bold">Security</span>
                                            <span class="text-emerald-600 font-bold">Protected</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 rounded-[2rem] bg-indigo-50 border border-indigo-100 group transition-all">
                                <h4 class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="2"/></svg>
                                    Security Protocol
                                </h4>
                                <p class="text-[11px] text-slate-500 leading-relaxed italic">
                                    Enkripsi tingkat tinggi aktif. Data profil Anda diamankan di sistem kami.
                                </p>
                            </div>
                        </div>

                        <div class="lg:col-span-8 space-y-10 pb-20">
                            
                            <section class="bg-white p-8 md:p-12 rounded-[3.5rem] border border-slate-200 shadow-sm transition-all duration-500">
                                <div class="mb-10">
                                    <h3 class="text-2xl font-bold text-slate-900 tracking-tight italic font-serif">Identity <span class="text-indigo-600">Master</span></h3>
                                    <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest">Update your basic member information</p>
                                </div>
                                <div class="max-w-xl">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </section>

                            <section class="bg-white p-8 md:p-12 rounded-[3.5rem] border border-slate-200 shadow-sm transition-all duration-500">
                                <div class="mb-10">
                                    <h3 class="text-2xl font-bold text-slate-900 tracking-tight italic font-serif">Secret <span class="text-purple-600">Access</span></h3>
                                    <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest">Maintain your private encryption key</p>
                                </div>
                                <div class="max-w-xl">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </section>

                            <section class="p-8 md:p-12 rounded-[3.5rem] border border-red-100 bg-red-50/50 transition-all duration-500">
                                <div class="mb-10">
                                    <h3 class="text-2xl font-bold text-red-600 tracking-tight italic font-serif uppercase tracking-tighter">Terminal <span class="text-slate-400">Removal</span></h3>
                                    <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest">Permanently disconnect your account</p>
                                </div>
                                <div class="max-w-xl">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </section>

                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-none px-8 py-6 lg:px-12 border-t border-slate-100 bg-white z-20">
                <div class="flex justify-between items-center text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">
                    <p>© {{ date('Y') }} Setyo Barbershop — Internal Portal</p>
                    <p class="text-indigo-600/60 italic">Cloud Synchronized Access</p>
                </div>
            </div>
        </main>
    </div>

    <style>
        body, html { 
            overflow: hidden; 
            height: 100vh; 
            width: 100vw;
            background-color: #f8fafc; 
            -webkit-font-smoothing: antialiased;
        }

        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { 
            background: rgba(99, 102, 241, 0.1); 
            border-radius: 20px; 
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: rgba(99, 102, 241, 0.2); }

        /* Form Overrides Light Mode */
        input[type="text"], input[type="email"], input[type="password"] {
            background: #f1f5f9 !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 1rem !important;
            color: #1e293b !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.875rem !important;
            transition: all 0.3s ease !important;
        }
        input:focus {
            background: #ffffff !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
            outline: none !important;
        }
        label {
            font-size: 0.65rem !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            color: #64748b !important;
            margin-bottom: 0.5rem !important;
        }
        button[type="submit"] {
            background: #4f46e5 !important;
            border-radius: 1rem !important;
            color: white !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            font-size: 0.65rem !important;
            letter-spacing: 0.15em !important;
            padding: 0.75rem 2rem !important;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3) !important;
            border: none !important;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        button[type="submit"]:hover {
            background: #4338ca !important;
            transform: translateY(-1px);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
    </style>
</x-app-layout>