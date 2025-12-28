<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300 text-[13px]">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 bg-[#050505] relative overflow-y-auto custom-scroll">
            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-600/5 blur-[80px] md:blur-[120px] pointer-events-none"></div>
            
            <div class="px-4 md:px-8 lg:px-12 py-6 md:py-10 relative z-10">
                
                <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-8 mb-10 md:mb-12">
                    <div class="flex items-center gap-4 min-w-0">
                        <button @click="isSidebarOpen = true" class="md:hidden p-2 rounded-xl bg-white/5 border border-white/10 text-indigo-400 active:scale-95 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </button>
                        <div class="min-w-0">
                            <h1 class="text-2xl md:text-4xl font-black text-white tracking-tighter uppercase truncate">
                                Operating <span class="text-indigo-500 italic font-serif lowercase tracking-normal">analytics</span>
                            </h1>
                            <p class="text-[8px] md:text-[10px] font-bold uppercase tracking-[0.3em] text-slate-500 mt-1 md:mt-2 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                                Real-time Data Visualization
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.reports.index') }}" method="GET" class="w-full xl:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3 glass p-2 rounded-2xl border border-white/5 shadow-2xl">
                        <div class="flex flex-1 items-center divide-x divide-white/10">
                            <div class="relative flex-1 group">
                                <select name="month" class="w-full appearance-none bg-transparent border-none text-[11px] text-white focus:ring-0 cursor-pointer uppercase font-black tracking-widest pl-4 pr-10 py-2 relative z-10">
                                    @for($m=1; $m<=12; $m++)
                                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }} class="bg-[#0b0b0b]">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                    @endfor
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-white/20 group-hover:text-indigo-400 transition-colors"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M19 9l-7 7-7-7"/></svg></div>
                            </div>
                            <div class="relative flex-1 group">
                                <select name="year" class="w-full appearance-none bg-transparent border-none text-[11px] text-white focus:ring-0 cursor-pointer uppercase font-black tracking-widest pl-4 pr-10 py-2 relative z-10">
                                    @php $currentYear = date('Y'); @endphp
                                    @for($y = $currentYear; $y >= $currentYear - 5; $y--)
                                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }} class="bg-[#0b0b0b]">{{ $y }}</option>
                                    @endfor
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-white/20 group-hover:text-indigo-400 transition-colors"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M19 9l-7 7-7-7"/></svg></div>
                            </div>
                        </div>
                        <button type="submit" class="sm:px-6 py-2.5 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-indigo-500 transition-all shadow-lg active:scale-95">Sync Data</button>
                    </form>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8 mb-8 md:mb-12">
                    <div class="lg:col-span-2 glass p-6 md:p-8 lg:p-10 rounded-[2rem] md:rounded-[3rem] border border-white/5 shadow-2xl">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-[10px] md:text-xs font-black text-white uppercase tracking-widest opacity-50 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Revenue Trend
                            </h3>
                            <div class="text-right">
                                <p class="text-[8px] md:text-[10px] text-slate-500 font-bold uppercase">Period</p>
                                <p class="text-xs font-black text-white italic font-serif">{{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</p>
                            </div>
                        </div>
                        <div class="h-[250px] md:h-[350px]">
                            <canvas id="mainChart"></canvas>
                        </div>
                    </div>

                    <div class="lg:col-span-1 glass p-6 md:p-8 lg:p-10 rounded-[2rem] md:rounded-[3rem] border border-white/5 shadow-2xl flex flex-col">
                        <h3 class="text-[10px] md:text-xs font-black text-white uppercase tracking-widest mb-8 opacity-50">Booking Integrity</h3>
                        <div class="flex-1 flex items-center justify-center min-h-[250px]">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 relative z-10">
                    <div class="glass p-6 md:p-8 lg:p-10 rounded-[2rem] md:rounded-[3rem] border border-white/5">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-[10px] md:text-xs font-black text-white uppercase tracking-widest opacity-50">Master Artists</h3>
                            <span class="hidden xs:block text-[8px] font-black text-indigo-400 bg-indigo-500/10 px-4 py-1.5 rounded-full border border-indigo-500/20 uppercase italic">Efficiency</span>
                        </div>
                        <div class="space-y-5">
                            @forelse($kapsterPerformance as $kapster)
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-3 md:gap-4">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-gradient-to-br from-indigo-600/20 to-purple-600/20 border border-white/5 flex items-center justify-center font-black text-indigo-400 transition-all group-hover:scale-105">
                                        {{ substr($kapster->nama, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs md:text-sm font-black text-white group-hover:text-indigo-300 transition-colors uppercase tracking-tighter truncate">{{ $kapster->nama }}</p>
                                        <p class="text-[8px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">Top Performer</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-[11px] md:text-xs font-mono font-bold text-white tracking-tighter">{{ $kapster->bookings_count }} Sessions</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-[10px] text-slate-600 py-10 italic uppercase tracking-widest">No data collected</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="glass p-6 md:p-8 lg:p-10 rounded-[2rem] md:rounded-[3rem] border border-white/5">
                        <h3 class="text-[10px] md:text-xs font-black text-white uppercase tracking-widest mb-8 opacity-50">Demand Breakdown</h3>
                        <div class="space-y-6 md:y-8">
                            @forelse($popularServices as $service)
                            <div class="group">
                                <div class="flex justify-between items-end mb-2.5">
                                    <span class="text-[10px] md:text-xs font-black text-slate-300 uppercase tracking-wider group-hover:text-white transition-colors truncate pr-4">{{ $service->nama_service }}</span>
                                    <span class="text-[9px] font-mono text-indigo-400 font-bold shrink-0">{{ $service->bookings_count }} Orders</span>
                                </div>
                                <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-600 via-indigo-400 to-purple-500 shadow-[0_0_15px_rgba(99,102,241,0.4)] transition-all duration-1000" 
                                         style="width: {{ $totalBookings > 0 ? ($service->bookings_count / $totalBookings) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-[10px] text-slate-600 py-10 italic uppercase tracking-widest">No data collected</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="mt-12 md:mt-16 text-center opacity-20">
                    <p class="text-[7px] md:text-[8px] font-black text-slate-500 uppercase tracking-[0.5em] md:tracking-[1em] leading-relaxed">
                        Internal Command Center Analytics<br class="md:hidden"> — Setyo Barbershop Node
                    </p>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.color = '#64748b';
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

        const ctxMain = document.getElementById('mainChart').getContext('2d');
        new Chart(ctxMain, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Revenue',
                    data: [{{ $totalRevenue * 0.2 }}, {{ $totalRevenue * 0.4 }}, {{ $totalRevenue * 0.15 }}, {{ $totalRevenue * 0.25 }}],
                    borderColor: '#6366f1',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: (context) => {
                        const gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.12)');
                        gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');
                        return gradient;
                    },
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: 'rgba(255,255,255,0.02)', drawBorder: false }, ticks: { font: { size: 9 }, padding: 8 } },
                    x: { grid: { display: false }, ticks: { font: { size: 9 }, padding: 8 } }
                }
            }
        });

        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statusBreakdown->pluck('status')) !!},
                datasets: [{
                    data: {!! json_encode($statusBreakdown->pluck('total')) !!},
                    backgroundColor: ['#22c55e', '#6366f1', '#fbbf24', '#ef4444', '#64748b'],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 6, usePointStyle: true, padding: 15, font: { size: 9, weight: '700' } }
                    }
                }
            }
        });
    </script>

    <style>
        .custom-scroll::-webkit-scrollbar { width: 3px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.2); border-radius: 10px; }
        .glass { background: rgba(255, 255, 255, 0.01); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        
        /* Mobile Touch Optimizations */
        button, select { -webkit-tap-highlight-color: transparent; }
        
        main { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>