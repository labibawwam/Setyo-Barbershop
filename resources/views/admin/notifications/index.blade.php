<x-app-layout>
    <div class="flex h-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            
            <div class="flex-none px-8 py-6 lg:px-10 border-b border-white/[0.05] bg-[#050505]/50 backdrop-blur-sm z-10">
                <div class="flex items-center justify-between gap-6">
                    <div class="min-w-0">
                        <h1 class="text-3xl font-black text-white tracking-tight flex items-center gap-3">
                            System <span class="text-indigo-500 italic font-serif text-2xl font-normal lowercase tracking-normal">notifications</span>
                        </h1>
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-500 mt-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                            Broadcast & Alert Logs
                        </p>
                    </div>
                    
                    <button class="shrink-0 group relative px-8 py-3 bg-white/[0.03] border border-white/10 text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all hover:bg-white/10 active:scale-95 overflow-hidden">
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Mark All Read
                        </span>
                    </button>
                </div>
            </div>

            <div class="flex-1 overflow-hidden flex flex-col relative">
                <div class="flex-1 overflow-y-auto overflow-x-auto custom-scroll px-8 lg:px-10 py-4">
                    <table class="w-full text-left border-separate border-spacing-y-3">
                        <thead class="sticky top-0 z-20 bg-[#050505]">
                            <tr class="text-[10px] font-black text-slate-500 uppercase tracking-[0.25em]">
                                <th class="py-4 px-4 border-b border-white/[0.05] text-center w-[60px]">No</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[20%]">Recipient</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[45%]">Subject & Message</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[10%] text-center">Status</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] text-right w-[120px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @foreach($notifications as $index => $notification)
                            <tr class="group transition-all duration-500 hover:translate-x-1">
                                <td class="py-4 px-4 bg-white/[0.03] group-hover:bg-white/[0.06] rounded-l-2xl border-y border-l border-white/[0.05] text-center font-mono text-xs text-indigo-400/70">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center border border-indigo-500/20">
                                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-sm font-bold text-white truncate">{{ $notification->user?->name ?? 'System Wide' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05]">
                                    <div class="min-w-0">
                                        <div class="text-sm font-bold text-white group-hover:text-indigo-400 transition-colors truncate tracking-wide">
                                            {{ $notification->title }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 font-medium truncate mt-0.5 italic">
                                            {{ $notification->message }}
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05] text-center">
                                    @if($notification->is_read)
                                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-slate-800 text-slate-500 border border-white/5">
                                            READ
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-indigo-600 text-white shadow-[0_0_10px_#6366f1]">
                                            NEW
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-r border-white/[0.05] rounded-r-2xl text-right transition-colors">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition-all duration-300 group/edit shadow-lg shadow-indigo-600/20 active:scale-90" title="View Detail">
                                            <svg class="w-4 h-4 transition-transform group-hover/edit:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 9.073 6.647 6 12 6c5.353 0 8.601 3.073 9.964 5.678.112.213.112.462 0 .675C20.601 15.227 17.353 18 12 18c-5.353 0-8.601-3.073-9.964-5.678z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>

                                        <form action="#" method="POST" class="inline m-0" onsubmit="return confirm('Hapus notifikasi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-600 text-white hover:bg-red-500 transition-all duration-300 group/del shadow-lg shadow-red-600/20 active:scale-90" title="Delete Notification">
                                                <svg class="w-4 h-4 transition-transform group-hover/del:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.34 9m-4.72 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
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

            <div class="flex-none px-8 py-6 lg:px-10 border-t border-white/[0.05] bg-[#050505]/80 backdrop-blur-md">
                <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest text-slate-500">
                    <p>Alert Logs: <span class="text-indigo-400 ml-1 italic">{{ $notifications->count() }} System Notifications</span></p>
                    <div class="flex items-center gap-4">
                        <button class="hover:text-white transition-colors">Prev</button>
                        <span class="px-3 py-1 rounded bg-indigo-600 text-white font-mono shadow-lg shadow-indigo-600/30">01</span>
                        <button class="text-indigo-400 hover:text-indigo-300 transition-colors">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        body, html { overflow: hidden; height: 100%; background-color: #050505; }
        .custom-scroll::-webkit-scrollbar { width: 4px; height: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 20px; }
        table { table-layout: fixed; width: 100%; }
        th, td { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    </style>
</x-app-layout>