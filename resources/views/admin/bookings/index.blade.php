<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-hidden">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            
            <div class="flex-none px-8 py-6 lg:px-10 border-b border-white/[0.05] bg-[#050505]/50 backdrop-blur-sm z-10">
                <div class="flex items-center justify-between gap-6">
                    <div class="min-w-0">
                        <h1 class="text-3xl font-black text-white tracking-tight flex items-center gap-3">
                            Incoming <span class="text-indigo-500 italic font-serif text-2xl font-normal lowercase tracking-normal">reservations</span>
                        </h1>
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-500 mt-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                            Live Appointment Manager
                        </p>
                    </div>
                    
                    <a href="{{ route('admin.bookings.create') }}" 
                       class="shrink-0 group relative px-8 py-3 bg-white text-black rounded-2xl text-xs font-black uppercase tracking-widest transition-all hover:bg-indigo-500 hover:text-white active:scale-95 overflow-hidden shadow-[0_0_20px_rgba(255,255,255,0.1)]">
                        <div class="absolute inset-0 bg-indigo-600 translate-y-[100%] group-hover:translate-y-0 transition-transform duration-300"></div>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                            Add New Booking
                        </span>
                    </a>
                </div>
            </div>

            <div class="flex-1 overflow-hidden flex flex-col relative">
                <div class="flex-1 overflow-y-auto overflow-x-auto custom-scroll px-8 lg:px-10 py-4">
                    <table class="w-full text-left border-separate border-spacing-y-3 table-fixed">
                        <thead class="sticky top-0 z-20 bg-[#050505]">
                            <tr class="text-[10px] font-black text-slate-500 uppercase tracking-[0.25em]">
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[18%]">Client</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[18%]">Hair Artist</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[26%]">Service Details</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[18%] text-center">Schedule</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[10%] text-center">Status</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] text-right w-[10%]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @foreach($bookings as $booking)
                            <tr class="group transition-all duration-500 hover:translate-x-1">
                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] rounded-l-2xl border-y border-l border-white/[0.05] transition-colors">
                                    <div class="text-sm font-bold text-white truncate group-hover:text-indigo-400 transition-colors">
                                        {{ $booking->user->name }}
                                    </div>
                                    <div class="text-[9px] text-slate-500 font-mono mt-0.5 truncate opacity-60 italic tracking-tighter">
                                        {{ $booking->user->email }}
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05] transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 font-bold text-[11px] shadow-inner">
                                            {{ strtoupper(substr($booking->kapster->nama, 0, 2)) }}
                                        </div>
                                        <span class="text-xs font-bold text-slate-300 truncate">{{ $booking->kapster->nama }}</span>
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05] transition-colors !whitespace-normal">
                                    <div class="flex flex-wrap gap-1.5 mb-1.5">
                                        @foreach($booking->services as $service)
                                            <span class="text-[8px] px-2 py-0.5 rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 font-black uppercase tracking-tighter shadow-sm">
                                                {{ $service->nama_service }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <div class="text-[11px] font-black text-white/80 flex items-center gap-1.5">
                                        <span class="w-1 h-1 rounded-full bg-slate-600"></span>
                                        Rp {{ number_format($booking->total_harga) }}
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05] transition-colors text-center">
                                    <div class="text-xs font-bold text-white tracking-tighter">
                                        {{ \Carbon\Carbon::parse($booking->tgl_booking)->format('d M Y') }}
                                    </div>
                                    <div class="text-[10px] text-indigo-400 font-mono mt-1 bg-indigo-500/5 px-2 py-0.5 rounded border border-indigo-500/10 inline-block tracking-tighter">
                                        {{ substr($booking->jam_mulai, 0, 5) }} — {{ substr($booking->jam_selesai, 0, 5) }}
                                    </div>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05] text-center transition-colors">
                                    @php
                                        $statusClasses = [
                                            'pending'   => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                            'confirmed' => 'bg-green-500/10 text-green-500 border-green-500/20',
                                            'completed' => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20',
                                            'cancelled' => 'bg-red-500/10 text-red-500 border-red-500/20',
                                        ];
                                    @endphp
                                    <span class="inline-block px-3 py-1 rounded-lg border text-[9px] font-black uppercase tracking-[0.2em] {{ $statusClasses[$booking->status] ?? 'bg-white/5' }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-r border-white/[0.05] rounded-r-2xl transition-colors text-right">
                                    <div class="flex justify-end gap-2.5">
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" 
                                           class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-600/10 text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all duration-300 active:scale-90 shadow-lg"
                                           title="Modify Booking">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                        </a>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Cancel this appointment?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-600/10 text-red-400 hover:bg-red-600 hover:text-white transition-all duration-300 active:scale-90 shadow-lg">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M14.74 9l-.34 9m-4.72 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($bookings->isEmpty())
                        <div class="flex flex-col items-center justify-center py-32 text-slate-500 opacity-40">
                            <p class="text-[10px] font-black uppercase tracking-[0.4em]">No reservations found</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex-none px-8 py-6 lg:px-10 border-t border-white/[0.05] bg-[#050505]/80 backdrop-blur-md">
                <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest text-slate-500">
                    <p>Total Revenue: <span class="text-indigo-400 ml-1 italic font-serif text-sm font-normal">Rp {{ number_format($bookings->where('status', 'completed')->sum('total_harga')) }} (Completed)</span></p>
                    <div class="flex items-center gap-4">
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-600 text-white font-mono shadow-lg shadow-indigo-600/30">01</span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        body, html { overflow: hidden; height: 100vh; width: 100vw; background-color: #050505; margin: 0; }
        .custom-scroll::-webkit-scrollbar { width: 4px; height: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 20px; }
        
        /* Penting: Fixed layout agar kolom mematuhi lebar w-[...] secara presisi */
        table { table-layout: fixed; width: 100%; border-collapse: separate; }
        th, td { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    </style>
</x-app-layout>