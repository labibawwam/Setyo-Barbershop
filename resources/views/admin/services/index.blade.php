<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-hidden">
            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>
            
            <div class="flex-none px-6 md:px-8 py-6 lg:px-10 border-b border-white/[0.05] bg-[#050505]/50 backdrop-blur-sm z-10">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div class="flex items-center gap-4 min-w-0">
                        <button @click="isSidebarOpen = true" class="md:hidden p-2.5 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </button>
                        
                        <div class="min-w-0">
                            <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight flex items-center gap-3">
                                Barber <span class="text-indigo-500 italic font-serif text-xl md:text-2xl font-normal lowercase tracking-normal">services</span>
                            </h1>
                            <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-slate-500 mt-1 md:mt-2 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                                <span class="truncate">Service Menu & Treatment Catalog</span>
                            </p>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.services.create') }}" 
                       class="w-full sm:w-auto shrink-0 group relative px-6 md:px-8 py-3 bg-white text-black rounded-2xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-xl flex justify-center items-center">
                        <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                            Add New <span class="hidden xs:inline">Service</span>
                        </span>
                    </a>
                </div>
            </div>

            <div class="flex-1 overflow-hidden flex flex-col relative">
                <div class="flex-1 overflow-auto custom-scroll px-6 md:px-8 lg:px-10 py-4">
                    <table class="w-full text-left border-separate border-spacing-y-3 min-w-[850px] md:min-w-full">
                        <thead class="sticky top-0 z-20 bg-[#050505]">
                            <tr class="text-[10px] font-black text-slate-500 uppercase tracking-[0.25em]">
                                <th class="py-4 px-4 border-b border-white/[0.05] text-center w-[60px]">No</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[30%]">Service Details</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] text-center">Category</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] text-center">Duration</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] text-center">Premium Price</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] text-right w-[120px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @forelse($services as $index => $service)
                            <tr class="group transition-all duration-500 hover:translate-x-1">
                                <td class="py-4 px-4 bg-white/[0.03] group-hover:bg-white/[0.06] rounded-l-2xl border-y border-l border-white/[0.05] text-center font-mono text-xs text-indigo-400/70">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05]">
                                    <div class="flex items-center gap-4">
                                        <div class="shrink-0">
                                            @if($service->gambar)
                                                <img src="{{ asset('storage/' . $service->gambar) }}"
                                                     class="w-10 h-10 md:w-12 md:h-12 rounded-xl object-cover border border-white/10 shadow-lg group-hover:border-indigo-500 transition-all">
                                            @else
                                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-slate-800 border border-white/10 flex items-center justify-center text-[8px] font-black text-slate-500 italic">
                                                    NO IMG
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-sm font-bold text-white group-hover:text-indigo-400 transition-colors truncate tracking-wide">
                                                {{ $service->nama_service }}
                                            </div>
                                            <div class="text-[10px] text-slate-500 font-medium truncate mt-0.5 max-w-[150px] md:max-w-[250px] italic">
                                                {{ $service->deskripsi }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05] text-center">
                                    <span class="inline-block px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-[9px] font-black uppercase tracking-widest text-indigo-400">
                                        {{ $service->category->nama_kategori ?? 'No Category' }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05] text-center text-xs font-bold text-slate-400">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-indigo-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        {{ $service->durasi }}m
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05] text-center">
                                    <span class="text-sm font-black text-indigo-400 tracking-tighter">
                                        Rp {{ number_format($service->harga, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-r border-white/[0.05] rounded-r-2xl text-right">
                                    <div class="flex justify-end items-center gap-2 md:gap-3">
                                        <a href="{{ route('admin.services.edit', $service->id) }}" 
                                           class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center rounded-lg bg-indigo-600/10 border border-indigo-500/20 text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-sm active:scale-90" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Secure Warning: Delete this entry?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center rounded-lg bg-red-600/10 border border-red-500/20 text-red-500 hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm active:scale-90" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M14.74 9l-.34 9m-4.72 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-20 text-center">
                                    <div class="flex flex-col items-center gap-3 opacity-20">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1.01 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <p class="text-sm font-black uppercase tracking-[0.4em]">No services cataloged</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex-none px-6 md:px-8 py-5 md:py-6 lg:px-12 border-t border-white/[0.05] bg-[#050505]/80 backdrop-blur-md">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">
                    <p class="text-center sm:text-left truncate">
                        Catalog Index: <span class="text-indigo-400 italic font-serif text-sm font-normal normal-case tracking-normal ml-2">{{ $services->count() }} Active Identifiers</span>
                    </p>
                    
                    <div class="flex items-center gap-6">
                        <button class="hover:text-white transition-colors">Prev</button>
                        <div class="flex items-center gap-1.5 font-mono">
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-600 text-white shadow-[0_0_15px_rgba(99,102,241,0.4)]">01</span>
                        </div>
                        <button class="text-indigo-400 hover:text-indigo-300 transition-colors">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        /* Global Scroll Reset */
        body, html { overflow: hidden !important; height: 100vh; width: 100vw; background-color: #050505; }

        /* Smooth Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar { width: 4px; height: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 20px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: rgba(99, 102, 241, 0.5); }

        /* Fixed Table Layout for consistency */
        table { border-collapse: separate; table-layout: fixed; }
        th, td { white-space: nowrap; }
        /* Biography field allows wrapping for better readability */
        td:nth-child(2) .min-w-0 div:nth-child(2) { white-space: normal; }

        @media (max-width: 640px) {
            .border-spacing-y-3 { border-spacing: 0 8px !important; }
        }
    </style>
</x-app-layout>