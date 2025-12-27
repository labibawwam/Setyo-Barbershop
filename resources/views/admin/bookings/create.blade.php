<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col justify-center items-center relative overflow-hidden px-6 lg:px-12">
            
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-purple-600/5 blur-[100px] pointer-events-none"></div>
            
            <div class="w-full max-w-3xl relative z-10">
                
                <div class="mb-6 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-4xl font-bold text-white tracking-tight leading-tight">
                        Manual <span class="text-indigo-500 italic font-serif">Reservation</span>
                    </h1>
                    <p class="text-[9px] font-bold uppercase tracking-[0.4em] text-slate-500 mt-2">
                        Professional Appointment Configuration
                    </p>
                </div>

                @if (session('error'))
                <div class="mb-6 animate-[luxuryEntrance_0.5s_ease-out] bg-indigo-500/10 border border-indigo-500/30 rounded-[2rem] p-5 shadow-[0_0_40px_rgba(99,102,241,0.15)] backdrop-blur-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-400 mb-1">Schedule Conflict Detected</h4>
                            <p class="text-sm text-slate-200 leading-relaxed">
                                {{ session('error') }}
                            </p>
                            <div class="mt-3">
                                <button type="button" onclick="useRecommendedTime()" class="group flex items-center gap-2 text-[10px] font-black uppercase tracking-widest px-5 py-2.5 bg-white text-black rounded-xl hover:bg-indigo-500 hover:text-white transition-all shadow-lg active:scale-95">
                                    Apply Recommendation
                                    <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="3" stroke-linecap="round"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[2.5rem] p-6 lg:p-8 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">Client Profile</label>
                                <select name="user_id" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer" required>
                                    <option value="" disabled selected class="bg-[#050505]">Select Registered User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" class="bg-[#050505]" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">Assigned Artist</label>
                                <select name="kapster_id" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer" required>
                                    <option value="" disabled selected class="bg-[#050505]">Choose Kapster</option>
                                    @foreach($kapsters as $k)
                                        <option value="{{ $k->id }}" class="bg-[#050505]" {{ old('kapster_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">Treatment Selection</label>
                            <div class="grid grid-cols-2 gap-3 max-h-[160px] overflow-y-auto custom-scroll p-3 bg-white/[0.01] rounded-xl border border-white/10">
                                @foreach($services as $service)
                                <label class="flex items-center gap-3 p-2.5 bg-white/[0.03] border border-white/5 rounded-lg cursor-pointer hover:bg-white/10 transition-all group">
                                    <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" class="w-4 h-4 rounded border-white/10 bg-white/5 text-indigo-600 focus:ring-indigo-500" {{ is_array(old('service_ids')) && in_array($service->id, old('service_ids')) ? 'checked' : '' }}>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-white group-hover:text-indigo-400">{{ $service->nama_service }}</span>
                                        <span class="text-[9px] text-slate-500 tracking-tighter">Rp {{ number_format($service->harga) }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">Session Date</label>
                                <input type="date" name="tgl_booking" value="{{ old('tgl_booking') }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all shadow-inner" required>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">Start Window</label>
                                <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-2.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all shadow-inner" required>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="flex-[2] group relative px-8 py-3.5 bg-white text-black rounded-xl text-[10px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-lg shadow-indigo-500/10">
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10 w-full text-center italic">Deploy Reservation</span>
                            </button>

                            <a href="{{ route('admin.bookings.index') }}" class="flex-1 px-8 py-3.5 bg-white/[0.03] border border-white/10 rounded-xl text-center text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-all shadow-sm">Cancel</a>
                        </div>
                    </form>
                </div>

                <div class="mt-6 opacity-30 shrink-0 text-center">
                    <p class="text-[8px] font-bold text-slate-500 uppercase tracking-[0.5em]">Reservation Protocol • Version 2.1.0</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Logika untuk mengisi jam otomatis dari rekomendasi
        function useRecommendedTime() {
            const errorMessage = "{{ session('error') }}";
            const timeMatch = errorMessage.match(/jam\s(\d{2}:\d{2})/);
            if (timeMatch) {
                const timeInput = document.querySelector('input[name="jam_mulai"]');
                timeInput.value = timeMatch[1];
                
                // Tambahkan efek visual saat input terisi
                timeInput.classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500/20');
                setTimeout(() => {
                    timeInput.classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-500/20');
                }, 2000);
            }
        }
    </script>

    <style>
        body, html { overflow: hidden !important; height: 100vh; width: 100vw; margin: 0; background-color: #050505; }
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&display=swap');
        .font-display { font-family: 'Playfair Display', serif; }
        .z-10 { animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        
        @keyframes luxuryEntrance { 
            from { opacity: 0; transform: translateY(20px) scale(0.98); } 
            to { opacity: 1; transform: translateY(0) scale(1); } 
        }

        .custom-scroll::-webkit-scrollbar { width: 3px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 10px; }
        select option { background-color: #050505; color: white; }
    </style>
</x-app-layout>