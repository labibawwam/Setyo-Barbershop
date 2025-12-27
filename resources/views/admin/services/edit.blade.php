<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col justify-center items-center relative overflow-hidden px-8 lg:px-16">
            
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-purple-600/5 blur-[100px] pointer-events-none"></div>
            
            <div class="w-full max-w-2xl relative z-10 flex flex-col items-center">
                
                <div class="mb-6 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-4xl font-bold text-white tracking-tight leading-tight">
                        Update <span class="text-indigo-500 italic font-serif">Service Detail</span>
                    </h1>
                    <p class="text-[9px] font-bold uppercase tracking-[0.4em] text-slate-500 mt-2">
                        Service Configuration & Pricing Modification
                    </p>
                </div>

                <div class="w-full bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[2.5rem] p-6 lg:p-8 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                    Service Designation
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_service" 
                                    value="{{ old('nama_service', $service->nama_service) }}"
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all"
                                    required
                                >
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                    Treatment Category
                                </label>
                                <select 
                                    name="category_id" 
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer"
                                    required
                                >
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" class="bg-[#050505]" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                Brief Description
                            </label>
                            <textarea 
                                name="deskripsi"
                                rows="2"
                                class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all resize-none"
                                required
                            >{{ old('deskripsi', $service->deskripsi) }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                    Price (IDR)
                                </label>
                                <input 
                                    type="number" 
                                    name="harga" 
                                    value="{{ old('harga', $service->harga) }}"
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all"
                                    required
                                >
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                    Mins Session
                                </label>
                                <input 
                                    type="number" 
                                    name="durasi" 
                                    value="{{ old('durasi', $service->durasi) }}"
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all"
                                    required
                                >
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400 ml-1">
                                Service Visual
                            </label>
                            <div class="flex items-center gap-4 bg-white/[0.02] p-3 rounded-2xl border border-white/5">
                                @if($service->gambar)
                                <div class="shrink-0">
                                    <img src="{{ asset('storage/' . $service->gambar) }}?v={{ $service->updated_at->timestamp }}"
                                         class="w-12 h-12 rounded-lg object-cover border border-indigo-500/30">
                                </div>
                                @endif

                                <div class="relative flex-1 group/upload">
                                    <input 
                                        type="file" 
                                        name="gambar"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                        onchange="this.nextElementSibling.innerText = this.files[0].name"
                                    >
                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest border border-dashed border-white/10 rounded-lg py-3 px-4 text-center group-hover/upload:border-indigo-500 transition-all">
                                        {{ $service->gambar ? 'Replace Current Media' : 'Upload Visual Media' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button 
                                type="submit"
                                class="flex-[2] group relative px-6 py-3.5 bg-white text-black rounded-xl text-[10px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-lg shadow-indigo-500/10"
                            >
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10 text-center w-full">Commit Changes</span>
                            </button>

                            <a 
                                href="{{ route('admin.services.index') }}"
                                class="flex-1 px-6 py-3.5 bg-white/[0.03] border border-white/10 rounded-xl text-center text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-all shadow-sm"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-6 opacity-30 shrink-0">
                    <p class="text-[8px] font-bold text-slate-500 uppercase tracking-[0.5em] flex items-center justify-center gap-3">
                        <span class="w-8 h-px bg-slate-700"></span>
                        Service Catalog Sync
                        <span class="w-8 h-px bg-slate-700"></span>
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
            from { opacity: 0; transform: scale(0.99); }
            to { opacity: 1; transform: scale(1); }
        }

        select option {
            background-color: #050505;
            color: white;
        }
    </style>
</x-app-layout>