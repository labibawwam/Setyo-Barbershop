<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col justify-center items-center relative overflow-hidden px-8 lg:px-12">
            
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-600/5 blur-[100px] pointer-events-none"></div>
            
            <div class="w-full max-w-2xl relative z-10 flex flex-col items-center">
                
                <div class="mb-8 text-center shrink-0">
                    <h1 class="font-display text-4xl md:text-5xl font-bold text-white tracking-tight">
                        Register <span class="text-indigo-500 italic font-serif">New Artist</span>
                    </h1>
                    <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-slate-500 mt-3">
                        Master Barber Onboarding System
                    </p>
                </div>

                <div class="w-full bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[3rem] p-8 lg:p-10 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.kapsters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400 ml-1">
                                Full Name
                            </label>
                            <input 
                                type="text" 
                                name="nama"
                                placeholder="e.g. Aditya Pratama"
                                class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-5 py-3.5 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition-all duration-300"
                                required
                            >
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400 ml-1">
                                Artist Biography
                            </label>
                            <textarea 
                                name="bio" 
                                rows="3" 
                                placeholder="Describe the artist's expertise and experience..."
                                class="w-full bg-white/[0.03] border border-white/10 rounded-[1.5rem] px-5 py-4 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition-all duration-300 resize-none"
                            ></textarea>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400 ml-1">
                                Portrait Identity
                            </label>
                            <div class="relative group">
                                <input 
                                    type="file" 
                                    name="photo"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                    onchange="this.nextElementSibling.querySelector('.file-name').innerText = this.files[0].name"
                                >
                                <div class="w-full bg-white/[0.01] border-2 border-dashed border-white/10 rounded-[2rem] py-6 flex flex-col items-center justify-center group-hover:bg-white/[0.03] group-hover:border-indigo-500/40 transition-all duration-500">
                                    <div class="w-8 h-8 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400 mb-2 transition-transform group-hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                    <span class="file-name text-[10px] font-medium text-slate-500 italic tracking-wide">Professional portrait (JPG/PNG)</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button 
                                type="submit"
                                class="flex-[2] group relative px-8 py-4 bg-white text-black rounded-[1.5rem] text-[11px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-lg shadow-indigo-500/10"
                            >
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10">Confirm Registration</span>
                            </button>

                            <a 
                                href="{{ route('admin.kapsters.index') }}"
                                class="flex-1 px-8 py-4 bg-white/[0.03] border border-white/10 rounded-[1.5rem] text-center text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-all shadow-sm"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-8 opacity-40 shrink-0">
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="w-16 h-px bg-gradient-to-r from-transparent to-slate-700"></span>
                        Encrypted Management Node
                        <span class="w-16 h-px bg-gradient-to-l from-transparent to-slate-700"></span>
                    </p>
                </div>
            </div>
        </main>
    </div>

    <style>
        body, html { 
            overflow: hidden !important; 
            height: 100vh; 
            width: 100vw;
            margin: 0;
            background-color: #050505; 
        }

        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&display=swap');
        .font-display { font-family: 'Playfair Display', serif; }

        .z-10 {
            animation: centerFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes centerFadeIn {
            from { opacity: 0; transform: translateY(15px) scale(0.99); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</x-app-layout>