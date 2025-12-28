<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col items-center relative overflow-y-auto custom-scroll bg-[#050505] px-6 md:px-12 py-10 md:py-16">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[200px] md:w-[300px] h-[200px] md:h-[300px] bg-purple-600/5 blur-[70px] md:blur-[100px] pointer-events-none"></div>

            <div class="md:hidden self-start mb-6 relative z-20">
                <button @click="isSidebarOpen = true" class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                </button>
            </div>
            
            <div class="w-full max-w-3xl relative z-10 flex flex-col items-center my-auto entrance-animation">
                
                <div class="mb-8 md:mb-10 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-5xl font-bold text-white tracking-tight leading-tight uppercase">
                        Create <span class="text-indigo-500 italic font-serif lowercase">New Service</span>
                    </h1>
                    <p class="text-[8px] md:text-[10px] font-bold uppercase tracking-[0.3em] md:tracking-[0.4em] text-slate-500 mt-3">
                        Professional Treatment Configuration
                    </p>
                </div>

                <div class="w-full bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-8 lg:p-10 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 md:space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">
                                    Service Name
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_service" 
                                    value="{{ old('nama_service') }}"
                                    placeholder="e.g. Premium Haircut"
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3 md:py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300"
                                    required
                                >
                            </div>

                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">
                                    Treatment Category
                                </label>
                                <div class="relative">
                                    <select 
                                        name="category_id" 
                                        class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3 md:py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer pr-12"
                                        required
                                    >
                                        <option value="" disabled selected class="bg-[#050505]">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" class="bg-[#050505]" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-focus-within:text-indigo-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">
                                Description
                            </label>
                            <textarea 
                                name="deskripsi"
                                rows="2"
                                placeholder="Brief treatment details..."
                                class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3 md:py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all resize-none min-h-[80px]"
                                required
                            >{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 md:gap-6">
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">
                                    Price (IDR)
                                </label>
                                <input 
                                    type="number" 
                                    name="harga" 
                                    value="{{ old('harga') }}"
                                    placeholder="50000"
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3 md:py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all"
                                    required
                                >
                            </div>
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">
                                    Session Duration (Mins)
                                </label>
                                <input 
                                    type="number" 
                                    name="durasi" 
                                    value="{{ old('durasi') }}"
                                    placeholder="30"
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3 md:py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all"
                                    required
                                >
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400 ml-1">
                                Visual Media
                            </label>
                            <div class="relative">
                                <input 
                                    type="file" 
                                    name="gambar"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                    onchange="this.nextElementSibling.querySelector('.file-name').innerText = this.files[0].name"
                                >
                                <div class="w-full bg-white/[0.01] border-2 border-dashed border-white/10 rounded-xl md:rounded-[1.5rem] py-6 md:py-8 flex flex-col items-center justify-center group-hover:bg-white/[0.03] group-hover:border-indigo-500/30 transition-all duration-500 text-center px-4">
                                    <svg class="w-6 h-6 text-indigo-400/50 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span class="file-name text-[9px] md:text-[10px] font-bold text-slate-500 uppercase tracking-widest group-hover:text-slate-300">Choose Service Image</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                            <button 
                                type="submit"
                                class="w-full sm:flex-[2] group relative px-8 py-4 bg-white text-black rounded-xl md:rounded-2xl text-[10px] md:text-[11px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-lg shadow-indigo-500/10"
                            >
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10 w-full text-center">Confirm & Save Service</span>
                            </button>

                            <a 
                                href="{{ route('admin.services.index') }}"
                                class="w-full sm:flex-1 px-8 py-4 bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl text-center text-[10px] md:text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-white hover:bg-white/5 transition-all shadow-sm"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-8 md:mt-10 opacity-30 shrink-0 text-center mb-6">
                    <p class="text-[7px] md:text-[8px] font-bold text-slate-500 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="hidden xs:block w-12 md:w-16 h-px bg-slate-700"></span>
                        Service Identity Protocol Sync
                        <span class="hidden xs:block w-12 md:w-16 h-px bg-slate-700"></span>
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

        /* Prevent Tap Highlight on Mobile */
        * { -webkit-tap-highlight-color: transparent; }
    </style>
</x-app-layout>