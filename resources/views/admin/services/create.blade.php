<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col justify-center items-center relative overflow-hidden px-6 lg:px-12">
            
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-purple-600/5 blur-[100px] pointer-events-none"></div>
            
            <div class="w-full max-w-3xl relative z-10">
                
                <div class="mb-6 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-4xl font-bold text-white tracking-tight leading-tight">
                        Create <span class="text-indigo-500 italic font-serif">New Service</span>
                    </h1>
                    <p class="text-[9px] font-bold uppercase tracking-[0.4em] text-slate-500 mt-2">
                        Professional Treatment Configuration
                    </p>
                </div>

                <div class="bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[2.5rem] p-6 lg:p-8 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                    Service Name
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_service" 
                                    value="{{ old('nama_service') }}"
                                    placeholder="e.g. Premium Haircut"
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all duration-300"
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
                                    <option value="" disabled selected class="bg-[#050505]">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" class="bg-[#050505]" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                Description
                            </label>
                            <textarea 
                                name="deskripsi"
                                rows="2"
                                placeholder="Brief treatment details..."
                                class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all resize-none"
                                required
                            >{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                    Price (IDR)
                                </label>
                                <input 
                                    type="number" 
                                    name="harga" 
                                    value="{{ old('harga') }}"
                                    placeholder="50000"
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
                                    value="{{ old('durasi') }}"
                                    placeholder="30"
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all"
                                    required
                                >
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400 ml-1">
                                Visual Media
                            </label>
                            <div class="relative group/upload">
                                <input 
                                    type="file" 
                                    name="gambar"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                    onchange="this.nextElementSibling.querySelector('.file-name').innerText = this.files[0].name"
                                >
                                <div class="w-full bg-white/[0.01] border-2 border-dashed border-white/10 rounded-xl py-3 flex flex-col items-center justify-center group-hover/upload:bg-white/[0.03] group-hover/upload:border-indigo-500/30 transition-all duration-500">
                                    <span class="file-name text-[9px] font-bold text-slate-500 uppercase tracking-widest group-hover/upload:text-slate-300">Choose Service Image</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-2">
                            <button 
                                type="submit"
                                class="flex-[2] group relative px-8 py-3.5 bg-white text-black rounded-xl text-[10px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-lg shadow-indigo-500/10"
                            >
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10 w-full text-center">Confirm & Save</span>
                            </button>

                            <a 
                                href="{{ route('admin.services.index') }}"
                                class="flex-1 px-8 py-3.5 bg-white/[0.03] border border-white/10 rounded-xl text-center text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-all shadow-sm"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-6 opacity-30 shrink-0 text-center">
                    <p class="text-[8px] font-bold text-slate-500 uppercase tracking-[0.5em]">
                        Service Identity Protocol Sync
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
            animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes luxuryEntrance {
            from { opacity: 0; transform: translateY(15px) scale(0.99); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Styling Select untuk tema gelap */
        select option {
            background-color: #050505;
            color: white;
        }
    </style>
</x-app-layout>