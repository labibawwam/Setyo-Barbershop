<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-y-auto custom-scroll">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>

            <div class="px-6 md:px-8 py-8 md:py-10 lg:px-16 z-10 max-w-7xl mx-auto w-full">
                
                <div class="flex flex-col gap-8 mb-10">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.bookings.index') }}" class="group flex items-center gap-2 text-[9px] md:text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-indigo-400 transition-all">
                            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                            Back to Registry
                        </a>
                        
                        <button @click="isSidebarOpen = true" class="md:hidden p-2 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </button>
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-white/[0.05] pb-10">
                        <div class="space-y-4">
                            <h1 class="text-3xl md:text-5xl font-black text-white tracking-tighter uppercase leading-tight">
                                Reservation <span class="text-indigo-500 italic font-serif lowercase tracking-normal text-3xl md:text-4xl font-normal">intel</span>
                            </h1>
                            <div class="flex flex-wrap items-center gap-3 md:gap-4">
                                <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.3em] md:tracking-[0.5em] text-slate-600 font-mono">
                                    RefID: #BKG-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                                </p>
                                <span class="hidden xs:block w-1 h-1 rounded-full bg-slate-800"></span>
                                <span class="px-4 py-1.5 rounded-full border text-[8px] md:text-[9px] font-black uppercase tracking-[0.2em] 
                                    {{ $booking->status === 'confirmed' ? 'bg-green-500/10 text-green-500 border-green-500/20' : 
                                       ($booking->status === 'completed' ? 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20' : 'bg-red-500/10 text-red-500 border-red-500/20') }}">
                                    {{ $booking->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
                    
                    <div class="lg:col-span-2 space-y-6 md:space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                            <div class="glass p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border-white/5 flex flex-col justify-between">
                                <div>
                                    <label class="text-[8px] md:text-[9px] font-black uppercase tracking-widest text-indigo-400 block mb-6 italic opacity-70">Customer Identity</label>
                                    <h4 class="text-xl md:text-2xl font-bold text-white tracking-tight break-words">{{ $booking->user->name }}</h4>
                                    <p class="text-[11px] md:text-xs text-slate-500 font-mono mt-1 opacity-70 break-all">{{ $booking->user->email }}</p>
                                </div>
                                <div class="mt-8 md:mt-10 pt-6 border-t border-white/5 flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)] animate-pulse"></div>
                                    <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400">Verified Client Account</p>
                                </div>
                            </div>

                            <div class="glass p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border-white/5">
                                <label class="text-[8px] md:text-[9px] font-black uppercase tracking-widest text-indigo-400 block mb-6 italic opacity-70">Assigned Master</label>
                                <div class="flex items-center gap-4 md:gap-5">
                                    <div class="w-16 h-16 md:w-20 md:h-20 shrink-0 rounded-[1.5rem] md:rounded-[2rem] bg-gradient-to-br from-indigo-600/20 to-purple-600/20 border border-white/10 flex items-center justify-center text-indigo-400 text-2xl md:text-3xl font-black italic shadow-2xl">
                                        {{ strtoupper(substr($booking->kapster->nama, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-lg md:text-xl font-bold text-white truncate">{{ $booking->kapster->nama }}</h4>
                                        <p class="text-[8px] md:text-[9px] font-black uppercase tracking-widest text-slate-500 mt-1">Professional Artist</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="glass rounded-[2rem] md:rounded-[3rem] border-white/5 overflow-hidden">
                            <div class="px-6 md:px-8 py-5 md:py-6 border-b border-white/5 bg-white/[0.02]">
                                <h3 class="text-[9px] md:text-[10px] font-black text-white uppercase tracking-[0.3em]">Treatment Manifest</h3>
                            </div>
                            <div class="p-6 md:p-8 overflow-x-auto">
                                <table class="w-full text-left min-w-[400px]">
                                    <thead>
                                        <tr class="text-[8px] md:text-[9px] font-black text-slate-600 uppercase tracking-widest border-b border-white/5">
                                            <th class="pb-4 px-2">Service Description</th>
                                            <th class="pb-4 px-2 text-right">Unit Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/[0.03]">
                                        @foreach($booking->services as $service)
                                        <tr>
                                            <td class="py-4 md:py-5 px-2">
                                                <p class="text-xs md:text-sm font-bold text-slate-300">{{ $service->nama_service }}</p>
                                                <p class="text-[8px] md:text-[9px] text-slate-600 mt-1 uppercase font-black tracking-tighter">{{ $service->durasi }} Mins Session</p>
                                            </td>
                                            <td class="py-4 md:py-5 px-2 text-right font-mono text-xs md:text-sm text-white">
                                                Rp {{ number_format($service->harga) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="pt-6 md:pt-8">
                                                <div class="bg-indigo-500/5 p-6 md:p-8 rounded-[1.5rem] md:rounded-[2rem] border border-indigo-500/10 flex justify-between items-center gap-4">
                                                    <span class="text-[8px] md:text-[10px] font-black text-indigo-400 uppercase tracking-widest italic">Net Settlement</span>
                                                    <span class="text-2xl md:text-4xl font-black text-white italic font-serif tracking-tight shrink-0">Rp {{ number_format($booking->total_harga) }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 md:space-y-8">
                        <div class="glass p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border-white/5 relative overflow-hidden">
                            <div class="absolute -top-4 -right-4 opacity-10">
                                <svg class="w-20 h-20 md:w-24 md:h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <label class="text-[8px] md:text-[9px] font-black uppercase tracking-widest text-indigo-400 block mb-8 italic text-center opacity-70 uppercase tracking-[0.2em]">Schedule Architecture</label>
                            
                            <div class="space-y-8 md:space-y-10 relative">
                                <div class="text-center">
                                    <p class="text-[7px] md:text-[8px] font-black text-slate-600 uppercase tracking-[0.4em] mb-2">Calendar Date</p>
                                    <p class="text-xl md:text-2xl font-bold text-white tracking-tighter">{{ \Carbon\Carbon::parse($booking->tgl_booking)->format('d F Y') }}</p>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3 md:gap-4">
                                    <div class="bg-white/[0.03] p-4 md:p-6 rounded-2xl md:rounded-3xl border border-white/5 text-center">
                                        <p class="text-[7px] md:text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Check-in</p>
                                        <p class="text-base md:text-lg font-mono font-bold text-indigo-400">{{ substr($booking->jam_mulai, 0, 5) }}</p>
                                    </div>
                                    <div class="bg-white/[0.03] p-4 md:p-6 rounded-2xl md:rounded-3xl border border-white/5 text-center">
                                        <p class="text-[7px] md:text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Checkout</p>
                                        <p class="text-base md:text-lg font-mono font-bold text-slate-400">{{ substr($booking->jam_selesai, 0, 5) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="glass p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border-white/5">
                            <label class="text-[8px] md:text-[9px] font-black uppercase tracking-widest text-slate-500 block mb-6 md:mb-8 opacity-70 tracking-[0.2em]">Transaction Logs</label>
                            <div class="space-y-6 md:y-8">
                                <div class="flex gap-4">
                                    <div class="shrink-0 w-1 h-1 rounded-full bg-green-500 mt-2 shadow-[0_0_10px_rgba(34,197,94,0.8)]"></div>
                                    <div>
                                        <p class="text-[9px] md:text-[10px] font-black text-white uppercase tracking-widest leading-none">Initialized</p>
                                        <p class="text-[8px] md:text-[9px] text-slate-600 mt-2 font-mono uppercase tracking-tighter">{{ $booking->created_at->format('d M Y • H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="shrink-0 w-1 h-1 rounded-full bg-indigo-500 mt-2 shadow-[0_0_10px_rgba(99,102,241,0.8)]"></div>
                                    <div>
                                        <p class="text-[9px] md:text-[10px] font-black text-white uppercase tracking-widest leading-none">Last Snapshot</p>
                                        <p class="text-[8px] md:text-[9px] text-slate-600 mt-2 font-mono uppercase tracking-tighter">{{ $booking->updated_at->format('d M Y • H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 md:mt-16 text-center opacity-20">
                    <p class="text-[7px] md:text-[8px] font-black text-slate-500 uppercase tracking-[0.5em] md:tracking-[1em] leading-relaxed px-4">
                        Internal Intel Node Analysis — Setyo Barbershop
                    </p>
                </div>
            </div>

            <div class="h-10 md:h-16"></div>
        </main>
    </div>

    <style>
        .custom-scroll::-webkit-scrollbar { width: 3px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.1); border-radius: 10px; }
        .glass { background: rgba(255, 255, 255, 0.01); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.04); }
        
        /* Smooth Mobile tapping */
        a, button { -webkit-tap-highlight-color: transparent; }
        
        /* Break-word fix for long emails on small screens */
        .break-all { word-break: break-all; }
        
        @media (max-width: 640px) {
            .tracking-widest { tracking: 0.1em; }
        }
    </style>
</x-app-layout>