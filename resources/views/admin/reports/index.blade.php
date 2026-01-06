<x-app-layout>
    @php
        // Inisialisasi default jika variabel tidak terdefinisi dari controller
        $month = $month ?? date('n');
        $year = $year ?? date('Y');
        $totalRevenue = $totalRevenue ?? 0;
        $totalBookings = $totalBookings ?? 0;
    @endphp

    <div class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600 text-[13px]">
        
        <x-sidebar >

        <main class="flex-1 flex flex-col min-w-0 bg-[#f8fafc] relative overflow-y-auto custom-scroll">
            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-500/[0.04] blur-[80px] md:blur-[120px] pointer-events-none"></div>
            
            <div class="px-4 md:px-8 lg:px-12 py-6 md:py-10 relative z-10">
                
                <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-8 mb-10 md:mb-12">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="min-w-0">
                            <h1 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tighter uppercase truncate">
                                 <span class="text-indigo-600 italic font-serif lowercase tracking-normal">analytics</span>
                            </h1>
                            <p class="text-[8px] md:text-[10px] font-bold uppercase tracking-[0.3em] text-slate-400 mt-1 md:mt-2 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                                Real-time Data Visualization
                            </p>
                        </div>
                    </div>

            <form action="{{ route('admin.reports.index') }}" method="GET" class="w-full xl:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3 bg-white p-2 rounded-2xl border border-slate-200 shadow-sm transition-all hover:shadow-md">
    <div class="flex flex-1 items-center bg-slate-50/50 rounded-xl px-2 divide-x divide-slate-200">
        <div class="pr-2 pl-1 text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>

        <div class="relative min-w-[110px] md:min-w-[130px] flex-1 group">
            <select name="month" class="w-full appearance-none bg-transparent border-none text-[11px] text-slate-700 font-bold focus:ring-0 cursor-pointer uppercase tracking-widest pl-3 pr-7 py-2.5 relative z-10">
                @for($m=1; $m<=12; $m++)
                    <option value="{{ $m }}" @selected($month == $m) class="bg-white">
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>
            <div class="absolute right-1 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300 group-hover:text-indigo-500 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>

        <div class="relative min-w-[80px] flex-1 group">
            <select name="year" class="w-full appearance-none bg-transparent border-none text-[11px] text-slate-700 font-bold focus:ring-0 cursor-pointer uppercase tracking-widest pl-3 pr-7 py-2.5 relative z-10">
                @php $currentYear = date('Y'); @endphp
                @for($y = $currentYear; $y >= $currentYear - 5; $y--)
                    <option value="{{ $y }}" @selected($year == $y) class="bg-white">{{ $y }}</option>
                @endfor
            </select>
            <div class="absolute right-1 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300 group-hover:text-indigo-500 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>
    </div>

    <button type="submit" class="sm:px-6 py-2.5 bg-slate-900 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-indigo-600 hover:shadow-lg hover:shadow-indigo-200 transition-all duration-300 active:scale-95 flex items-center justify-center gap-2 shrink-0">
        <svg class="w-3.5 h-3.5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        <span>Sync Data</span>
    </button>
