<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <x-sidebar>
            <main class="flex-1 flex flex-col h-full min-w-0 bg-[#f8fafc] relative">
                
                <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-500/[0.04] blur-[80px] md:blur-[120px] pointer-events-none z-0"></div>
                
                <div class="flex-none px-6 md:px-12 py-6 md:py-8 border-b border-slate-200 bg-white/70 backdrop-blur-xl z-20">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-10 bg-indigo-600 rounded-full"></div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                                    Kapster <span class="text-indigo-600 italic font-serif text-xl md:text-2xl font-normal lowercase tracking-normal">Tim</span>
                                </h1>
                                <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.3em] text-slate-400 mt-1 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)] animate-pulse"></span>
                                    <span>Manajemen Tim & Kapster Setyo</span>
                                </p>
                            </div>
                        </div>
                        
                        <a href="{{ route('admin.kapsters.create') }}" 
                           class="group relative px-8 py-3.5 bg-slate-900 text-white rounded-2xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:shadow-lg active:scale-95 overflow-hidden">
                            <span class="relative z-10 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                                Tambah Kapster
                            </span>
                        </a>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto custom-scroll z-10">
                    <div class="px-6 md:px-12 py-8">
                        
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full border-separate border-spacing-y-4">
                                <thead class="sticky top-0 bg-[#f8fafc] z-30">
                                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">
                                        <th class="py-4 px-6 text-center w-20">ID</th>
                                        <th class="py-4 px-6 text-left w-32">Foto</th>
                                        <th class="py-4 px-6 text-left">Nama Kapster</th>
                                        <th class="py-4 px-6 text-left">Biografi</th>
                                        <th class="py-4 px-6 text-right w-40">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kapsters as $kapster)
                                    <tr class="group transition-all duration-300">
                                        <td class="py-5 px-6 bg-white border-y border-l border-slate-200 rounded-l-[2rem] text-center font-mono text-xs text-indigo-500 shadow-sm group-hover:bg-slate-50">
                                            #{{ $kapster->id }}
                                        </td>

                                        <td class="py-5 px-6 bg-white border-y border-slate-200 shadow-sm group-hover:bg-slate-50">
                                            <div class="relative w-12 h-12">
                                                @if($kapster->photo)
                                                    <img src="{{ asset('storage/' . $kapster->photo) }}" class="w-full h-full rounded-2xl object-cover border border-slate-100 shadow-sm group-hover:scale-110 transition-transform">
                                                @else
                                                    <div class="w-full h-full rounded-2xl bg-slate-100 flex items-center justify-center text-[8px] font-black text-slate-400 italic text-center">N/A</div>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="py-5 px-6 bg-white border-y border-slate-200 shadow-sm group-hover:bg-slate-50">
                                            <div class="text-sm font-extrabold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $kapster->nama }}</div>
                                            <div class="text-[8px] text-indigo-500 font-black uppercase tracking-widest mt-1">Artist Profesional</div>
                                        </td>

                                        <td class="py-5 px-6 bg-white border-y border-slate-200 shadow-sm group-hover:bg-slate-50">
                                            <p class="text-xs text-slate-500 leading-relaxed italic line-clamp-2 max-w-xs">
                                                {{ $kapster->bio ?? 'No biography available for this artist.' }}
                                            </p>
                                        </td>

                                        <td class="py-5 px-6 bg-white border-y border-r border-slate-200 rounded-r-[2rem] text-right shadow-sm group-hover:bg-slate-50">
                                            <div class="flex justify-end items-center gap-3">
                                                <a href="{{ route('admin.kapsters.edit', $kapster->id) }}" class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                                </a>
                                                <form action="{{ route('admin.kapsters.destroy', $kapster->id) }}" method="POST" onsubmit="return confirm('Hapus data kapster ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all duration-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-12 py-6 border-t border-slate-200 text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">© 2026 SETYO BARBERSHOP • MANAJEMEN TIM</p>
                        </div>
                    </div>
                </div>

            </main>
        </x-sidebar>
    </div>

    <style>
        /* Matikan scroll global agar mousewheel fokus ke tabel */
        body, html { 
            overflow: hidden !important; 
            height: 100vh; 
            width: 100vw; 
            background-color: #f8fafc; 
        }

        /* Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Biografi wrap setting */
        td:nth-child(4) p { white-space: normal; }
    </style>
</x-app-layout>