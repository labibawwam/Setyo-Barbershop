<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-y-auto md:overflow-hidden custom-scroll">
            
            <div class="absolute top-0 right-0 w-[400px] md:w-[600px] h-[400px] md:h-[600px] bg-indigo-600/5 blur-[100px] md:blur-[120px] pointer-events-none"></div>
            
            <div class="flex-none px-4 md:px-8 py-6 lg:px-10 border-b border-white/[0.05] bg-[#050505]/50 backdrop-blur-md z-20">
                <div class="flex flex-col gap-6 md:gap-8">
                    
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4 min-w-0">
                            <button @click="isSidebarOpen = true" class="md:hidden p-2.5 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            </button>
                            <div class="min-w-0">
                                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight truncate uppercase">
                                    Incoming <span class="text-indigo-500 italic font-serif font-normal lowercase tracking-normal">reservations</span>
                                </h1>
                            </div>
                        </div>
                        
                        <a href="{{ route('admin.bookings.create') }}" 
                           class="shrink-0 group relative px-6 md:px-8 py-3 bg-white text-black rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-xl text-center">
                            <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                                <span class="hidden sm:inline">Add New Booking</span>
                            </span>
                        </a>
                    </div>

                    <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 items-end">
                        <div class="group">
                            <label class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-600 mb-2 block ml-1">Client Identity</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"/></svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..." 
                                       class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl py-3 pl-12 pr-4 text-xs font-medium text-white placeholder:text-slate-700 focus:ring-2 focus:ring-indigo-500/30 transition-all">
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="flex-1">
                                <label class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-600 mb-2 block ml-1">Start Date</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl py-3 px-3 text-[10px] md:text-xs text-white [color-scheme:dark]">
                            </div>
                            <div class="flex-1">
                                <label class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-600 mb-2 block ml-1">End Date</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl py-3 px-3 text-[10px] md:text-xs text-white [color-scheme:dark]">
                            </div>
                        </div>

                        <div>
                            <label class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-600 mb-2 block ml-1">Status</label>
                            <div class="relative">
                                <select name="status" class="w-full appearance-none bg-white/[0.03] border border-white/[0.08] rounded-2xl py-3 px-4 text-[10px] font-black uppercase tracking-widest text-slate-400 focus:border-indigo-500/50 cursor-pointer">
                                    <option value="" class="bg-[#0b0b0b]">All Status</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit" class="flex-1 p-3.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl transition-all shadow-lg active:scale-95">
                                <span class="flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-widest">Search</span>
                            </button>
                            @if(request()->anyFilled(['search', 'status', 'start_date', 'end_date']))
                                <a href="{{ route('admin.bookings.index') }}" class="p-3.5 bg-white/5 text-slate-400 rounded-2xl hover:bg-red-500/20 hover:text-red-500 transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex-1 overflow-hidden flex flex-col relative">
                <div class="flex-1 overflow-auto custom-scroll px-4 md:px-8 lg:px-10 py-4">
                    <table class="w-full text-left border-separate border-spacing-y-3 min-w-[1100px] lg:min-w-full table-fixed">
                        <thead class="sticky top-0 z-20 bg-[#050505]">
                            <tr class="text-[10px] font-black text-slate-500 uppercase tracking-[0.25em]">
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[20%]">Client</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[18%]">Hair Artist</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[25%]">Treatments</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[20%] text-center">Schedule</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[10%] text-center">Status</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] text-right w-[140px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @forelse($bookings as $booking)
                            <tr class="group transition-all duration-500 hover:translate-x-1">
                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] rounded-l-2xl border-y border-l border-white/[0.05]">
                                    <div class="text-sm font-bold text-white truncate">{{ $booking->user->name }}</div>
                                    <div class="text-[9px] text-slate-500 font-mono mt-0.5 opacity-60">ID: BC-{{ $booking->id }}</div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05]">
                                    <div class="flex items-center gap-3 text-xs font-bold text-slate-300">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400 font-black text-[9px] uppercase">{{ substr($booking->kapster->nama, 0, 2) }}</div>
                                        <span class="truncate">{{ $booking->kapster->nama }}</span>
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05]">
                                    <div class="flex flex-wrap gap-1 mb-1">
                                        @foreach($booking->services->take(2) as $service)
                                            <span class="text-[8px] px-2 py-0.5 rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 font-black uppercase tracking-tighter shadow-sm">{{ $service->nama_service }}</span>
                                        @endforeach
                                    </div>
                                    <div class="text-[11px] font-black text-indigo-400/80 tracking-tighter">Rp {{ number_format($booking->total_harga) }}</div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05] text-center">
                                    <div class="text-xs font-bold text-white">{{ \Carbon\Carbon::parse($booking->tgl_booking)->format('d M Y') }}</div>
                                    <div class="text-[9px] text-slate-500 font-mono mt-1 font-black">{{ substr($booking->jam_mulai, 0, 5) }} — {{ substr($booking->jam_selesai, 0, 5) }}</div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05] text-center">
                                    @php
                                        $statusStyles = [
                                            'confirmed' => 'bg-green-500/10 text-green-500 border-green-500/20',
                                            'completed' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                            'cancelled' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                        ];
                                    @endphp
                                    <span class="inline-block px-3 py-1 rounded-lg border text-[8px] font-black uppercase tracking-widest {{ $statusStyles[$booking->status] ?? 'bg-white/5 text-slate-400' }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-r border-white/[0.05] rounded-r-2xl text-right">
                                    <div class="flex justify-end gap-2.5">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="p-2 rounded-lg bg-indigo-600/10 text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all active:scale-90 shadow-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M2.036 12.322a1.012 1.012 0 010-.644C3.67 8.242 7.84 4.5 12 4.5c4.16 0 8.33 3.742 9.964 7.178.07.143.07.312 0 .456C20.33 15.758 16.16 19.5 12 19.5c-4.16 0-8.33-3.742-9.964-7.178z" /><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg></a>
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="p-2 rounded-lg bg-white/5 text-slate-400 hover:bg-white hover:text-black transition-all active:scale-95 shadow-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg></a>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Purge this record from history?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-red-600/10 text-red-400 hover:bg-red-600 hover:text-white transition-all active:scale-90 shadow-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M14.74 9l-.34 9m-4.72 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="py-24 text-center opacity-40 text-[10px] font-black uppercase tracking-[0.4em]">Zero data discovered</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


        </main>
    </div>

    <style>
        body, html { overflow: hidden !important; height: 100vh; width: 100vw; background-color: #050505; }
        .custom-scroll::-webkit-scrollbar { width: 4px; height: 6px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 20px; }
        table { border-collapse: separate; table-layout: fixed; width: 100%; }
        th, td { white-space: nowrap; vertical-align: middle; }
        td:nth-child(3) { white-space: normal !important; }
        button, a { -webkit-tap-highlight-color: transparent; }
    </style>
</x-app-layout>