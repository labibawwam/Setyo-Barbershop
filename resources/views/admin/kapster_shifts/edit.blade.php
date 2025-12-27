<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        <x-sidebar />

        <main class="flex-1 flex flex-col justify-center items-center relative overflow-hidden px-8 lg:px-12">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-purple-600/5 blur-[120px] pointer-events-none"></div>
            
            <div class="w-full max-w-2xl relative z-10 flex flex-col items-center">
                <div class="mb-8 text-center shrink-0">
                    <h1 class="font-display text-4xl md:text-5xl font-bold text-white tracking-tight">
                        Modify <span class="text-indigo-500 italic font-serif">Shift Schedule</span>
                    </h1>
                    <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-slate-500 mt-3">
                        Updating Artist: {{ $kapsterShift->kapster->nama }}
                    </p>
                </div>

                <div class="w-full bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[3rem] p-8 lg:p-10 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.kapster_shifts.update', $kapsterShift->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400 ml-1">Duty Day</label>
                            <select name="hari" class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-5 py-3.5 text-sm text-white appearance-none focus:outline-none focus:border-indigo-500 transition-all cursor-pointer" required>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}" class="bg-[#0b0b0b]" {{ $kapsterShift->hari == $day ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="time-inputs" class="grid grid-cols-1 md:grid-cols-2 gap-6 {{ $kapsterShift->is_libur ? 'opacity-20 pointer-events-none grayscale' : '' }}">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400 ml-1">Start Time</label>
                                <input type="time" name="jam_mulai" value="{{ \Carbon\Carbon::parse($kapsterShift->jam_mulai)->format('H:i') }}" class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-5 py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400 ml-1">End Time</label>
                                <input type="time" name="jam_selesai" value="{{ \Carbon\Carbon::parse($kapsterShift->jam_selesai)->format('H:i') }}" class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-5 py-3.5 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                        </div>

                        <div class="flex items-center gap-3 px-2 py-1">
                            <input type="checkbox" name="is_libur" id="is_libur" class="w-4 h-4 rounded border-white/10 bg-white/5 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer" {{ $kapsterShift->is_libur ? 'checked' : '' }} onchange="toggleTimeInputs(this)">
                            <label for="is_libur" class="text-xs font-bold uppercase tracking-widest text-slate-400 cursor-pointer select-none">Mark as Day Off / Closed</label>
                        </div>

                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit" class="flex-[2] group relative px-8 py-4 bg-white text-black rounded-[1.5rem] text-[11px] font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:text-white active:scale-95 overflow-hidden shadow-lg">
                                <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10">Commit Changes</span>
                            </button>
                            <a href="{{ route('admin.kapster_shifts.index') }}" class="flex-1 px-8 py-4 bg-white/[0.03] border border-white/10 rounded-[1.5rem] text-center text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-all">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleTimeInputs(checkbox) {
            const timeInputs = document.getElementById('time-inputs');
            if (checkbox.checked) {
                timeInputs.classList.add('opacity-20', 'pointer-events-none', 'grayscale');
            } else {
                timeInputs.classList.remove('opacity-20', 'pointer-events-none', 'grayscale');
            }
        }
    </script>
</x-app-layout>