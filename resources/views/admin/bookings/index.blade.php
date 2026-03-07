<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <x-sidebar>

        <main class="flex-1 flex flex-col min-w-0 bg-[#f8fafc] relative overflow-y-auto md:overflow-hidden custom-scroll">
            
            <div class="absolute top-0 right-0 w-[400px] md:w-[600px] h-[400px] md:h-[600px] bg-indigo-500/[0.05] blur-[100px] md:blur-[120px] pointer-events-none"></div>
            
            <div class="flex-none px-4 md:px-8 py-6 lg:px-10 border-b border-slate-200 bg-white/70 backdrop-blur-md z-20">
                <div class="flex flex-col gap-6 md:gap-8">
                    
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="min-w-0">
                                <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight truncate uppercase">
                                    <span class="text-indigo-600 italic font-serif font-normal lowercase tracking-normal">Reservasi</span>
                                </h1>
                            </div>
                        </div>

                        <a href="{{ route('admin.bookings.create') }}" 
                           class="shrink-0 group relative px-6 md:px-8 py-3 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 active:scale-95 overflow-hidden shadow-lg shadow-slate-200 text-center">
                            <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                                <span class="hidden sm:inline">Tambah Reservasi</span>
                            </span>
                        </a>
                    </div>

                    <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 items-end">
                        <div class="group">
                            <label class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 block ml-1">Identitas Klien</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"/></svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="client/kapster/service..." 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 pl-12 pr-4 text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="flex-1">
                                <label class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 block ml-1">Tanggal Mulai</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-3 text-[10px] md:text-xs text-slate-800 [color-scheme:light]">
                            </div>
                            <div class="flex-1">
                                <label class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 block ml-1">Tanggal Selesai</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-3 text-[10px] md:text-xs text-slate-800 [color-scheme:light]">
                            </div>
                        </div>

                        <div>
                            <label class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 block ml-1">Status</label>
                            <div class="relative">
                                <select name="status" class="w-full appearance-none bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 text-[10px] font-bold uppercase tracking-widest text-slate-600 focus:border-indigo-500 transition-all cursor-pointer">
                                    <option value="" class="bg-white">Semua Status</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit" class="flex-1 p-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl transition-all shadow-md shadow-indigo-100 active:scale-95">
                                <span class="flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-widest">Cari</span>
                            </button>
                            @if(request()->anyFilled(['search', 'status', 'start_date', 'end_date']))
                                <a href="{{ route('admin.bookings.index') }}" class="p-3.5 bg-white border border-slate-200 text-slate-400 rounded-2xl hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex-1 overflow-hidden flex flex-col relative">
                <div class="flex-1 overflow-auto custom-scroll px-4 md:px-8 lg:px-10 py-4 overscroll-contain">
                    <table class="w-full text-left border-separate border-spacing-y-3 min-w-[1100px] lg:min-w-full table-fixed">
                        <thead class="sticky top-0 z-20 bg-[#f8fafc]/95 backdrop-blur-sm">
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">
                                <th class="py-4 px-6 border-b border-slate-200 w-[20%]">Klien</th>
                                <th class="py-4 px-6 border-b border-slate-200 w-[18%]">Artis</th>
                                <th class="py-4 px-6 border-b border-slate-200 w-[25%]">Perawatan</th>
                                <th class="py-4 px-6 border-b border-slate-200 w-[20%] text-center">Jadwal</th>
                                <th class="py-4 px-6 border-b border-slate-200 w-[10%] text-center">Status</th>
                                <th class="py-4 px-6 border-b border-slate-200 text-right w-[140px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @forelse($bookings as $booking)
                            <tr class="group transition-all duration-500">
                                <td class="py-4 px-6 bg-white group-hover:bg-slate-50 rounded-l-2xl border-y border-l border-slate-200 shadow-sm transition-all">
                                    <div class="text-sm font-bold text-slate-900 truncate">{{ $booking->user->name }}</div>
                                    <div class="text-[9px] text-slate-400 font-mono mt-0.5 font-bold">ID: BC-{{ $booking->id }}</div>
                                </td>

                                <td class="py-4 px-6 bg-white group-hover:bg-slate-50 border-y border-slate-200 shadow-sm transition-all">
                                    <div class="flex items-center gap-3 text-xs font-bold text-slate-700">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-[9px] uppercase border border-indigo-100">{{ substr($booking->kapster->nama, 0, 2) }}</div>
                                        <span class="truncate">{{ $booking->kapster->nama }}</span>
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white group-hover:bg-slate-50 border-y border-slate-200 shadow-sm transition-all">
                                    <div class="flex flex-wrap gap-1 mb-1">
                                        @foreach($booking->services->take(2) as $service)
                                            <span class="text-[8px] px-2 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200 font-black uppercase tracking-tighter">{{ $service->nama_service }}</span>
                                        @endforeach
                                    </div>
                                    <div class="text-[11px] font-black text-indigo-600 tracking-tighter">Rp {{ number_format($booking->total_harga) }}</div>
                                </td>

                                <td class="py-4 px-6 bg-white group-hover:bg-slate-50 border-y border-slate-200 text-center shadow-sm transition-all">
                                    <div class="text-xs font-bold text-slate-900">{{ \Carbon\Carbon::parse($booking->tgl_booking)->format('d M Y') }}</div>
                                    <div class="text-[9px] text-indigo-500 font-mono mt-1 font-black bg-indigo-50 inline-block px-2 py-0.5 rounded border border-indigo-100">{{ substr($booking->jam_mulai, 0, 5) }} — {{ substr($booking->jam_selesai, 0, 5) }}</div>
                                </td>

                                <td class="py-4 px-6 bg-white group-hover:bg-slate-50 border-y border-slate-200 text-center shadow-sm transition-all">
                                    @php
                                        $statusStyles = [
                                            'confirmed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'completed' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                            'cancelled' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        ];
                                    @endphp
                                    <span class="inline-block px-3 py-1 rounded-lg border text-[8px] font-black uppercase tracking-widest {{ $statusStyles[$booking->status] ?? 'bg-slate-50 text-slate-400' }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 bg-white group-hover:bg-slate-50 border-y border-r border-slate-200 rounded-r-2xl text-right shadow-sm transition-all">
                                    <div class="flex justify-end gap-2.5">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="p-2 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M2.036 12.322a1.012 1.012 0 010-.644C3.67 8.242 7.84 4.5 12 4.5c4.16 0 8.33 3.742 9.964 7.178.07.143.07.312 0 .456C20.33 15.758 16.16 19.5 12 19.5c-4.16 0-8.33-3.742-9.964-7.178z" /><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg></a>
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="p-2 rounded-lg bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white transition-all shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg></a>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Hapus data ini dari riwayat?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-600 hover:text-white transition-all shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M14.74 9l-.34 9m-4.72 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="py-24 text-center opacity-40 text-[10px] font-black uppercase tracking-[0.4em] text-slate-400">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        </x-sidebar>
    </div>

    <style>
        body, html { overflow: hidden !important; height: 100vh; width: 100vw; background-color: #f8fafc; }
        .custom-scroll::-webkit-scrollbar { width: 4px; height: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        table { border-collapse: separate; table-layout: fixed; width: 100%; }
        th, td { white-space: nowrap; vertical-align: middle; }
        td:nth-child(3) { white-space: normal !important; }
        button, a { -webkit-tap-highlight-color: transparent; }
        input[type="date"]::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.6; }
    </style>
</x-app-layout>