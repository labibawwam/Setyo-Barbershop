<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-1/4 w-[200px] md:w-[400px] h-[200px] md:h-[400px] bg-purple-600/5 blur-[70px] md:blur-[100px] pointer-events-none"></div>
            
            <div class="flex-none px-6 md:px-8 py-6 md:py-8 lg:px-12 border-b border-white/[0.05] bg-[#050505]/50 backdrop-blur-md z-20">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div class="flex items-center gap-4 min-w-0">
                        <button @click="isSidebarOpen = true" class="md:hidden p-2.5 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </button>

                        <div class="min-w-0">
                            <h1 class="text-2xl md:text-4xl font-black text-white tracking-tight flex items-center gap-3">
                                Users <span class="text-indigo-500 italic font-serif text-xl md:text-2xl font-normal lowercase tracking-normal">directory</span>
                            </h1>
                            <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-slate-500 mt-1 md:mt-2 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-green-500 animate-pulse"></span>
                                <span class="truncate">Verified Database Management</span>
                            </p>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.users.create') }}" class="w-full sm:w-auto shrink-0 group relative px-6 md:px-8 py-3 md:py-3.5 bg-white text-black rounded-2xl text-[10px] md:text-[11px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-xl text-center">
                        <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                            Add New <span class="hidden xs:inline">Entry</span>
                        </span>
                    </a>
                </div>
            </div>

            <div class="flex-1 overflow-hidden flex flex-col relative z-10">
                <div class="flex-1 overflow-auto custom-scroll px-6 md:px-8 lg:px-12 py-4 md:py-6 overscroll-contain">
                    <table class="w-full text-left border-separate border-spacing-y-3 min-w-[900px] lg:min-w-full">
                        <thead class="sticky top-0 z-30 bg-[#050505]">
                            <tr class="text-[10px] font-black text-slate-500 uppercase tracking-[0.25em]">
                                <th class="py-4 px-4 border-b border-white/[0.05] text-center w-[80px]">ID</th>
                                <th class="py-4 px-6 border-b border-white/[0.05]">Identity & Credentials</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] text-center w-[200px]">Privilege Level</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] text-right w-[180px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @foreach($users as $user)
                            <tr class="group transition-all duration-500">
                                <td class="py-5 px-4 bg-white/[0.02] group-hover:bg-white/[0.05] rounded-l-2xl border-y border-l border-white/[0.05] text-center font-mono text-xs text-slate-500 transition-all">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="py-5 px-6 bg-white/[0.02] group-hover:bg-white/[0.05] border-y border-white/[0.05] transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="shrink-0 w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 border border-white/10 flex items-center justify-center text-sm font-black text-indigo-400 shadow-lg group-hover:border-indigo-500/50 transition-all">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-sm font-bold text-white group-hover:text-indigo-400 transition-colors truncate">{{ $user->name }}</div>
                                            <div class="text-[11px] text-slate-500 font-medium truncate italic tracking-wide mt-0.5">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-5 px-6 bg-white/[0.02] group-hover:bg-white/[0.05] border-y border-white/[0.05] text-center transition-all">
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.15em] {{ $user->role == 'admin' ? 'bg-indigo-500 text-white shadow-[0_0_15px_rgba(99,102,241,0.3)]' : 'bg-slate-800 text-slate-400 border border-white/5' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>

                                <td class="py-5 px-6 bg-white/[0.02] group-hover:bg-white/[0.05] border-y border-r border-white/[0.05] rounded-r-2xl text-right transition-all">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Secure Warning: Are you sure you want to delete this user?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/10 border border-red-500/20 text-red-500 hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.34 9m-4.72 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
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
                    <p class="text-center sm:text-left truncate">Database Status: <span class="text-indigo-400 italic font-serif text-sm font-normal normal-case tracking-normal ml-2">{{ $users->count() }} Active Identifiers</span></p>
                    
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
        body, html { 
            overflow: hidden !important; 
            height: 100vh; 
            width: 100vw;
            background-color: #050505; 
        }

        /* Custom Scrollbar Styling untuk Desktop & Mobile */
        .custom-scroll::-webkit-scrollbar { 
            width: 4px; 
            height: 6px; /* Tinggi scrollbar horizontal */
        }
        .custom-scroll::-webkit-scrollbar-track { 
            background: rgba(255, 255, 255, 0.02); 
        }
        .custom-scroll::-webkit-scrollbar-thumb { 
            background: rgba(99, 102, 241, 0.3); 
            border-radius: 20px; 
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover { 
            background: rgba(99, 102, 241, 0.6); 
        }

        /* Memastikan baris tabel tidak pecah saat scroll */
        table { border-collapse: separate; table-layout: auto; }
        th, td { white-space: nowrap; }

        /* Mencegah highlight biru saat klik di mobile */
        button, a { -webkit-tap-highlight-color: transparent; }
    </style>
</x-app-layout>