<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setyo Barbershop - Elite Grooming Experience</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&family=Instrument+Serif:italic&display=swap');
        :root { --primary: #6366f1; --accent: #fbbf24; --bg: #050505; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg); color: #cbd5e1;
            background-image: radial-gradient(circle at 0% 0%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                              radial-gradient(circle at 100% 100%, rgba(251, 191, 36, 0.02) 0%, transparent 50%);
        }
        .font-serif { font-family: 'Instrument Serif', serif; }
        .step-content { display: none; width: 100%; flex-direction: column; }
        .step-content.active { display: flex; animation: slideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes slideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .item-selected { border-color: var(--primary) !important; background: rgba(99, 102, 241, 0.12) !important; box-shadow: 0 0 20px rgba(99, 102, 241, 0.2); transform: translateY(-2px); }
        .gold-gradient { background: linear-gradient(to right, #fbbf24, #d97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.3); border-radius: 20px; }
        input[type="time"]::-webkit-calendar-picker-indicator { filter: invert(1); cursor: pointer; }
        @keyframes slideQuick { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
        .toast-animate { animation: slideQuick 0.3s ease forwards; }
    </style>
</head>
<body class="antialiased">

    <div id="notification-container" class="fixed top-8 right-8 z-[200] space-y-4 w-full max-w-[350px]">
        @if(session('success') || session('error'))
            <div class="toast-item toast-animate glass border-{{ session('success') ? 'green' : 'red' }}-500/30 p-5 rounded-3xl flex items-center gap-4 shadow-2xl">
                <div class="bg-{{ session('success') ? 'green' : 'red' }}-500 p-2 rounded-2xl text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="{{ session('success') ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <p class="text-sm text-white font-bold">{{ session('success') ?? session('error') }}</p>
            </div>
        @endif
    </div>

    <div class="min-h-screen flex flex-col lg:flex-row">
        <aside class="lg:w-[360px] lg:h-screen lg:fixed left-0 top-0 p-12 flex flex-col justify-between border-r border-white/5 bg-black/40 backdrop-blur-2xl z-20">
            <div>
                <a href="/" class="block mb-16">
                    <h1 class="text-3xl font-black text-white tracking-tighter italic">SETYO<span class="text-indigo-500">.</span></h1>
                    <p class="text-[9px] text-indigo-400/60 tracking-[0.5em] uppercase font-bold mt-2">Elite Grooming Co.</p>
                </a>
                <nav class="space-y-10 relative">
                    <div id="line-progress" class="absolute left-[15px] top-2 w-[2px] h-0 bg-indigo-500 transition-all duration-1000"></div>
                    <div class="flex items-center gap-8 group cursor-pointer nav-link" id="nav-1" onclick="showStep(1)">
                        <div class="w-8 h-8 rounded-2xl border border-white/10 flex items-center justify-center text-[11px] font-black z-10 bg-[#050505]" id="dot-1">01</div>
                        <span class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500" id="txt-1">Barber</span>
                    </div>
                    <div class="flex items-center gap-8 group cursor-pointer nav-link" id="nav-2" onclick="showStep(2)">
                        <div class="w-8 h-8 rounded-2xl border border-white/10 flex items-center justify-center text-[11px] font-black z-10 bg-[#050505]" id="dot-2">02</div>
                        <span class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500" id="txt-2">Treatments</span>
                    </div>
                    <div class="flex items-center gap-8 group cursor-pointer nav-link" id="nav-3" onclick="showStep(3)">
                        <div class="w-8 h-8 rounded-2xl border border-white/10 flex items-center justify-center text-[11px] font-black z-10 bg-[#050505]" id="dot-3">03</div>
                        <span class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-500" id="txt-3">Schedule</span>
                    </div>
                </nav>
                <div class="mt-20 space-y-4">
                    <button onclick="showStep(4)" id="nav-4" class="nav-link w-full flex items-center justify-between p-5 rounded-3xl bg-white/[0.03] border border-white/5 hover:border-indigo-500/50 transition-all">
                        <span class="text-[11px] font-black uppercase tracking-widest text-slate-400">Profile</span>
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/></svg>
                    </button>
                    <button onclick="showStep(5)" id="nav-5" class="nav-link w-full flex items-center justify-between p-5 rounded-3xl bg-white/[0.03] border border-white/5 hover:border-indigo-500/50 transition-all">
                        <span class="text-[11px] font-black uppercase tracking-widest text-slate-400">My Bookings</span>
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-width="2"/></svg>
                    </button>
                </div>
            </div>
        </aside>

        <main class="flex-grow lg:ml-[360px] min-h-screen p-8 lg:p-16 flex items-center justify-center">
            <div class="w-full max-w-5xl">
                <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                    @csrf
                    <div id="step-1" class="step-content active">
                        <div class="text-center mb-16"><h2 class="text-5xl lg:text-7xl font-bold text-white tracking-tighter italic">Define Your <br><span class="gold-gradient font-serif">master artist</span></h2></div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($kapsters as $k)
                            <div onclick="selectKapster(this, '{{ $k->id }}', '{{ $k->nama }}')" class="kapster-item group glass rounded-[3rem] p-8 transition-all duration-500 cursor-pointer flex flex-col items-center">
                                <img src="{{ asset('storage/' . $k->photo) }}" class="w-32 h-32 rounded-full object-cover border-4 border-white/5 mb-6" onerror="this.src='https://ui-avatars.com/api/?name={{$k->nama}}&background=111&color=fff'">
                                <h4 class="text-xl font-bold text-white tracking-tight">{{ $k->nama }}</h4>
                                <p class="text-[10px] text-indigo-400 font-black uppercase tracking-[0.2em] mt-2">Senior Barber</p>
                            </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="kapster_id" id="input_kapster" required>
                    </div>

                    <div id="step-2" class="step-content">
                        <div class="flex flex-col lg:flex-row justify-between items-center mb-12 gap-8">
                            <h2 class="text-5xl lg:text-7xl font-bold text-white tracking-tighter italic text-center lg:text-left">Elite <br><span class="gold-gradient font-serif">treatments</span></h2>
                            <div class="glass px-10 py-5 rounded-[2rem] border-indigo-500/20 text-center">
                                <p class="text-[10px] text-slate-500 uppercase font-black mb-1">Estimates</p>
                                <p id="total-price-display" class="text-3xl font-black text-white italic">Rp 0</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-h-[50vh] overflow-y-auto pr-4 custom-scrollbar">
                            @foreach($services as $s)
                            <div onclick="toggleService(this, '{{ $s->id }}', '{{ $s->nama_service }}', {{ $s->harga }})" class="service-item glass p-6 rounded-[2.5rem] cursor-pointer flex items-center justify-between group transition-all duration-300">
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-white group-hover:text-indigo-400">{{ $s->nama_service }}</h3>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase mt-1">{{ $s->durasi }} Mins • Rp {{ number_format($s->harga, 0, ',', '.') }}</p>
                                </div>
                                <input type="checkbox" name="service_ids[]" value="{{ $s->id }}" class="hidden service-checkbox">
                                <div class="tick-ui w-6 h-6 rounded-full border-2 border-white/10 flex items-center justify-center transition-all group-hover:border-indigo-500"><div class="w-2 h-2 bg-indigo-500 rounded-full scale-0 transition-transform"></div></div>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" id="btn-next-step-2" onclick="showStep(3)" class="w-full mt-10 py-6 bg-indigo-600 text-white rounded-[2rem] font-black uppercase text-xs tracking-[0.3em] disabled:opacity-30 transition-all" disabled>Set Schedule</button>
                    </div>

                    <div id="step-3" class="step-content">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                            <div class="glass p-10 rounded-[3rem]">
                                <h3 class="text-2xl font-bold text-white mb-8 tracking-tight italic">Pick Your <span class="text-amber-500">Date</span></h3>
                                <div id="flatpickr-inline" class="flex justify-center"></div>
                                <input type="text" name="tgl_booking" id="tgl_booking" class="hidden" required>
                            </div>
                            <div class="flex flex-col gap-8">
                                <div class="glass p-10 rounded-[3rem] text-center">
                                    <p class="text-[11px] text-indigo-400 font-black uppercase tracking-[0.3em] mb-6">Arrival Time</p>
                                    <input type="time" name="jam_mulai" id="jam_mulai" class="w-full bg-transparent border-none text-7xl font-black text-white text-center focus:ring-0 appearance-none" required>
                                </div>
                                <button type="button" onclick="showStep(6)" class="w-full py-7 bg-white text-black rounded-[2rem] font-black uppercase text-xs tracking-[0.3em] hover:bg-indigo-600 hover:text-white transition-all shadow-2xl">Summary Details</button>
                            </div>
                        </div>
                    </div>

                    <div id="step-6" class="step-content items-center">
                        <div class="w-full max-w-xl glass rounded-[4rem] overflow-hidden border-white/10">
                            <div class="p-12 text-center bg-indigo-600/10">
                                <h3 class="text-amber-500 font-black uppercase text-[10px] tracking-[0.5em] mb-2">Final Confirmation</h3>
                                <h2 class="text-4xl font-serif text-white italic leading-none">Elite Reservation</h2>
                            </div>
                            <div class="p-12 space-y-8 text-sm">
                                <div class="flex justify-between border-b border-white/5 pb-6"><span class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">Artist</span><span id="rev-artist" class="text-white font-bold"></span></div>
                                <div class="flex justify-between border-b border-white/5 pb-6"><span class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">Schedule</span><span id="rev-datetime" class="text-white font-bold tracking-tight"></span></div>
                                <div><span class="text-[10px] uppercase font-bold text-slate-500 block mb-4 tracking-widest">Treatments</span><ul id="rev-services" class="grid grid-cols-1 gap-3 italic text-slate-300"></ul></div>
                                <div class="pt-8 border-t border-dashed border-white/20 flex justify-between items-center"><span class="text-[12px] uppercase font-black text-indigo-400">Payable</span><span id="rev-total" class="text-3xl font-black text-white italic"></span></div>
                            </div>
                            <div class="px-12 pb-12"><button type="submit" class="w-full py-6 bg-indigo-600 text-white rounded-[2rem] font-black uppercase text-xs tracking-[0.4em] hover:bg-indigo-500 active:scale-95 shadow-xl shadow-indigo-500/30">Secure Booking Now</button></div>
                        </div>
                    </div>
                </form>

                <div id="step-4" class="step-content">
    <div class="glass p-12 rounded-[4rem] w-full max-w-2xl mx-auto relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 via-amber-500 to-indigo-500"></div>
        
        <div class="text-center mb-10">
            <h2 class="text-4xl font-bold text-white tracking-tighter italic">Edit <span class="gold-gradient font-serif">profile</span></h2>
            <p class="text-[10px] text-slate-500 uppercase tracking-[0.3em] mt-2 font-black">Identity Master Control</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')

            <div class="w-24 h-24 rounded-[2rem] bg-indigo-600/20 mx-auto mb-10 flex items-center justify-center text-4xl text-white italic font-black border border-white/10 shadow-2xl">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>

            <div class="space-y-6">
                <div class="group">
                    <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-4 group-focus-within:text-indigo-400 transition-colors">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                        class="w-full mt-2 bg-white/[0.03] border border-white/10 rounded-3xl px-8 py-5 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300" required>
                </div>

                <div class="group">
                    <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-4 group-focus-within:text-indigo-400 transition-colors">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                        class="w-full mt-2 bg-white/[0.03] border border-white/10 rounded-3xl px-8 py-5 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300" required>
                </div>
            </div>

            <div class="flex flex-col gap-4 mt-12">
                <button type="submit" class="w-full py-6 bg-indigo-600 text-white rounded-[2rem] font-black uppercase text-xs tracking-[0.3em] hover:bg-indigo-500 active:scale-95 transition-all shadow-xl shadow-indigo-500/20">
                    Update Identity
                </button>
            </div>
        </form>

        <div class="mt-8 pt-8 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-4 text-red-500/50 hover:text-red-500 text-[10px] font-black uppercase tracking-[0.4em] transition-all">
                    Secure Sign Out
                </button>
            </form>
        </div>
    </div>
</div>

                <div id="step-5" class="step-content">
                    <h2 class="text-5xl lg:text-7xl font-bold text-white tracking-tighter italic mb-12">My <span class="gold-gradient font-serif lowercase">appointments</span></h2>
                    <div class="grid grid-cols-1 gap-6 max-h-[60vh] overflow-y-auto pr-4 custom-scrollbar">
                        @forelse($myBookings as $booking)
                        <div class="glass p-8 rounded-[3rem] border-white/5 flex flex-col md:flex-row justify-between items-center gap-8 group transition-all">
                            <div class="flex items-center gap-8 w-full">
                                <div class="w-20 h-20 shrink-0 rounded-[2rem] bg-indigo-500/10 border border-indigo-500/20 flex flex-col items-center justify-center text-indigo-400">
                                    <span class="text-[11px] font-black uppercase">{{ \Carbon\Carbon::parse($booking->tgl_booking)->format('M') }}</span>
                                    <span class="text-3xl font-black italic">{{ \Carbon\Carbon::parse($booking->tgl_booking)->format('d') }}</span>
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-xl font-bold text-white truncate tracking-tight">{{ $booking->kapster->nama }}</h4>
                                    <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border 
                                        @if($booking->status == 'confirmed') border-green-500/20 bg-green-500/10 text-green-500
                                        @elseif($booking->status == 'cancelled') border-red-500/20 bg-red-500/10 text-red-500
                                        @else border-amber-500/20 bg-amber-500/10 text-amber-500 @endif">{{ $booking->status }}</span>
                                    <p class="text-[11px] font-mono text-slate-500 uppercase mt-2 italic">{{ substr($booking->jam_mulai, 0, 5) }} — {{ substr($booking->jam_selesai, 0, 5) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 w-full md:w-auto justify-end">
    <button type="button" onclick="openDetailModal('{{ $booking->id }}')" class="px-8 py-3.5 rounded-2xl bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-widest text-white hover:bg-white/10 transition-all">Details</button>
    
    @if($booking->status != 'cancelled' && $booking->status != 'completed')
    <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Securely cancel this elite booking?')">
        @csrf 
        @method('PATCH')
        <button type="submit" class="w-12 h-12 rounded-2xl bg-red-500/10 text-red-500 border border-red-500/20 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all active:scale-90 shadow-lg shadow-red-500/5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </form>
    @endif
</div>
                        </div>
                        @empty
                        <div class="text-center py-32 glass rounded-[4rem] border-dashed border-white/10 opacity-40 italic font-serif text-3xl">No elite grooming sessions.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="modal-detail" class="fixed inset-0 z-[150] hidden items-center justify-center p-8 backdrop-blur-3xl bg-black/90">
        <div class="w-full max-w-xl glass border-white/10 rounded-[4rem] p-12 shadow-2xl relative">
            <h2 class="text-4xl font-bold text-white mb-10 tracking-tight italic">Detail <span class="font-serif gold-gradient">booking</span></h2>
            <div class="space-y-8">
                <div class="flex justify-between border-b border-white/5 pb-5"><span class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">Artist</span><span id="det-artist" class="text-white font-bold"></span></div>
                <div class="flex justify-between border-b border-white/5 pb-5"><span class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">Schedule</span><span id="det-schedule" class="text-white font-bold"></span></div>
                <div class="border-t border-white/5 pt-4"><ul id="det-services" class="space-y-3 text-white italic text-sm"></ul></div>
                <div class="border-t border-white/5 pt-8 flex justify-between items-center"><span class="text-indigo-400 font-black uppercase text-[12px]">Total Paid</span><span id="det-total" class="text-3xl font-black text-white italic"></span></div>
            </div>
            <button onclick="closeDetailModal()" class="w-full mt-12 py-5 bg-white text-black rounded-[2rem] font-black uppercase text-[10px] tracking-widest hover:bg-indigo-600 transition-all">Close Ticket</button>
        </div>
    </div>

    <script>
        let selectedServiceIds = [];
        let selectedServiceNames = [];
        let totalPrice = 0;
        let selectedArtistName = "";
        const myBookingsData = @json($myBookings);

        function formatDate(dateString) {
            if(!dateString) return "-";
            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            return new Date(dateString).toLocaleDateString('en-GB', options);
        }

        function showStep(step) {
            document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
            const target = document.getElementById('step-' + step);
            if(target) target.classList.add('active');
            updateSidebarUI(step);
            if(step === 6) updateReview();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function updateSidebarUI(step) {
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('border-indigo-500/50', 'bg-indigo-500/5'));
            const line = document.getElementById('line-progress');
            if(step <= 3) {
                line.style.height = step === 1 ? '0%' : step === 2 ? '50%' : '100%';
                for(let i=1; i<=3; i++) {
                    const dot = document.getElementById('dot-'+i);
                    const txt = document.getElementById('txt-'+i);
                    if(i <= step) { dot.classList.add('bg-indigo-600', 'border-indigo-600', 'text-white'); txt.classList.add('text-white'); }
                    else { dot.classList.remove('bg-indigo-600', 'border-indigo-600', 'text-white'); txt.classList.remove('text-white'); }
                }
            } else {
                const activeNav = document.getElementById('nav-' + step);
                if(activeNav) activeNav.classList.add('border-indigo-500/50', 'bg-indigo-500/5');
            }
        }

        function selectKapster(el, id, name) {
            selectedArtistName = name;
            document.querySelectorAll('.kapster-item').forEach(i => i.classList.remove('item-selected'));
            el.classList.add('item-selected');
            document.getElementById('input_kapster').value = id;
            setTimeout(() => showStep(2), 500);
        }

        function toggleService(el, id, name, harga) {
            const checkbox = el.querySelector('.service-checkbox');
            const dot = el.querySelector('.tick-ui div');
            checkbox.checked = !checkbox.checked;
            if (checkbox.checked) {
                selectedServiceIds.push(id); selectedServiceNames.push(name); totalPrice += harga;
                el.classList.add('item-selected'); dot.classList.add('scale-100');
            } else {
                selectedServiceIds = selectedServiceIds.filter(i => i !== id);
                selectedServiceNames = selectedServiceNames.filter(n => n !== name);
                totalPrice -= harga;
                el.classList.remove('item-selected'); dot.classList.remove('scale-100');
            }
            document.getElementById('total-price-display').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');
            document.getElementById('btn-next-step-2').disabled = selectedServiceIds.length === 0;
        }

        function updateReview() {
            document.getElementById('rev-artist').innerText = selectedArtistName || "Not Selected";
            const date = document.getElementById('tgl_booking').value;
            const time = document.getElementById('jam_mulai').value;
            document.getElementById('rev-datetime').innerText = date ? `${formatDate(date)} at ${time}` : "Schedule not set";
            document.getElementById('rev-total').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');
            document.getElementById('rev-services').innerHTML = selectedServiceNames.map(n => `<li class="flex items-center gap-3"><div class="w-1 h-1 bg-amber-500 rounded-full"></div> ${n}</li>`).join('');
        }

        function openDetailModal(id) {
            const booking = myBookingsData.find(b => b.id == id);
            if (!booking) return;
            document.getElementById('det-artist').innerText = booking.kapster.nama;
            document.getElementById('det-schedule').innerText = `${formatDate(booking.tgl_booking)} at ${booking.jam_mulai.substring(0,5)}`;
            document.getElementById('det-total').innerText = 'Rp ' + parseInt(booking.total_harga).toLocaleString('id-ID');
            document.getElementById('det-services').innerHTML = booking.services.map(s => `<li class="flex items-center gap-3"><div class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></div> ${s.nama_service}</li>`).join('');
            document.getElementById('modal-detail').classList.remove('hidden');
            document.getElementById('modal-detail').classList.add('flex');
        }

        function closeDetailModal() {
            document.getElementById('modal-detail').classList.add('hidden');
            document.getElementById('modal-detail').classList.remove('flex');
        }

        // Script untuk menghilangkan toast otomatis
        window.addEventListener('load', () => {
            const toast = document.querySelector('.toast-item');
            if(toast) {
                setTimeout(() => {
                    toast.style.transition = 'all 0.5s ease';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-20px)';
                    setTimeout(() => toast.remove(), 500);
                }, 4000);
            }
        });

        flatpickr("#tgl_booking", { inline: true, minDate: "today", dateFormat: "Y-m-d", appendTo: document.getElementById('flatpickr-inline'), onChange: (sd, ds) => document.getElementById('tgl_booking').value = ds });
    </script>
</body>
</html>