<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col items-center relative overflow-y-auto custom-scroll bg-[#050505] px-6 md:px-12 py-10 md:py-16">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[200px] md:w-[300px] h-[200px] md:h-[300px] bg-purple-600/5 blur-[70px] md:blur-[100px] pointer-events-none"></div>
            
            <div class="md:hidden self-start mb-6 relative z-20">
                <button @click="isSidebarOpen = true" class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                </button>
            </div>

            <div class="w-full max-w-2xl relative z-10 flex flex-col items-center my-auto entrance-animation">
                
                <div class="mb-8 md:mb-10 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-5xl font-bold text-white tracking-tight leading-tight uppercase">
                        Modify <span class="text-indigo-500 italic font-serif lowercase">Reservation</span>
                    </h1>
                    <p class="text-[8px] md:text-[9px] font-bold uppercase tracking-[0.3em] md:tracking-[0.4em] text-slate-500 mt-3">
                        Appointment Identity: #BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                <div class="w-full bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-5 md:space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                            <div class="space-y-2 opacity-60 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">Client Name</label>
                                <div class="w-full bg-white/[0.03] border border-white/5 rounded-xl md:rounded-2xl px-5 py-3 md:py-3.5 text-sm text-slate-400 cursor-not-allowed">
                                    {{ $booking->user->name }}
                                </div>
                            </div>

                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Assigned Artist</label>
                                <div class="relative">
                                    <select name="kapster_id" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3 md:py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer pr-12" required>
                                        @foreach($kapsters as $kapster)
                                            <option value="{{ $kapster->id }}" class="bg-[#050505]" {{ $booking->kapster_id == $kapster->id ? 'selected' : '' }}>
                                                {{ $kapster->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-focus-within:text-indigo-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">Treatment Services</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-[200px] md:max-h-[160px] overflow-y-auto custom-scroll p-3 bg-white/[0.01] rounded-xl border border-white/10">
                                @foreach($services as $service)
                                <label class="flex items-center gap-3 p-3 bg-white/[0.03] border border-white/5 rounded-xl cursor-pointer hover:bg-white/10 transition-all group">
                                    <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" 
                                        class="w-5 h-5 md:w-4 md:h-4 rounded border-white/10 bg-white/5 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                        {{ in_array($service->id, $booking->services->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-xs font-bold text-white group-hover:text-indigo-400 truncate">{{ $service->nama_service }}</span>
                                        <span class="text-[9px] text-slate-500 tracking-tighter">Rp {{ number_format($service->harga) }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 md:gap-4">
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">Date</label>
                                <input type="date" name="tgl_booking" value="{{ $booking->tgl_booking }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all [color-scheme:dark]" required>
                            </div>

                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">Start Time</label>
                                <input type="time" name="jam_mulai" value="{{ substr($booking->jam_mulai, 0, 5) }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all [color-scheme:dark]" required>
                            </div>

                            <div class="space-y-2 group sm:col-span-2 md:col-span-1">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">Status</label>
                                <div class="relative">
                                    <select name="status" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-4 py-3 text-sm text-white appearance-none focus:outline-none focus:border-indigo-500 transition-all cursor-pointer pr-10" required>
                                        @foreach(['confirmed', 'completed', 'cancelled'] as $status)
                                            <option value="{{ $status }}" class="bg-[#050505]" {{ $booking->status == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4 md:pt-6">
                            <button type="submit" class="w-full sm:flex-[2] group relative px-8 py-4 bg-white text-black rounded-xl md:rounded-2xl text-[10px] md:text-[11px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-lg shadow-indigo-500/10">
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10 w-full text-center">Commit Changes</span>
                            </button>

                            <a href="{{ route('admin.bookings.index') }}" class="w-full sm:flex-1 px-8 py-4 bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl text-center text-[10px] md:text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-white hover:bg-white/5 transition-all shadow-sm">
                                Back
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-8 md:mt-12 opacity-30 shrink-0 text-center mb-6">
                    <p class="text-[7px] md:text-[8px] font-bold text-slate-500 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="hidden xs:block w-10 md:w-16 h-px bg-gradient-to-r from-transparent to-slate-700"></span>
                        Reservation Protocol Update Node
                        <span class="hidden xs:block w-10 md:w-16 h-px bg-gradient-to-l from-transparent to-slate-700"></span>
                    </p>
                </div>
            </div>
        </main>
    </div>

    <style>
        /* Modern Scrollbar Styling */
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 10px; }
        
        body, html { background-color: #050505; margin: 0; padding: 0; }
        .font-display { font-family: 'Playfair Display', serif; }

        .entrance-animation { animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes luxuryEntrance { 
            from { opacity: 0; transform: translateY(20px) scale(0.98); } 
            to { opacity: 1; transform: translateY(0) scale(1); } 
        }

        /* Prevent Tap Highlight on Mobile */
        * { -webkit-tap-highlight-color: transparent; }

        /* Dark Theme Picker Fix */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator { 
            filter: invert(1); 
            opacity: 0.5; 
            cursor: pointer; 
        }
    </style>
</x-app-layout>