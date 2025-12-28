<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col items-center relative overflow-y-auto custom-scroll bg-[#050505] px-6 md:px-12 py-10 md:py-16">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[300px] md:w-[400px] h-[300px] md:h-[400px] bg-purple-600/5 blur-[70px] md:blur-[100px] pointer-events-none"></div>

            <div class="md:hidden self-start mb-6 relative z-20">
                <button @click="isSidebarOpen = true" class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                </button>
            </div>
            
            <div class="w-full max-w-2xl relative z-10 flex flex-col items-center my-auto entrance-animation">
                
                <div class="mb-8 md:mb-10 text-center shrink-0">
                    <h1 class="font-display text-3xl md:text-5xl font-bold text-white tracking-tight leading-tight uppercase">
                        Assign <span class="text-indigo-500 italic font-serif lowercase">Work Shift</span>
                    </h1>
                    <p class="text-[8px] md:text-[10px] font-bold uppercase tracking-[0.3em] md:tracking-[0.4em] text-slate-500 mt-3">
                        Operational Schedule Configuration
                    </p>
                </div>

                <div class="w-full bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.kapster_shifts.store') }}" method="POST" class="space-y-5 md:space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 md:gap-6">
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Select Artist</label>
                                <div class="relative">
                                    <select name="kapster_id" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3.5 text-sm text-white appearance-none focus:outline-none focus:border-indigo-500 transition-all cursor-pointer pr-12" required>
                                        @foreach($kapsters as $kapster)
                                            <option value="{{ $kapster->id }}" class="bg-[#0b0b0b]">{{ $kapster->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Duty Day</label>
                                <div class="relative">
                                    <select name="hari" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3.5 text-sm text-white appearance-none focus:outline-none focus:border-indigo-500 transition-all cursor-pointer pr-12" required>
                                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                            <option value="{{ $day }}" class="bg-[#0b0b0b]">{{ $day }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="time-inputs" class="grid grid-cols-1 sm:grid-cols-2 gap-5 md:gap-6 transition-all duration-500">
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Start Time</label>
                                <input type="time" name="jam_mulai" value="10:00" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all [color-scheme:dark]">
                            </div>
                            <div class="space-y-2 group">
                                <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">End Time</label>
                                <input type="time" name="jam_selesai" value="21:00" class="w-full bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl px-5 py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all [color-scheme:dark]">
                            </div>
                        </div>

                        <div class="flex items-center gap-3 px-1 py-1">
                            <input type="checkbox" name="is_libur" id="is_libur" class="w-5 h-5 rounded border-white/10 bg-white/5 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer" onchange="toggleTimeInputs(this)">
                            <label for="is_libur" class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-slate-400 cursor-pointer select-none">Mark as Day Off / Closed</label>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                            <button type="submit" class="w-full sm:flex-[2] group relative px-8 py-3.5 md:py-4 bg-white text-black rounded-xl md:rounded-2xl text-[10px] md:text-[11px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-lg">
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10">Deploy Shift</span>
                            </button>
                            <a href="{{ route('admin.kapster_shifts.index') }}" class="w-full sm:flex-1 px-8 py-3.5 md:py-4 bg-white/[0.03] border border-white/10 rounded-xl md:rounded-2xl text-center text-[10px] md:text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-white hover:bg-white/5 transition-all text-center">Cancel</a>
                        </div>
                    </form>
                </div>

                <div class="mt-8 md:mt-10 opacity-30 shrink-0 text-center mb-6">
                    <p class="text-[7px] md:text-[8px] font-bold text-slate-500 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="hidden xs:block w-12 md:w-16 h-px bg-slate-700"></span>
                        Internal Operational Protocol
                        <span class="hidden xs:block w-12 md:w-16 h-px bg-slate-700"></span>
                    </p>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleTimeInputs(checkbox) {
            const timeInputs = document.getElementById('time-inputs');
            if (checkbox.checked) {
                timeInputs.classList.add('opacity-10', 'pointer-events-none', 'grayscale');
            } else {
                timeInputs.classList.remove('opacity-10', 'pointer-events-none', 'grayscale');
            }
        }
    </script>

    <style>
        /* Modern Scrollbar Styling */
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 20px; }
        
        body, html { background-color: #050505; margin: 0; padding: 0; }
        .font-display { font-family: 'Playfair Display', serif; }

        .entrance-animation { animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes luxuryEntrance { 
            from { opacity: 0; transform: translateY(20px) scale(0.98); } 
            to { opacity: 1; transform: translateY(0) scale(1); } 
        }

        /* Dark Theme Time Picker Fix */
        input[type="time"]::-webkit-calendar-picker-indicator { filter: invert(1); opacity: 0.5; cursor: pointer; }
        
        /* Mobile Tap Highlight */
        * { -webkit-tap-highlight-color: transparent; }
    </style>
</x-app-layout>