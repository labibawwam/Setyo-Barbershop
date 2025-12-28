<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col items-center relative overflow-y-auto custom-scroll bg-[#050505] px-6 md:px-8 lg:px-12 py-10 md:py-16">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[200px] md:w-[400px] h-[200px] md:h-[400px] bg-purple-600/5 blur-[70px] md:blur-[100px] pointer-events-none"></div>

            <div class="md:hidden self-start mb-6 relative z-20">
                <button @click="isSidebarOpen = true" class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                </button>
            </div>

            <div class="w-full max-w-2xl relative z-10 flex flex-col items-center my-auto entrance-animation">
                
                <div class="mb-8 md:mb-10 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-5xl font-bold text-white tracking-tight leading-tight">
                        Register <span class="text-indigo-500 italic font-serif">New Artist</span>
                    </h1>
                    <p class="text-[8px] md:text-[10px] font-bold uppercase tracking-[0.3em] md:tracking-[0.4em] text-slate-500 mt-3">
                        Master Barber Onboarding System
                    </p>
                </div>

                <div class="w-full bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.kapsters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 md:space-y-6">
                        @csrf

                        <div class="space-y-2 group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">
                                Full Name
                            </label>
                            <input 
                                type="text" 
                                name="nama"
                                placeholder="e.g. Aditya Pratama"
                                class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3.5 md:py-4 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300"
                                required
                            >
                        </div>

                        <div class="space-y-2 group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">
                                Artist Biography
                            </label>
                            <textarea 
                                name="bio" 
                                rows="3" 
                                placeholder="Describe the artist's expertise and experience..."
                                class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3.5 md:py-4 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300 resize-none min-h-[100px]"
                            ></textarea>
                        </div>

                        <div class="space-y-2 group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">
                                Portrait Identity
                            </label>
                            <div class="relative">
                                <input 
                                    type="file" 
                                    name="photo"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                    onchange="this.nextElementSibling.querySelector('.file-name').innerText = this.files[0].name"
                                >
                                <div class="w-full bg-white/[0.01] border-2 border-dashed border-white/10 rounded-[1.5rem] md:rounded-[2rem] py-6 md:py-8 flex flex-col items-center justify-center group-hover:bg-white/[0.03] group-hover:border-indigo-500/40 transition-all duration-500">
                                    <div class="w-8 h-8 md:w-10 md:h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400 mb-2 transition-transform group-hover:scale-110">
                                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                    <span class="file-name text-[9px] md:text-[10px] font-medium text-slate-500 italic tracking-wide text-center px-4">Professional portrait (JPG/PNG)</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                            <button 
                                type="submit"
                                class="w-full sm:flex-[2] group relative px-8 py-3.5 md:py-4 bg-white text-black rounded-xl md:rounded-2xl text-[10px] md:text-[11px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-lg shadow-indigo-500/10"
                            >
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10 flex items-center justify-center gap-2">Confirm Registration</span>
                            </button>

                            <a 
                                href="{{ route('admin.kapsters.index') }}"
                                class="w-full sm:flex-1 px-8 py-3.5 md:py-4 bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl text-center text-[10px] md:text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-white hover:bg-white/5 transition-all shadow-sm"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-8 md:mt-12 opacity-30 shrink-0 mb-4">
                    <p class="text-[7px] md:text-[8px] font-bold text-slate-500 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="hidden xs:block w-10 md:w-16 h-px bg-gradient-to-r from-transparent to-slate-700"></span>
                        Authorized Node Access Only
                        <span class="hidden xs:block w-10 md:w-16 h-px bg-gradient-to-l from-transparent to-slate-700"></span>
                    </p>
                </div>
            </div>
        </main>
    </div>

    <style>
        /* Modern Scrollbar Styling */
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 10px; }
        
        body, html { 
            background-color: #050505; 
            margin: 0;
            padding: 0;
        }

        .font-display { font-family: 'Playfair Display', serif; }

        .entrance-animation {
            animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes luxuryEntrance {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Responsive spacing fix for mobile browser chrome */
        @media (max-height: 700px) {
            .entrance-animation { margin-top: 2rem; }
        }
    </style>
</x-app-layout>