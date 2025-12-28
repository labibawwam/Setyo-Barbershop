<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col items-center relative overflow-y-auto custom-scroll bg-[#050505] px-4 md:px-8 lg:px-12 py-10 md:py-16">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[200px] md:w-[300px] h-[200px] md:h-[300px] bg-purple-600/5 blur-[70px] md:blur-[100px] pointer-events-none"></div>
            
            <div class="md:hidden self-start mb-6 relative z-20">
                <button @click="isSidebarOpen = true" class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                </button>
            </div>

            <div class="w-full max-w-3xl relative z-10 flex flex-col items-center my-auto entrance-animation">
                
                <div class="mb-8 md:mb-10 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-5xl font-bold text-white tracking-tight leading-tight uppercase">
                        Manual <span class="text-indigo-500 italic font-serif lowercase">Reservation</span>
                    </h1>
                    <p class="text-[8px] md:text-[10px] font-bold uppercase tracking-[0.3em] md:tracking-[0.4em] text-slate-500 mt-3">
                        Professional Appointment Configuration
                    </p>
                </div>

                @if (session('error'))
                <div class="w-full mb-8 animate-[luxuryEntrance_0.5s_ease-out] bg-indigo-500/10 border border-indigo-500/30 rounded-[2rem] p-5 md:p-6 shadow-[0_0_40px_rgba(99,102,241,0.15)] backdrop-blur-md">
                    <div class="flex flex-col sm:flex-row items-start gap-4">
                        <div class="w-10 h-10 md:w-12 md:h-12 shrink-0 rounded-2xl bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-[9px] md:text-[10px] font-black uppercase tracking-[0.3em] text-indigo-400 mb-1">Schedule Conflict Detected</h4>
                            <p class="text-xs md:text-sm text-slate-200 leading-relaxed">
                                {{ session('error') }}
                            </p>
                            <div class="mt-4">
                                <button type="button" onclick="useRecommendedTime()" class="w-full sm:w-auto group flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-widest px-6 py-3 bg-white text-black rounded-xl hover:bg-indigo-500 hover:text-white transition-all shadow-lg active:scale-95">
                                    Apply Recommendation
                                    <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="3" stroke-linecap="round"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="w-full bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-5 md:space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Client Profile</label>
                                <div class="relative">
                                    <select name="user_id" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer pr-12" required>
                                        <option value="" disabled selected class="bg-[#050505]">Select Registered User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" class="bg-[#050505]" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-focus-within:text-indigo-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                                </div>
                            </div>

                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Assigned Artist</label>
                                <div class="relative">
                                    <select name="kapster_id" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer pr-12" required>
                                        <option value="" disabled selected class="bg-[#050505]">Choose Kapster</option>
                                        @foreach($kapsters as $k)
                                            <option value="{{ $k->id }}" class="bg-[#050505]" {{ old('kapster_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-focus-within:text-indigo-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1">Treatment Selection</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-[200px] md:max-h-[160px] overflow-y-auto custom-scroll p-3 bg-white/[0.01] rounded-xl border border-white/10">
                                @foreach($services as $service)
                                <label class="flex items-center gap-3 p-3 bg-white/[0.03] border border-white/5 rounded-xl cursor-pointer hover:bg-white/10 transition-all group">
                                    <input type="checkbox" name="service_ids[]" value="{{ $service->id }}" class="w-5 h-5 md:w-4 md:h-4 rounded border-white/10 bg-white/5 text-indigo-600 focus:ring-indigo-500 cursor-pointer" {{ is_array(old('service_ids')) && in_array($service->id, old('service_ids')) ? 'checked' : '' }}>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-xs font-bold text-white group-hover:text-indigo-400 truncate">{{ $service->nama_service }}</span>
                                        <span class="text-[9px] text-slate-500 tracking-tighter">Rp {{ number_format($service->harga) }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 md:gap-6">
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Session Date</label>
                                <input type="date" name="tgl_booking" value="{{ old('tgl_booking') }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all [color-scheme:dark]" required>
                            </div>

                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Start Window</label>
                                <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all [color-scheme:dark]" required>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4 md:pt-6">
                            <button type="submit" class="w-full sm:flex-[2] group relative px-8 py-4 bg-white text-black rounded-xl md:rounded-2xl text-[10px] md:text-[11px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-lg shadow-indigo-500/10">
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10 w-full text-center italic tracking-widest">Deploy Reservation</span>
                            </button>

                            <a href="{{ route('admin.bookings.index') }}" class="w-full sm:flex-1 px-8 py-4 bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl text-center text-[10px] md:text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-white hover:bg-white/5 transition-all shadow-sm">Cancel</a>
                        </div>
                    </form>
                </div>

                <div class="mt-8 md:mt-12 opacity-30 shrink-0 text-center mb-6">
                    <p class="text-[7px] md:text-[8px] font-bold text-slate-500 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="hidden xs:block w-10 md:w-16 h-px bg-gradient-to-r from-transparent to-slate-700"></span>
                        Reservation Protocol • Node 2.1
                        <span class="hidden xs:block w-10 md:w-16 h-px bg-gradient-to-l from-transparent to-slate-700"></span>
                    </p>
                </div>
            </div>
        </main>
    </div>

    

    <script>
        function useRecommendedTime() {
            const errorMessage = "{{ session('error') }}";
            const timeMatch = errorMessage.match(/jam\s(\d{2}:\d{2})/);
            if (timeMatch) {
                const timeInput = document.querySelector('input[name="jam_mulai"]');
                timeInput.value = timeMatch[1];
                timeInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                timeInput.classList.add('border-indigo-500', 'ring-4', 'ring-indigo-500/20');
                setTimeout(() => timeInput.classList.remove('border-indigo-500', 'ring-4', 'ring-indigo-500/20'), 2000);
            }
        }
    </script>

    <style>
        /* Modern Scrollbar Styling */
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 10px; }
        
        body, html { 
            background-color: #050505; 
            margin: 0;
            padding: 0;
        }

        .font-display { font-family: 'Playfair Display', serif; }

        .entrance-animation {
            animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

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