</form>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8 mb-8 md:mb-12">
                    <div class="lg:col-span-2 bg-white p-6 md:p-8 lg:p-10 rounded-[2rem] md:rounded-[3rem] border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Revenue Trend
                            </h3>
                            <div class="text-right">
                                <p class="text-[8px] md:text-[10px] text-slate-400 font-bold uppercase">Period</p>
                                <p class="text-xs font-black text-slate-900 italic font-serif">{{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</p>
                            </div>
                        </div>
                        <div class="h-[250px] md:h-[350px]">
                            <canvas id="mainChart"></canvas>
                        </div>
                    </div>

                    <div class="lg:col-span-1 bg-white p-6 md:p-8 lg:p-10 rounded-[2rem] md:rounded-[3rem] border border-slate-200 shadow-sm flex flex-col">
                        <h3 class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-8">Booking Integrity</h3>
                        <div class="flex-1 flex items-center justify-center min-h-[250px]">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 relative z-10">
                    <div class="bg-white p-6 md:p-8 lg:p-10 rounded-[2rem] md:rounded-[3rem] border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest">Master Artists</h3>
                            <span class="hidden xs:block text-[8px] font-black text-indigo-600 bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-100 uppercase italic">Efficiency</span>
                        </div>
                        <div class="space-y-5">
                            @forelse($kapsterPerformance ?? [] as $kapster)
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-3 md:gap-4">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center font-black text-indigo-600 transition-all group-hover:bg-indigo-600 group-hover:text-white">
                                        {{ substr($kapster->nama ?? '?', 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs md:text-sm font-black text-slate-900 group-hover:text-indigo-600 transition-colors uppercase tracking-tighter truncate">{{ $kapster->nama }}</p>
                                        <p class="text-[8px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Top Performer</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-[11px] md:text-xs font-mono font-bold text-slate-900 tracking-tighter">{{ $kapster->bookings_count }} Sessions</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-[10px] text-slate-400 py-10 italic uppercase tracking-widest">No data collected</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white p-6 md:p-8 lg:p-10 rounded-[2rem] md:rounded-[3rem] border border-slate-200 shadow-sm">
                        <h3 class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-8">Demand Breakdown</h3>
                        <div class="space-y-6 md:y-8">
                            @forelse($popularServices ?? [] as $service)
                            <div class="group">
                                <div class="flex justify-between items-end mb-2.5">
                                    <span class="text-[10px] md:text-xs font-black text-slate-700 uppercase tracking-wider group-hover:text-indigo-600 transition-colors truncate pr-4">{{ $service->nama_service }}</span>
                                    <span class="text-[9px] font-mono text-indigo-600 font-bold shrink-0">{{ $service->bookings_count }} Orders</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                    @php
                                        $percentage = ($totalBookings > 0) ? ($service->bookings_count / $totalBookings) * 100 : 0;
                                    @endphp
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-1000" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-[10px] text-slate-400 py-10 italic uppercase tracking-widest">No data collected</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="mt-12 md:mt-16 text-center opacity-40">
                    <p class="text-[7px] md:text-[8px] font-black text-slate-400 uppercase tracking-[0.5em] md:tracking-[1em] leading-relaxed">
                        Internal Command Center Analytics<br class="md:hidden"> — Setyo Barbershop Node
                    </p>
                </div>
            </div>
        </main>
        </x-sidebar>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Set chart colors for LIGHT theme
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

        const ctxMain = document.getElementById('mainChart').getContext('2d');
        new Chart(ctxMain, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Revenue',
                    data: [
                        {{ $totalRevenue * 0.2 }}, 
                        {{ $totalRevenue * 0.4 }}, 
                        {{ $totalRevenue * 0.15 }}, 
                        {{ $totalRevenue * 0.25 }}
                    ],
                    borderColor: '#4f46e5',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: (context) => {
                        const gradient = context.chart.ctx.createLinearGradient(0, 0, 0, 300);
                        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.08)');
                        gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');
                        return gradient;
                    },
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        grid: { color: '#f1f5f9', drawBorder: false }, 
                        ticks: { font: { size: 9 }, padding: 8, color: '#64748b' } 
                    },
                    x: { 
                        grid: { display: false }, 
                        ticks: { font: { size: 9 }, padding: 8, color: '#64748b' } 
                    }
                }
            }
        });

        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: @json($statusBreakdown->pluck('status') ?? []),
                datasets: [{
                    data: @json($statusBreakdown->pluck('total') ?? []),
                    backgroundColor: ['#10b981', '#4f46e5', '#f59e0b', '#ef4444', '#94a3b8'],
                    borderWidth: 4,
                    borderColor: '#ffffff',
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
                        labels: { boxWidth: 6, usePointStyle: true, padding: 15, font: { size: 9, weight: '700' }, color: '#475569' }
                    }
                }
            }
        });
    </script>

    <style>
        .custom-scroll::-webkit-scrollbar { width: 3px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        body, html { background-color: #f8fafc; margin: 0; padding: 0; }
        .font-display { font-family: 'Playfair Display', serif; }
        button, select { -webkit-tap-highlight-color: transparent; }
        main { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>