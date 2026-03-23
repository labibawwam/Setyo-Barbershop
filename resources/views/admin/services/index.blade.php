<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <x-sidebar>
            <main class="flex-1 flex flex-col h-full min-w-0 bg-[#f8fafc] relative">
                
                <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-500/[0.04] blur-[80px] md:blur-[120px] pointer-events-none z-0"></div>
                
                <div class="flex-none px-6 md:px-12 py-6 md:py-8 border-b border-slate-200 bg-white/70 backdrop-blur-xl z-20">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-10 bg-indigo-600 rounded-full"></div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                                    Barber <span class="text-indigo-600 italic font-serif text-xl md:text-2xl font-normal lowercase tracking-normal">services</span>
                                </h1>
                                <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 mt-1 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)] animate-pulse"></span>
                                    <span>Menu Layanan & Katalog Perawatan Setyo</span>
                                </p>
                            </div>
                        </div>
                        
                        <a href="{{ route('admin.services.create') }}" 
                           class="group relative px-8 py-3.5 bg-slate-900 text-white rounded-2xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all hover:bg-indigo-600 hover:shadow-lg active:scale-95 overflow-hidden">
                            <div class="absolute inset-0 bg-indigo-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                            <span class="relative z-10 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                                Tambah Layanan
                            </span>
                        </a>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto custom-scroll z-10">
                    <div class="px-6 md:px-12 py-8">
                        
                        <div class="inline-block min-w-full align-middle">
                            <table class="min-w-full border-separate border-spacing-y-4">
                                <thead class="sticky top-0 bg-[#f8fafc] z-30">
                                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">
                                        <th class="py-4 px-6 text-center w-20">No</th>
                                        <th class="py-4 px-6 text-left">Detail Layanan</th>
                                        <th class="py-4 px-6 text-center">Kategori</th>
                                        <th class="py-4 px-6 text-center">Durasi</th>
                                        <th class="py-4 px-6 text-center">Harga</th>
                                        <th class="py-4 px-6 text-right w-32">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($services as $index => $service)
                                    <tr class="group transition-all duration-300">
                                        <td class="py-5 px-6 bg-white border-y border-l border-slate-200 rounded-l-[2rem] text-center font-mono text-xs text-indigo-500 shadow-sm group-hover:bg-slate-50">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </td>

                                        <td class="py-5 px-6 bg-white border-y border-slate-200 shadow-sm group-hover:bg-slate-50">
                                            <div class="flex items-center gap-4">
                                                <div class="shrink-0">
                                                    @if($service->gambar)
                                                        <img src="{{ asset('storage/' . $service->gambar) }}" class="w-12 h-12 rounded-2xl object-cover border border-slate-100 shadow-sm group-hover:rotate-3 transition-transform">
                                                    @else
                                                        <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[8px] font-black text-slate-300 italic text-center">NO IMG</div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="text-sm font-extrabold text-slate-800 group-hover:text-indigo-600 transition-colors truncate">{{ $service->nama_service }}</div>
                                                    <div class="text-[10px] text-slate-400 italic truncate max-w-[200px]">{{ $service->deskripsi }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-5 px-6 bg-white border-y border-slate-200 text-center shadow-sm group-hover:bg-slate-50">
                                            <span class="px-3 py-1.5 rounded-xl bg-indigo-50 border border-indigo-100 text-[9px] font-black uppercase tracking-widest text-indigo-600">
                                                {{ $service->category->nama_kategori ?? 'Umum' }}
                                            </span>
                                        </td>

                                        <td class="py-5 px-6 bg-white border-y border-slate-200 text-center text-xs font-bold text-slate-500 shadow-sm group-hover:bg-slate-50">
                                            <div class="flex items-center justify-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                {{ $service->durasi }} Min
                                            </div>
                                        </td>

                                        <td class="py-5 px-6 bg-white border-y border-slate-200 text-center shadow-sm group-hover:bg-slate-50">
                                            <span class="text-sm font-black text-slate-900 tracking-tighter">
                                                Rp {{ number_format($service->harga, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        <td class="py-5 px-6 bg-white border-y border-r border-slate-200 rounded-r-[2rem] text-right shadow-sm group-hover:bg-slate-50">
                                            <div class="flex justify-end gap-3">
                                                <a href="{{ route('admin.services.edit', $service->id) }}" class="p-2.5 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </a>
                                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="py-20 text-center">
                                            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-slate-300">Belum ada layanan terdaftar</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-12 py-6 border-t border-slate-200 text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">© 2026 SETYO BARBERSHOP • KATALOG LAYANAN</p>
                        </div>
                    </div>
                </div>

            </main>
        </x-sidebar>
    </div>

    <style>
        body, html { 
            overflow: hidden !important; 
            height: 100vh; 
            width: 100vw; 
            background-color: #f8fafc; 
            margin: 0;
        }

        .custom-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        table { border-collapse: separate; table-layout: fixed; }
        th, td { white-space: nowrap; }
        .pointer-events-none { pointer-events: none !important; }
    </style>
</x-app-layout>