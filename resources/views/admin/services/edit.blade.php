<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <x-sidebar> 

        <main class="flex-1 flex flex-col items-center relative overflow-y-auto custom-scroll bg-[#f8fafc] px-6 md:px-12 py-10 md:py-16">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-indigo-500/[0.05] blur-[80px] md:blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[200px] md:w-[300px] h-[200px] md:h-[300px] bg-purple-500/[0.03] blur-[70px] md:blur-[100px] pointer-events-none"></div>

            <div class="w-full max-w-3xl relative z-10 flex flex-col items-center my-auto entrance-animation">
                
                <div class="mb-8 md:mb-10 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-5xl font-bold text-slate-900 tracking-tight leading-tight uppercase">
                        Update <span class="text-indigo-600 italic font-serif lowercase">Service Detail</span>
                    </h1>
                    <p class="text-[8px] md:text-[9px] font-bold uppercase tracking-[0.3em] md:tracking-[0.4em] text-slate-400 mt-3">
                        Service Configuration & Pricing Modification
                    </p>
                </div>

                <div class="w-full bg-white border border-slate-200 backdrop-blur-3xl rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.04)]">
                    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 md:space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">
                                    Service Designation
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_service" 
                                    value="{{ old('nama_service', $service->nama_service) }}"
                                    class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-5 md:px-6 py-3.5 md:py-4 text-sm text-slate-900 font-semibold focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all duration-300"
                                    required
                                >
                            </div>

                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">
                                    Treatment Category
                                </label>
                                <div class="relative">
                                    <select 
                                        name="category_id" 
                                        class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-5 py-3.5 md:py-4 text-sm text-slate-900 font-bold focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer pr-12"
                                        required
                                    >
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" class="bg-white" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-focus-within:text-indigo-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">
                                Brief Description
                            </label>
                            <textarea 
                                name="deskripsi"
                                rows="3"
                                class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-5 py-3.5 md:py-4 text-sm text-slate-900 font-medium placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all resize-none min-h-[100px]"
                                required
                            >{{ old('deskripsi', $service->deskripsi) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 md:gap-6">
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">
                                    Price (IDR)
                                </label>
                                <input 
                                    type="number" 
                                    name="harga" 
                                    value="{{ old('harga', $service->harga) }}"
                                    class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-5 py-3.5 md:py-4 text-sm text-slate-900 font-semibold focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all"
                                    required
                                >
                            </div>
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">
                                    Mins Session
                                </label>
                                <input 
                                    type="number" 
                                    name="durasi" 
                                    value="{{ old('durasi', $service->durasi) }}"
                                    class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-5 py-3.5 md:py-4 text-sm text-slate-900 font-semibold focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all"
                                    required
                                >
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-600 ml-1">
                                Service Visual
                            </label>
                            <div class="flex flex-col sm:flex-row items-center gap-6 bg-[#f8fafc] p-4 rounded-2xl border border-slate-200 group/media transition-all hover:bg-white">
                                @if($service->gambar)
                                <div class="shrink-0 relative">
                                    <img src="{{ asset('storage/' . $service->gambar) }}?v={{ $service->updated_at->timestamp }}"
                                         class="w-20 h-20 md:w-24 md:h-24 rounded-2xl object-cover border-2 border-indigo-100 shadow-md group-hover/media:border-indigo-500 transition-all duration-500">
                                </div>
                                @endif

                                <div class="relative flex-1 group/upload w-full">
                                    <input 
                                        type="file" 
                                        name="gambar"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                        onchange="this.nextElementSibling.querySelector('.file-name').innerText = this.files[0].name"
                                    >
                                    <div class="w-full border-2 border-dashed border-slate-200 rounded-xl py-6 flex flex-col items-center justify-center group-hover/upload:border-indigo-300 transition-all duration-500 text-center px-4">
                                        <svg class="w-6 h-6 text-indigo-500/50 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <span class="file-name text-[9px] font-bold text-slate-400 uppercase tracking-widest group-hover:text-slate-600">
                                            {{ $service->gambar ? 'Replace Current Media' : 'Upload Visual Media' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                            <button 
                                type="submit"
                                class="w-full sm:flex-[2] group relative px-8 py-3.5 md:py-4 bg-slate-900 text-white rounded-xl md:rounded-2xl text-[10px] md:text-[11px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:shadow-lg shadow-indigo-100 active:scale-95 overflow-hidden"
                            >
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10 w-full text-center">Commit Changes</span>
                            </button>

                            <a 
                                href="{{ route('admin.services.index') }}"
                                class="w-full sm:w-auto px-10 py-3.5 md:py-4 border border-slate-200 rounded-xl md:rounded-2xl text-center text-[10px] md:text-[11px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-700 hover:bg-slate-50 transition-all shadow-sm"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-8 md:mt-12 opacity-60 shrink-0 text-center mb-6">
                    <p class="text-[7px] md:text-[8px] font-bold text-slate-400 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="hidden xs:block w-12 md:w-16 h-px bg-gradient-to-r from-transparent to-slate-200"></span>
                        Internal Catalog Protocol
                        <span class="hidden xs:block w-12 md:w-16 h-px bg-gradient-to-l from-transparent to-slate-200"></span>
                    </p>
                </div>
            </div>
        </main>
        </x-sidebar>
    </div>

    <style>
        /* Modern Scrollbar Styling Soft */
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        
        body, html { 
            background-color: #f8fafc; 
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

        button, a, select, input { -webkit-tap-highlight-color: transparent; }
    </style>
</x-app-layout>