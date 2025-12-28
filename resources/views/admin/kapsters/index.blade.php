<x-app-layout>
    <div class="flex h-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative">
            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>
            
            <div class="flex-none px-6 md:px-8 py-6 lg:px-10 border-b border-white/[0.05] bg-[#050505]/50 backdrop-blur-sm z-10">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div class="flex items-center gap-4 min-w-0">
                        <button @click="isSidebarOpen = true" class="md:hidden p-2.5 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </button>

                        <div class="min-w-0">
                            <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight flex items-center gap-3">
                                Hair <span class="text-indigo-500 italic font-serif text-xl md:text-2xl font-normal lowercase tracking-normal">artists</span>
                            </h1>
                            <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-slate-500 mt-1 md:mt-2 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                                <span class="truncate">Team & Kapster Management</span>
                            </p>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.kapsters.create') }}" 
                       class="w-full sm:w-auto shrink-0 group relative px-6 md:px-8 py-3 bg-white text-black rounded-2xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-xl flex justify-center items-center">
                        <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                            Add New <span class="hidden xs:inline">Artist</span>
                        </span>
                    </a>
                </div>
            </div>

            <div class="flex-1 overflow-hidden flex flex-col relative">
                <div class="flex-1 overflow-auto custom-scroll px-6 md:px-8 lg:px-10 py-4">
                    <table class="w-full text-left border-separate border-spacing-y-3 min-w-[750px] md:min-w-full">
                        <thead class="sticky top-0 z-20 bg-[#050505]">
                            <tr class="text-[10px] font-black text-slate-500 uppercase tracking-[0.25em]">
                                <th class="py-4 px-4 border-b border-white/[0.05] text-center w-[60px]">ID</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[80px]">Photo</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[180px]">Artist Name</th>
                                <th class="py-4 px-6 border-b border-white/[0.05]">Biography</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] text-right w-[120px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @foreach($kapsters as $kapster)
                            <tr class="group transition-all duration-500 hover:translate-x-1">
                                <td class="py-4 px-4 bg-white/[0.03] group-hover:bg-white/[0.06] rounded-l-2xl border-y border-l border-white/[0.05] text-center font-mono text-xs text-indigo-400/70">
                                    #{{ $kapster->id }}
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05]">
                                    <div class="shrink-0 relative">
                                        @if($kapster->photo)
                                            <img src="{{ asset('storage/' . $kapster->photo) }}"
                                                 class="w-10 h-10 md:w-12 md:h-12 rounded-xl object-cover border border-white/10 shadow-lg group-hover:border-indigo-500 transition-all">
                                        @else
                                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-slate-800 border border-white/10 flex items-center justify-center text-[8px] font-black text-slate-500 italic">
                                                N/A
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05]">
                                    <div class="text-sm font-bold text-white group-hover:text-indigo-400 transition-colors tracking-wide truncate max-w-[150px]">
                                        {{ $kapster->nama }}
                                    </div>
                                    <div class="text-[8px] text-indigo-500/50 font-black uppercase tracking-widest mt-1">
                                        Pro Barber
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05]">
                                    <p class="text-[11px] md:text-xs text-slate-400 leading-relaxed italic line-clamp-2 whitespace-normal min-w-[200px]">
                                        {{ $kapster->bio ?? 'No biography available for this artist.' }}
                                    </p>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-r border-white/[0.05] rounded-r-2xl text-right">
                                    <div class="flex justify-end items-center gap-2 md:gap-3">
                                        <a href="{{ route('admin.kapsters.edit', $kapster->id) }}" 
                                           class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center rounded-lg bg-indigo-600/10 border border-indigo-500/20 text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-sm active:scale-90" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.kapsters.destroy', $kapster->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Secure Warning: Delete this entry?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center rounded-lg bg-red-600/10 border border-red-500/20 text-red-500 hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm active:scale-90" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M14.74 9l-.34 9m-4.72 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex-none px-6 md:px-8 py-5 md:py-6 lg:px-12 border-t border-white/[0.05] bg-[#050505]/80 backdrop-blur-md">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">
                    <p class="text-center sm:text-left">
                        Database Stats: <span class="text-indigo-400 italic font-serif text-sm font-normal normal-case tracking-normal ml-2">{{ $kapsters->count() }} Artists Active</span>
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
        /* Force no global scroll */
        body, html { overflow: hidden !important; height: 100vh; width: 100vw; background-color: #050505; }

        /* Smooth Scrollbar for Area Content */
        .custom-scroll::-webkit-scrollbar { width: 4px; height: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 20px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: rgba(99, 102, 241, 0.5); }

        /* Table Responsiveness Hack */
        table { border-collapse: separate; table-layout: fixed; }
        th, td { white-space: nowrap; }
        /* Biography must wrap */
        td:nth-child(4) { white-space: normal; }

        /* Ensure smooth tap on mobile */
        button, a { -webkit-tap-highlight-color: transparent; }

        @media (max-width: 640px) {
            .border-spacing-y-3 { border-spacing: 0 8px !important; }
        }
    </style>
</x-app-layout>