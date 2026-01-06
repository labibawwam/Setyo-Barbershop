<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <x-sidebar>

        <main class="flex-1 flex flex-col min-w-0 bg-[#f8fafc] relative overflow-y-auto custom-scroll">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-500/[0.05] blur-[80px] md:blur-[120px] pointer-events-none"></div>

            <div class="px-6 md:px-8 py-8 md:py-10 lg:px-16 z-10 max-w-7xl mx-auto w-full">
                
                <div class="flex flex-col gap-8 mb-10">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('admin.bookings.index') }}" class="group flex items-center gap-2 text-[9px] md:text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 hover:text-indigo-600 transition-all">
                            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                            Back to Registry
                        </a>
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-200 pb-10">
                        <div class="space-y-4">
                            <h1 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-tight">
                                Reservation <span class="text-indigo-600 italic font-serif lowercase tracking-normal text-3xl md:text-4xl font-normal">intel</span>
                            </h1>
                            <div class="flex flex-wrap items-center gap-3 md:gap-4">
                                <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.3em] md:tracking-[0.5em] text-slate-400 font-mono">
                                    RefID: #BKG-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                                </p>
                                <span class="hidden xs:block w-1 h-1 rounded-full bg-slate-300"></span>
                                <span class="px-4 py-1.5 rounded-full border text-[8px] md:text-[9px] font-black uppercase tracking-[0.2em] 
                                    {{ $booking->status === 'confirmed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 
                                       ($booking->status === 'completed' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 'bg-rose-50 text-rose-600 border-rose-100') }}">
                                    {{ $booking->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
                    
                    <div class="lg:col-span-2 space-y-6 md:space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                            <div class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border border-slate-200 shadow-sm flex flex-col justify-between">
                                <div>
                                    <label class="text-[8px] md:text-[9px] font-black uppercase tracking-widest text-indigo-500 block mb-6 italic opacity-70">Customer Identity</label>
                                    <h4 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight break-words">{{ $booking->user->name }}</h4>
                                    <p class="text-[11px] md:text-xs text-slate-500 font-mono mt-1 break-all">{{ $booking->user->email }}</p>
                                </div>
                                <div class="mt-8 md:mt-10 pt-6 border-t border-slate-100 flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.4)] animate-pulse"></div>
                                    <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400">Verified Client Account</p>
                                </div>
                            </div>

                            <div class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border border-slate-200 shadow-sm">
                                <label class="text-[8px] md:text-[9px] font-black uppercase tracking-widest text-indigo-500 block mb-6 italic opacity-70">Assigned Master</label>
                                <div class="flex items-center gap-4 md:gap-5">
                                    <div class="w-16 h-16 md:w-20 md:h-20 shrink-0 rounded-[1.5rem] md:rounded-[2rem] bg-gradient-to-br from-indigo-50 to-slate-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-2xl md:text-3xl font-black italic shadow-inner">
                                        {{ strtoupper(substr($booking->kapster->nama, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-lg md:text-xl font-bold text-slate-900 truncate">{{ $booking->kapster->nama }}</h4>
                                        <p class="text-[8px] md:text-[9px] font-black uppercase tracking-widest text-slate-400 mt-1">Professional Artist</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-[2rem] md:rounded-[3rem] border border-slate-200 shadow-sm overflow-hidden">
                            <div class="px-6 md:px-8 py-5 md:py-6 border-b border-slate-100 bg-slate-50/50">
                                <h3 class="text-[9px] md:text-[10px] font-black text-slate-900 uppercase tracking-[0.3em]">Treatment Manifest</h3>
                            </div>
                            <div class="p-6 md:p-8 overflow-x-auto">
                                <table class="w-full text-left min-w-[400px]">
                                    <thead>
                                        <tr class="text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                            <th class="pb-4 px-2">Service Description</th>
                                            <th class="pb-4 px-2 text-right">Unit Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @foreach($booking->services as $service)
                                        <tr>
                                            <td class="py-4 md:py-5 px-2">
                                                <p class="text-xs md:text-sm font-bold text-slate-800">{{ $service->nama_service }}</p>
                                                <p class="text-[8px] md:text-[9px] text-slate-400 mt-1 uppercase font-black tracking-tighter">{{ $service->durasi }} Mins Session</p>
                                            </td>
                                            <td class="py-4 md:py-5 px-2 text-right font-mono text-xs md:text-sm text-slate-900 font-bold">
                                                Rp {{ number_format($service->harga) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="pt-6 md:pt-8">
                                                <div class="bg-indigo-50/50 p-6 md:p-8 rounded-[1.5rem] md:rounded-[2rem] border border-indigo-100 flex justify-between items-center gap-4 shadow-inner">
                                                    <span class="text-[8px] md:text-[10px] font-black text-indigo-600 uppercase tracking-widest italic">Net Settlement</span>
                                                    <span class="text-2xl md:text-4xl font-black text-slate-900 italic font-serif tracking-tight shrink-0">Rp {{ number_format($booking->total_harga) }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 md:space-y-8">
                        <div class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border border-slate-200 shadow-sm relative overflow-hidden">
                            <div class="absolute -top-4 -right-4 text-slate-50">
                                <svg class="w-20 h-20 md:w-24 md:h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <label class="text-[8px] md:text-[9px] font-black uppercase tracking-widest text-indigo-600 block mb-8 italic text-center opacity-70">Schedule Architecture</label>
                            
                            <div class="space-y-8 md:space-y-10 relative">
                                <div class="text-center">
                                    <p class="text-[7px] md:text-[8px] font-black text-slate-400 uppercase tracking-[0.4em] mb-2">Calendar Date</p>
                                    <p class="text-xl md:text-2xl font-bold text-slate-900 tracking-tighter">{{ \Carbon\Carbon::parse($booking->tgl_booking)->format('d F Y') }}</p>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3 md:gap-4">
                                    <div class="bg-slate-50 p-4 md:p-6 rounded-2xl md:rounded-3xl border border-slate-100 text-center">
                                        <p class="text-[7px] md:text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Check-in</p>
                                        <p class="text-base md:text-lg font-mono font-bold text-indigo-600">{{ substr($booking->jam_mulai, 0, 5) }}</p>
                                    </div>
                                    <div class="bg-slate-50 p-4 md:p-6 rounded-2xl md:rounded-3xl border border-slate-100 text-center">
                                        <p class="text-[7px] md:text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Checkout</p>
                                        <p class="text-base md:text-lg font-mono font-bold text-slate-700">{{ substr($booking->jam_selesai, 0, 5) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border border-slate-200 shadow-sm">
                            <label class="text-[8px] md:text-[9px] font-black uppercase tracking-widest text-slate-400 block mb-6 md:mb-8 opacity-70">Transaction Logs</label>
                            <div class="space-y-6 md:y-8">
                                <div class="flex gap-4">
                                    <div class="shrink-0 w-1 h-1 rounded-full bg-emerald-500 mt-2 shadow-[0_0_10px_rgba(16,185,129,0.8)]"></div>
                                    <div>
                                        <p class="text-[9px] md:text-[10px] font-black text-slate-900 uppercase tracking-widest leading-none">Initialized</p>
                                        <p class="text-[8px] md:text-[9px] text-slate-400 mt-2 font-mono uppercase tracking-tighter">{{ $booking->created_at->format('d M Y • H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="shrink-0 w-1 h-1 rounded-full bg-indigo-500 mt-2 shadow-[0_0_10px_rgba(99,102,241,0.8)]"></div>
                                    <div>
                                        <p class="text-[9px] md:text-[10px] font-black text-slate-900 uppercase tracking-widest leading-none">Last Snapshot</p>
                                        <p class="text-[8px] md:text-[9px] text-slate-400 mt-2 font-mono uppercase tracking-tighter">{{ $booking->updated_at->format('d M Y • H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 md:mt-16 text-center opacity-40">
                    <p class="text-[7px] md:text-[8px] font-black text-slate-400 uppercase tracking-[0.5em] md:tracking-[1em] leading-relaxed px-4">
                        Internal Intel Node Analysis — Setyo Barbershop
                    </p>
                </div>
            </div>

            <div class="h-10 md:h-16"></div>
        </main>
        </x-sidebar>
    </div>

    <style>
        .custom-scroll::-webkit-scrollbar { width: 3px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        
        body, html { background-color: #f8fafc; margin: 0; padding: 0; }
        
        /* Smooth Mobile tapping */
        a, button { -webkit-tap-highlight-color: transparent; }
        
        /* Break-word fix for small screens */
        .break-all { word-break: break-all; }
    </style>
</x-app-layout>