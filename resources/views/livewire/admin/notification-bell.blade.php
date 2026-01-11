<div wire:poll.keep-alive.5s>
    <x-dropdown align="right" width="80">
        {{-- TRIGGER --}}
        <x-slot name="trigger">
            <button
                class="relative p-2.5 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-indigo-600 transition-all outline-none group"
            >
                <svg class="w-6 h-6 transform group-hover:rotate-12 transition-transform duration-300"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9a6 6 0 00-12 0v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>

                @if($notifikasiBooking->count())
                    <span class="absolute top-2.5 right-2.5 flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border-2 border-white shadow-sm"></span>
                    </span>
                @endif
            </button>
        </x-slot>

        {{-- CONTENT --}}
        <x-slot name="content">
            <div class="w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
                
                {{-- HEADER --}}
                <div class="p-4 border-b bg-gradient-to-r from-slate-50/60 to-white flex justify-between items-center">
                    <div>
                        <h3 class="text-[11px] font-black uppercase tracking-wider">
                            Aktivitas Terbaru
                        </h3>
                        <p class="text-[9px] text-slate-400 font-medium">
                            Monitoring real-time
                        </p>
                    </div>

                    <div class="flex items-center gap-1.5 bg-indigo-50 border border-indigo-100 px-2 py-1 rounded-full">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-indigo-600"></span>
                        </span>
                        <span class="text-[8px] font-black text-indigo-700 uppercase">
                            Live
                        </span>
                    </div>
                </div>

                {{-- LIST DENGAN SORTIR --}}
                <div class="max-h-80 overflow-y-auto bg-white">
                    {{-- 💡 Penambahan sortByDesc di bawah ini --}}
                    @forelse($notifikasiBooking->sortByDesc('updated_at') as $booking)

                        {{-- 🔑 KEY UNIK --}}
                        <div
                            wire:key="notif-{{ $booking->id }}-{{ $booking->updated_at->timestamp }}"
                            class="p-4 border-b border-slate-50 hover:bg-slate-50/60 transition-all"
                        >
                            <div class="flex gap-3.5">
                                {{-- AVATAR --}}
                                <div class="w-9 h-9 rounded-xl bg-slate-100 border flex items-center justify-center text-[11px] font-black uppercase">
                                    {{ substr($booking->user->name, 0, 2) }}
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between mb-1">
                                        <p class="text-[10px] font-bold truncate uppercase">
                                            {{ $booking->user->name }}
                                        </p>

                                        @php
                                            $badge = [
                                                'confirmed' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                'cancelled' => 'bg-red-50 text-red-700 border-red-100',
                                            ][$booking->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                                        @endphp

                                        <span class="px-1.5 py-0.5 text-[7px] font-black uppercase rounded-md border {{ $badge }}">
                                            {{ $booking->status }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-end mt-2">
                                        <p class="text-[9px] text-slate-500 font-bold leading-tight">
                                            {{ \Carbon\Carbon::parse($booking->tgl_booking)->format('d M') }}
                                            •
                                            {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }}-{{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }} WIB
                                        </p>

                                        <div class="text-right">
                                            <p class="text-[9px] font-black text-indigo-600 uppercase">
                                                {{ $booking->kapster->nama_kapster }}
                                            </p>
                                            <p class="text-[7px] text-slate-400 italic font-black">
                                                {{ $booking->updated_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="p-10 text-center text-slate-400 text-[10px] font-bold uppercase">
                            Tidak ada notifikasi
                        </div>
                    @endforelse
                </div>

                {{-- FOOTER --}}
                <div class="p-3 bg-slate-50 border-t">
                    <a href="{{ route('admin.bookings.index') }}"
                       class="flex items-center justify-center gap-2 py-2.5 bg-slate-900 rounded-xl text-[9px] font-black uppercase tracking-widest text-white hover:bg-indigo-600 transition">
                        Database Booking →
                    </a>
                </div>
            </div>
        </x-slot>
    </x-dropdown>
</div>