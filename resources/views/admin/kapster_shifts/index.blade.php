<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-hidden">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            
            <div class="flex-none px-6 md:px-8 py-6 lg:px-10 border-b border-white/[0.05] bg-[#050505]/50 backdrop-blur-sm z-10">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-4 min-w-0">
                        <button @click="isSidebarOpen = true" class="md:hidden p-2.5 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </button>
                        <div class="min-w-0">
                            <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight flex items-center gap-3">
                                Work <span class="text-indigo-500 italic font-serif text-xl md:text-2xl font-normal lowercase tracking-normal">shifts</span>
                            </h1>
                            <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mt-1 md:mt-2 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                                <span class="truncate">Weekly Operational Schedule</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full lg:max-w-2xl lg:justify-end">
                        <form action="{{ route('admin.kapster_shifts.index') }}" method="GET" class="relative group flex-1 sm:max-w-xs">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search artist..." 
                                   class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl py-2.5 pl-11 pr-4 text-xs font-bold text-white placeholder-slate-600 focus:ring-2 focus:ring-indigo-500/50 transition-all duration-300">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-indigo-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            </div>
                        </form>

                        <a href="{{ route('admin.kapster_shifts.create') }}" 
                           class="shrink-0 group relative px-6 py-3 bg-white text-black rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all hover:bg-indigo-500 hover:text-white active:scale-95 text-center overflow-hidden">
                            <div class="absolute inset-0 bg-indigo-600 translate-y-[100%] group-hover:translate-y-0 transition-transform duration-300"></div>
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 6v12m6-6H6"/></svg>
                                Assign Shift
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-hidden flex flex-col relative">
                <div class="flex-1 overflow-auto custom-scroll px-6 md:px-8 lg:px-10 py-4">
                    <table class="w-full text-left border-separate border-spacing-y-3 min-w-[800px]">
                        <thead class="sticky top-0 z-20 bg-[#050505]">
                            <tr class="text-[10px] font-black text-slate-500 uppercase tracking-[0.25em]">
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[30%]">Kapster Artist</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[15%]">Day</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[25%]">Time Window</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] w-[15%] text-center">Status</th>
                                <th class="py-4 px-6 border-b border-white/[0.05] text-right w-[15%]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-transparent">
                            @foreach($kapsters as $kapster)
                                @php
                                    $orderedDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                    $sortedShifts = $kapster->shifts->sortBy(function($shift) use ($orderedDays) {
                                        return array_search($shift->hari, $orderedDays);
                                    });
                                @endphp
                                @foreach($sortedShifts as $shift)
                                <tr class="group transition-all duration-500 hover:translate-x-1">
                                    <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] rounded-l-2xl border-y border-l border-white/[0.05]">
                                        <div class="flex items-center gap-3">
                                            <div class="shrink-0 w-8 h-8 md:w-9 md:h-9 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 font-bold text-[10px]">
                                                {{ strtoupper(substr($kapster->nama, 0, 2)) }}
                                            </div>
                                            <div class="text-sm font-bold text-white truncate">{{ $kapster->nama }}</div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05]">
                                        <span class="text-xs font-mono text-slate-400 tracking-wider">{{ $shift->hari }}</span>
                                    </td>
                                    <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05]">
                                        @if($shift->is_libur)
                                            <span class="text-[10px] text-slate-600 italic font-black tracking-widest opacity-50">— CLOSED —</span>
                                        @else
                                            <span class="text-xs font-bold text-indigo-400 bg-indigo-500/5 px-2 py-1 rounded-md border border-indigo-500/10">
                                                {{ \Carbon\Carbon::parse($shift->jam_mulai)->format('H:i') }} <span class="text-slate-600 mx-1">/</span> {{ \Carbon\Carbon::parse($shift->jam_selesai)->format('H:i') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-white/[0.05] text-center">
                                        <span class="px-3 py-1 rounded-lg {{ $shift->is_libur ? 'bg-red-500/10 text-red-500 border-red-500/20' : 'bg-green-500/10 text-green-500 border-green-500/20' }} text-[9px] font-black uppercase tracking-widest border">
                                            {{ $shift->is_libur ? 'Day Off' : 'On Duty' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 bg-white/[0.03] group-hover:bg-white/[0.06] border-y border-r border-white/[0.05] rounded-r-2xl text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.kapster_shifts.edit', $shift->id) }}" class="p-2 rounded-lg bg-indigo-600/10 text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg></a>
                                            <form action="{{ route('admin.kapster_shifts.destroy', $shift->id) }}" method="POST" onsubmit="return confirm('Secure Warning: Delete entry?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg bg-red-600/10 text-red-400 hover:bg-red-600 hover:text-white transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M14.74 9l-.34 9m-4.72 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </main>
    </div>

    <style>
        body, html { overflow: hidden; height: 100vh; width: 100vw; background-color: #050505; }
        .custom-scroll::-webkit-scrollbar { width: 4px; height: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 20px; }
        table { border-collapse: separate; table-layout: auto; }
        th, td { white-space: nowrap; }
    </style>
</x-app-layout>