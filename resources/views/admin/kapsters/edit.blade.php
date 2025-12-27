<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col justify-center items-center relative overflow-hidden px-12 lg:px-20">
            
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-600/5 blur-[100px] pointer-events-none"></div>
            
            <div class="w-full max-w-2xl relative z-10">
                
                <div class="mb-10 text-center">
                    <h1 class="font-display text-4xl md:text-5xl font-bold text-white tracking-tight leading-tight">
                        Update <span class="text-indigo-500 italic font-serif">Artist Data</span>
                    </h1>
                    <div class="flex items-center justify-center gap-3 mt-4">
                        <span class="h-px w-8 bg-indigo-500/30"></span>
                        <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-slate-500">
                            Elite Barber Profile Modification
                        </p>
                        <span class="h-px w-8 bg-indigo-500/30"></span>
                    </div>
                </div>

                <div class="bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[3rem] p-10 lg:p-12 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.kapsters.update', $kapster->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="group space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                Full Name
                            </label>
                            <input 
                                type="text" 
                                name="nama"
                                value="{{ old('nama', $kapster->nama) }}"
                                placeholder="e.g. Aditya Pratama"
                                class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-500"
                                required
                            >
                        </div>

                        <div class="group space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                Artist Biography
                            </label>
                            <textarea 
                                name="bio" 
                                rows="3" 
                                placeholder="Describe the artist's expertise and experience..."
                                class="w-full bg-white/[0.03] border border-white/10 rounded-[1.5rem] px-6 py-4 text-sm text-white placeholder-slate-600 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-500 resize-none"
                            >{{ old('bio', $kapster->bio) }}</textarea>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400 ml-1">
                                Artist Portrait
                            </label>
                            
                            <div class="flex items-center gap-8">
                                @if($kapster->photo)
                                    <div class="shrink-0 relative group/img">
                                        <img src="{{ asset('storage/' . $kapster->photo) }}?v={{ $kapster->updated_at->timestamp }}"
                                             class="w-24 h-24 rounded-2xl object-cover border-2 border-indigo-500/30 shadow-[0_0_20px_rgba(99,102,241,0.2)] group-hover/img:border-indigo-500 transition-all duration-500">
                                        <div class="absolute inset-0 rounded-2xl bg-indigo-600/10 opacity-0 group-hover/img:opacity-100 transition-opacity"></div>
                                    </div>
                                @endif

                                <div class="relative group/upload flex-1">
                                    <input 
                                        type="file" 
                                        name="photo"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                        onchange="this.nextElementSibling.querySelector('.file-name').innerText = this.files[0].name"
                                    >
                                    <div class="w-full bg-white/[0.01] border-2 border-dashed border-white/5 rounded-[1.5rem] py-6 flex flex-col items-center justify-center group-hover/upload:bg-white/[0.03] group-hover/upload:border-indigo-500/30 transition-all duration-700">
                                        <div class="w-10 h-10 bg-indigo-500/5 rounded-xl flex items-center justify-center text-indigo-400/50 mb-2 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                        <span class="file-name text-[10px] font-bold text-slate-500 uppercase tracking-widest group-hover/upload:text-slate-300 text-center px-4">Change Portrait</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-6 pt-4">
                            <button 
                                type="submit"
                                class="flex-[2] group relative px-8 py-5 bg-white text-black rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all hover:shadow-[0_0_30px_rgba(99,102,241,0.3)] active:scale-95 overflow-hidden"
                            >
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10">Save Profile Updates</span>
                            </button>

                            <a 
                                href="{{ route('admin.kapsters.index') }}"
                                class="flex-1 px-8 py-5 bg-white/[0.03] border border-white/10 rounded-2xl text-center text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-white hover:bg-white/5 transition-all shadow-sm"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-10 text-center">
                    <p class="text-[9px] font-bold text-slate-600 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="w-16 h-px bg-gradient-to-r from-transparent to-slate-700"></span>
                        Executive Profile Management
                        <span class="w-16 h-px bg-gradient-to-l from-transparent to-slate-700"></span>
                    </p>
                </div>
            </div>
        </main>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&display=swap');
        
        body, html { 
            overflow: hidden !important; 
            height: 100vh; 
            width: 100vw;
            margin: 0;
            background-color: #050505; 
        }

        .font-display { font-family: 'Playfair Display', serif; }

        .z-10 {
            animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes luxuryEntrance {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</x-app-layout>