<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <x-sidebar>
            <main class="flex-1 flex flex-col min-w-0 bg-[#f8fafc] relative">
                
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-500/[0.03] blur-[100px] pointer-events-none z-0"></div>
                
                <div class="flex-none px-6 md:px-12 py-6 md:py-8 border-b border-slate-200 bg-white/70 backdrop-blur-xl z-20">
                    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-10 bg-indigo-600 rounded-full"></div>
                            <div>
                                <h1 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight">
                                    Direktori <span class="text-indigo-600 italic font-serif font-normal lowercase">Pengguna</span>
                                </h1>
                                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-400 mt-1">Manajemen Basis Data Terpusat</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('admin.users.create') }}" class="px-8 py-3 bg-slate-900 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg active:scale-95">
                            Tambah Pengguna
                        </a>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto custom-scroll z-10">
                    <div class="px-6 md:px-12 py-8">
                        
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full border-separate border-spacing-y-4">
                                <thead class="sticky top-0 bg-[#f8fafc] z-30">
                                    <tr class="text-[10px] font-black text-slate-500 uppercase tracking-[0.25em]">
                                        <th class="py-4 px-6 text-center w-20">No</th>
                                        <th class="py-4 px-6 text-left">Identitas & Kredensial</th>
                                        <th class="py-4 px-6 text-center">Hak Akses</th>
                                        <th class="py-4 px-6 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr class="group transition-all duration-300">
                                        <td class="py-5 px-6 bg-white border-y border-l border-slate-200 rounded-l-[2rem] text-center font-mono text-xs text-slate-400 shadow-sm group-hover:bg-slate-50">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="py-5 px-6 bg-white border-y border-slate-200 shadow-sm group-hover:bg-slate-50">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center font-black text-indigo-600">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="text-sm font-extrabold text-slate-800 truncate">{{ $user->name }}</div>
                                                    <div class="text-[11px] text-slate-400 italic truncate">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-5 px-6 bg-white border-y border-slate-200 text-center shadow-sm group-hover:bg-slate-50">
                                            <span class="inline-flex px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $user->role == 'admin' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-500' }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-6 bg-white border-y border-r border-slate-200 rounded-r-[2rem] text-right shadow-sm group-hover:bg-slate-50">
                                            <div class="flex justify-end items-center gap-3">
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all">
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
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">© 2026 SETYO BARBERSHOP • WHITE EDITION V.2.1</p>
                        </div>

                    </div>
                </div>
            </main>
        </x-sidebar>
    </div>

    <style>
        /* CSS Wajib: Matikan scroll window */
        html, body { 
            height: 100vh; 
            width: 100vw; 
            overflow: hidden !important; 
            margin: 0;
            background-color: #f8fafc;
        }

        /* Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Mencegah lag interaksi mouse */
        .pointer-events-none { pointer-events: none !important; }
    </style>
</x-app-layout>