<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col justify-center items-center relative overflow-hidden px-6 lg:px-12">
            
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-purple-600/5 blur-[100px] pointer-events-none"></div>
            
            <div class="w-full max-w-3xl relative z-10">
                
                <div class="mb-6 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-4xl font-bold text-white tracking-tight leading-tight">
                        Modify <span class="text-indigo-500 italic font-serif">Reservation</span>
                    </h1>
                    <p class="text-[9px] font-bold uppercase tracking-[0.4em] text-slate-500 mt-2">
                        Appointment Identity: #BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                    </p>
                </div>

                <div class="bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[2.5rem] p-6 lg:p-8 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5 opacity-60">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                    Client Name
                                </label>
                                <div class="w-full bg-white/[0.03] border border-white/5 rounded-xl px-5 py-2.5 text-sm text-slate-400">
                                    {{ $booking->user->name }}
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                    Assigned Artist
                                </label>
                                <select 
                                    name="kapster_id" 
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer"
                                    required
                                >
                                    @foreach($kapsters as $kapster)
                                        <option value="{{ $kapster->id }}" class="bg-[#050505]" {{ $booking->kapster_id == $kapster->id ? 'selected' : '' }}>
                                            {{ $kapster->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                Treatment Services
                            </label>
                            <div class="grid grid-cols-2 gap-3 max-h-[160px] overflow-y-auto custom-scroll p-3 bg-white/[0.01] rounded-xl border border-white/10">
                                @foreach($services as $service)
                                <label class="flex items-center gap-3 p-2.5 bg-white/[0.03] border border-white/5 rounded-lg cursor-pointer hover:bg-white/10 transition-all group">
                                    <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" 
                                        class="w-4 h-4 rounded border-white/10 bg-white/5 text-indigo-600 focus:ring-indigo-500"
                                        {{ in_array($service->id, $booking->services->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-white group-hover:text-indigo-400">{{ $service->nama_service }}</span>
                                        <span class="text-[9px] text-slate-500 tracking-tighter">Rp {{ number_format($service->harga) }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                    Date
                                </label>
                                <input 
                                    type="date" 
                                    name="tgl_booking" 
                                    value="{{ $booking->tgl_booking }}"
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all"
                                    required
                                >
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                    Start Window
                                </label>
                                <input 
                                    type="time" 
                                    name="jam_mulai" 
                                    value="{{ substr($booking->jam_mulai, 0, 5) }}"
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all"
                                    required
                                >
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">
                                    Current Status
                                </label>
                                <select 
                                    name="status" 
                                    class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer"
                                    required
                                >
                                    @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                                        <option value="{{ $status }}" class="bg-[#050505]" {{ $booking->status == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button 
                                type="submit"
                                class="flex-[2] group relative px-8 py-3.5 bg-white text-black rounded-xl text-[10px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-lg"
                            >
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10 w-full text-center">Commit Changes</span>
                            </button>

                            <a 
                                href="{{ route('admin.bookings.index') }}"
                                class="flex-1 px-8 py-3.5 bg-white/[0.03] border border-white/10 rounded-xl text-center text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-all shadow-sm"
                            >
                                Back
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-6 opacity-30 shrink-0 text-center">
                    <p class="text-[8px] font-bold text-slate-500 uppercase tracking-[0.5em]">
                        Reservation Protocol Update Node
                    </p>
                </div>
            </div>
        </main>
    </div>

    <style>
        body, html { overflow: hidden !important; height: 100vh; width: 100vw; margin: 0; background-color: #050505; }
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&display=swap');
        .font-display { font-family: 'Playfair Display', serif; }
        .z-10 { animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes luxuryEntrance { from { opacity: 0; transform: translateY(15px) scale(0.99); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .custom-scroll::-webkit-scrollbar { width: 3px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 10px; }
    </style>
</x-app-layout>