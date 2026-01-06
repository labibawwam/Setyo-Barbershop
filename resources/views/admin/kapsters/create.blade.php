<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <x-sidebar>

        <main class="flex-1 flex flex-col items-center relative overflow-y-auto custom-scroll bg-[#f8fafc] px-6 md:px-8 lg:px-12 py-10 md:py-16">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-500/[0.04] blur-[80px] md:blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[200px] md:w-[400px] h-[200px] md:h-[400px] bg-purple-500/[0.02] blur-[70px] md:blur-[100px] pointer-events-none"></div>

            <div class="w-full max-w-2xl relative z-10 flex flex-col items-center my-auto entrance-animation">
                
                <div class="mb-8 md:mb-10 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-5xl font-bold text-slate-900 tracking-tight leading-tight">
                        Register <span class="text-indigo-600 italic font-serif">New Artist</span>
                    </h1>
                    <p class="text-[8px] md:text-[10px] font-bold uppercase tracking-[0.3em] md:tracking-[0.4em] text-slate-400 mt-3">
                        Master Barber Onboarding System
                    </p>
                </div>

                <div class="w-full bg-white border border-slate-200 backdrop-blur-3xl rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.04)]">
                    <form action="{{ route('admin.kapsters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 md:space-y-6">
                        @csrf

                        <div class="space-y-2 group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">
                                Full Name
                            </label>
                            <input 
                                type="text" 
                                name="nama"
                                placeholder="e.g. Aditya Pratama"
                                class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-5 py-3.5 md:py-4 text-sm text-slate-900 font-semibold placeholder-slate-300 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all duration-300"
                                required
                            >
                        </div>

                        <div class="space-y-2 group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">
                                Artist Biography
                            </label>
                            <textarea 
                                name="bio" 
                                rows="3" 
                                placeholder="Describe the artist's expertise and experience..."
                                class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-5 py-3.5 md:py-4 text-sm text-slate-900 font-medium placeholder-slate-300 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all duration-300 resize-none min-h-[100px]"
                            ></textarea>
                        </div>

                        <div class="space-y-2 group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">
                                Portrait Identity
                            </label>
                            <div class="relative">
                                <input 
                                    type="file" 
                                    name="photo"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                    onchange="this.nextElementSibling.querySelector('.file-name').innerText = this.files[0].name"
                                >
                                <div class="w-full bg-[#f8fafc] border-2 border-dashed border-slate-200 rounded-[1.5rem] md:rounded-[2rem] py-6 md:py-8 flex flex-col items-center justify-center group-hover:bg-white group-hover:border-indigo-300 transition-all duration-500">
                                    <div class="w-8 h-8 md:w-10 md:h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 mb-2 transition-transform group-hover:scale-110">
                                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                    <span class="file-name text-[9px] md:text-[10px] font-bold text-slate-400 italic tracking-wide text-center px-4">Professional portrait (JPG/PNG)</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                            <button 
                                type="submit"
                                class="w-full sm:flex-[2] group relative px-8 py-3.5 md:py-4 bg-slate-900 text-white rounded-xl md:rounded-2xl text-[10px] md:text-[11px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 active:scale-95 overflow-hidden shadow-lg shadow-slate-200"
                            >
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10 flex items-center justify-center gap-2">Confirm Registration</span>
                            </button>

                            <a 
                                href="{{ route('admin.kapsters.index') }}"
                                class="w-full sm:w-auto px-10 py-3.5 md:py-4 border border-slate-200 rounded-xl md:rounded-2xl text-center text-[10px] md:text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-slate-700 hover:bg-white transition-all shadow-sm"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-8 md:mt-12 mb-4 text-center shrink-0 opacity-60">
                    <p class="text-[7px] md:text-[8px] font-bold text-slate-400 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="hidden xs:block w-10 md:w-16 h-px bg-gradient-to-r from-transparent to-slate-200"></span>
                        Authorized Node Access Only
                        <span class="hidden xs:block w-10 md:w-16 h-px bg-gradient-to-l from-transparent to-slate-200"></span>
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
        }

        .font-display { font-family: 'Playfair Display', serif; }
        .entrance-animation { animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes luxuryEntrance { from { opacity: 0; transform: translateY(20px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
        
        button, a, select, input { -webkit-tap-highlight-color: transparent; }
    </style>
</x-app-layout>