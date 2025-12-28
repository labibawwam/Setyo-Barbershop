<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-y-auto custom-scroll">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>

            <div class="px-8 py-10 lg:px-16 z-10 max-w-7xl mx-auto w-full">
                <div class="flex items-center gap-4 mb-10">
                    <a href="{{ route('admin.bookings.index') }}" class="group flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-indigo-400 transition-all">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                        Back to Registry
                    </a>
                </div>

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-white/[0.05] pb-12">
                    <div class="space-y-4">
                        <h1 class="text-5xl font-black text-white tracking-tighter uppercase leading-tight">
                            Reservation <span class="text-indigo-500 italic font-serif lowercase tracking-normal text-4xl font-normal">intel</span>
                        </h1>
                        <div class="flex items-center gap-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.5em] text-slate-600 font-mono">
                                RefID: #BKG-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                            </p>
                            <span class="w-1 h-1 rounded-full bg-slate-800"></span>
                            <span class="px-4 py-1.5 rounded-full border text-[9px] font-black uppercase tracking-[0.2em] 
                                {{ $booking->status === 'confirmed' ? 'bg-green-500/10 text-green-500 border-green-500/20' : 
                                   ($booking->status === 'completed' ? 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20' : 'bg-red-500/10 text-red-500 border-red-500/20') }}">
                                {{ $booking->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-12">
                    
                    <div class="lg:col-span-2 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="glass p-8 rounded-[2.5rem] border-white/5 flex flex-col justify-between">
                                <div>
                                    <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400 block mb-6 italic opacity-70">Customer Identity</label>
                                    <h4 class="text-2xl font-bold text-white tracking-tight">{{ $booking->user->name }}</h4>
                                    <p class="text-xs text-slate-500 font-mono mt-1 opacity-70">{{ $booking->user->email }}</p>
                                </div>
                                <div class="mt-10 pt-6 border-t border-white/5 flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Verified Client Account</p>
                                </div>
                            </div>

                            <div class="glass p-8 rounded-[2.5rem] border-white/5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400 block mb-6 italic opacity-70">Assigned Master</label>
                                <div class="flex items-center gap-5">
                                    <div class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-indigo-600/20 to-purple-600/20 border border-white/10 flex items-center justify-center text-indigo-400 text-3xl font-black italic shadow-2xl">
                                        {{ strtoupper(substr($booking->kapster->nama, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-xl font-bold text-white">{{ $booking->kapster->nama }}</h4>
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500 mt-1">Professional Artist</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="glass rounded-[3rem] border-white/5 overflow-hidden">
                            <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                                <h3 class="text-[10px] font-black text-white uppercase tracking-[0.3em]">Treatment Manifest</h3>
                            </div>
                            <div class="p-8">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="text-[9px] font-black text-slate-600 uppercase tracking-widest border-b border-white/5">
                                            <th class="pb-4 px-2">Service Description</th>
                                            <th class="pb-4 px-2 text-right">Unit Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/[0.03]">
                                        @foreach($booking->services as $service)
                                        <tr>
                                            <td class="py-5 px-2">
                                                <p class="text-sm font-bold text-slate-300">{{ $service->nama_service }}</p>
                                                <p class="text-[9px] text-slate-600 mt-1 uppercase font-black tracking-tighter">{{ $service->durasi }} Mins Session</p>
                                            </td>
                                            <td class="py-5 px-2 text-right font-mono text-sm text-white">
                                                Rp {{ number_format($service->harga) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="pt-8">
                                                <div class="bg-indigo-500/5 p-8 rounded-[2rem] border border-indigo-500/10 flex justify-between items-center">
                                                    <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest italic">Net Settlement</span>
                                                    <span class="text-4xl font-black text-white italic font-serif tracking-tight">Rp {{ number_format($booking->total_harga) }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="glass p-8 rounded-[2.5rem] border-white/5 relative overflow-hidden">
                            <div class="absolute -top-4 -right-4">
                                <svg class="w-24 h-24 text-white/[0.02]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400 block mb-10 italic text-center opacity-70">Schedule Architecture</label>
                            
                            <div class="space-y-10 relative">
                                <div class="text-center">
                                    <p class="text-[8px] font-black text-slate-600 uppercase tracking-[0.4em] mb-3">Calendar Date</p>
                                    <p class="text-2xl font-bold text-white tracking-tighter">{{ \Carbon\Carbon::parse($booking->tgl_booking)->format('d F Y') }}</p>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white/[0.03] p-6 rounded-3xl border border-white/5 text-center">
                                        <p class="text-[8px] font-black text-slate-600 uppercase tracking-widest mb-2">Check-in</p>
                                        <p class="text-lg font-mono font-bold text-indigo-400">{{ substr($booking->jam_mulai, 0, 5) }}</p>
                                    </div>
                                    <div class="bg-white/[0.03] p-6 rounded-3xl border border-white/5 text-center">
                                        <p class="text-[8px] font-black text-slate-600 uppercase tracking-widest mb-2">Checkout</p>
                                        <p class="text-lg font-mono font-bold text-slate-400">{{ substr($booking->jam_selesai, 0, 5) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="glass p-8 rounded-[2.5rem] border-white/5">
                            <label class="text-[9px] font-black uppercase tracking-widest text-slate-500 block mb-8 opacity-70 uppercase tracking-[0.2em]">Transaction Logs</label>
                            <div class="space-y-8">
                                <div class="flex gap-5">
                                    <div class="shrink-0 w-1 h-1 rounded-full bg-green-500 mt-2 shadow-[0_0_10px_rgba(34,197,94,0.8)]"></div>
                                    <div>
                                        <p class="text-[10px] font-black text-white uppercase tracking-widest leading-none">Initialized</p>
                                        <p class="text-[9px] text-slate-600 mt-2 font-mono uppercase tracking-tighter">{{ $booking->created_at->format('d M Y • H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-5">
                                    <div class="shrink-0 w-1 h-1 rounded-full bg-indigo-500 mt-2 shadow-[0_0_10px_rgba(99,102,241,0.8)]"></div>
                                    <div>
                                        <p class="text-[10px] font-black text-white uppercase tracking-widest leading-none">Last Snapshot</p>
                                        <p class="text-[9px] text-slate-600 mt-2 font-mono uppercase tracking-tighter">{{ $booking->updated_at->format('d M Y • H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="h-16"></div>
        </main>
    </div>

    <style>
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.15); border-radius: 20px; }
        .glass { background: rgba(255, 255, 255, 0.01); backdrop-filter: blur(30px); border: 1px solid rgba(255, 255, 255, 0.04); }
    </style>
</x-app-layout>