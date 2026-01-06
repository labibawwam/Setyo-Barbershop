<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <x-sidebar>

        <main class="flex-1 flex flex-col items-center relative overflow-y-auto custom-scroll bg-[#f8fafc] px-6 md:px-12 py-10 md:py-16">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-indigo-500/[0.05] blur-[80px] md:blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[200px] md:w-[300px] h-[200px] md:h-[300px] bg-purple-500/[0.03] blur-[70px] md:blur-[100px] pointer-events-none"></div>

            <div class="w-full max-w-2xl relative z-10 flex flex-col items-center my-auto entrance-animation">
                
                <div class="mb-8 md:mb-10 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-5xl font-bold text-slate-900 tracking-tight leading-tight uppercase">
                        Modify <span class="text-indigo-600 italic font-serif lowercase">Reservation</span>
                    </h1>
                    <p class="text-[8px] md:text-[9px] font-bold uppercase tracking-[0.3em] md:tracking-[0.4em] text-slate-400 mt-3 flex items-center justify-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.4)]"></span>
                        Appointment Identity: #BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                <div class="w-full bg-white border border-slate-200 backdrop-blur-3xl rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.04)]">
                    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-5 md:space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                            <div class="space-y-2 opacity-80 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Client Name</label>
                                <div class="w-full bg-slate-50 border border-slate-200 rounded-xl md:rounded-2xl px-5 py-3 md:py-3.5 text-sm text-slate-500 font-semibold cursor-not-allowed">
                                    {{ $booking->user->name }}
                                </div>
                            </div>

                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">Assigned Artist</label>
                                <div class="relative">
                                    <select name="kapster_id" class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-5 py-3 md:py-3.5 text-sm text-slate-900 font-bold focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer pr-12" required>
                                        @foreach($kapsters as $kapster)
                                            <option value="{{ $kapster->id }}" class="bg-white" {{ $booking->kapster_id == $kapster->id ? 'selected' : '' }}>
                                                {{ $kapster->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-focus-within:text-indigo-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-600 ml-1">Treatment Services</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-[200px] md:max-h-[160px] overflow-y-auto custom-scroll p-3 bg-[#f8fafc] rounded-xl border border-slate-200 shadow-inner">
                                @foreach($services as $service)
                                <label class="flex items-center gap-3 p-3 bg-white border border-slate-100 rounded-xl cursor-pointer hover:border-indigo-200 hover:bg-indigo-50/30 transition-all group/item">
                                    <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" 
                                        class="w-5 h-5 md:w-4 md:h-4 rounded border-slate-300 bg-white text-indigo-600 focus:ring-indigo-500/20 cursor-pointer transition-all"
                                        {{ in_array($service->id, $booking->services->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-xs font-bold text-slate-800 group-hover/item:text-indigo-600 truncate">{{ $service->nama_service }}</span>
                                        <span class="text-[9px] text-slate-400 font-bold tracking-tighter">Rp {{ number_format($service->harga) }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 md:gap-4">
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Date</label>
                                <input type="date" name="tgl_booking" value="{{ $booking->tgl_booking }}" class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-indigo-500 transition-all [color-scheme:light]" required>
                            </div>

                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Start Time</label>
                                <input type="time" name="jam_mulai" value="{{ substr($booking->jam_mulai, 0, 5) }}" class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-4 py-3 text-sm text-slate-900 font-semibold focus:outline-none focus:border-indigo-500 transition-all [color-scheme:light]" required>
                            </div>

                            <div class="space-y-2 group sm:col-span-2 md:col-span-1">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Status</label>
                                <div class="relative">
                                    <select name="status" class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-4 py-3 text-sm text-slate-900 font-bold appearance-none focus:outline-none focus:border-indigo-500 transition-all cursor-pointer pr-10" required>
                                        @foreach(['confirmed', 'completed', 'cancelled'] as $status)
                                            <option value="{{ $status }}" class="bg-white" {{ $booking->status == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4 md:pt-6">
                            <button type="submit" class="w-full sm:flex-[2] group relative px-8 py-4 bg-slate-900 text-white rounded-xl md:rounded-2xl text-[10px] md:text-[11px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 active:scale-95 overflow-hidden shadow-lg shadow-slate-200">
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10 w-full text-center font-black">Commit Changes</span>
                            </button>

                            <a href="{{ route('admin.bookings.index') }}" class="w-full sm:w-auto px-10 py-4 bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl text-center text-[10px] md:text-[11px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-700 hover:bg-white transition-all shadow-sm">
                                Back
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-8 md:mt-12 opacity-60 shrink-0 text-center mb-6">
                    <p class="text-[7px] md:text-[8px] font-bold text-slate-400 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="hidden xs:block w-10 md:w-16 h-px bg-gradient-to-r from-transparent to-slate-300"></span>
                        Reservation Protocol Update Node
                        <span class="hidden xs:block w-10 md:w-16 h-px bg-gradient-to-l from-transparent to-slate-300"></span>
                    </p>
                </div>
            </div>
        </main>
        </x-sidebar>
    </div>

    <style>
        /* Modern Scrollbar Styling Soft */
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        
        body, html { background-color: #f8fafc; margin: 0; padding: 0; }
        .font-display { font-family: 'Playfair Display', serif; }

        .entrance-animation { animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes luxuryEntrance { 
            from { opacity: 0; transform: translateY(20px) scale(0.98); } 
            to { opacity: 1; transform: translateY(0) scale(1); } 
        }

        /* Light Theme Picker Fix */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator { 
            filter: none; 
            opacity: 0.6; 
            cursor: pointer; 
        }
        
        button, a, select, input { -webkit-tap-highlight-color: transparent; }
    </style>
</x-app-layout>