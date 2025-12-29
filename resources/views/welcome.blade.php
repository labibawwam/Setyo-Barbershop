<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setyo Barbershop | Premium Grooming Experience</title>

    <link rel="icon" href="{{ asset('gambar/setyo1.jpg') }}" type="image/jpeg" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('gambar/setyo1.jpg') }}">

    @vite('resources/css/app.css')
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .text-gradient {
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="bg-[#050505] text-gray-200 antialiased selection:bg-indigo-500 selection:text-white">

    <x-navbar />

    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
      <div class="absolute inset-0 z-0">
    <img src="{{ asset('gambar/mainbg.jpeg') }}"
         class="w-full h-full object-cover opacity-20 scale-105 motion-safe:animate-[pulse_8s_ease-in-out_infinite]">
    <div class="absolute inset-0 bg-gradient-to-b from-black via-transparent to-[#050505]"></div>
</div>

        <div class="relative z-10 max-w-5xl px-6 text-center">
            <span class="inline-block px-4 py-1.5 mb-6 text-xs font-bold tracking-[0.2em] uppercase bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 rounded-full">
                The Gentleman's Choice
            </span>
            
            <h1 class="font-display text-5xl md:text-8xl font-bold text-white leading-[1.1] mb-8">
                Classic Style for<br>
                <span class="text-gradient italic">Modern Man</span>
            </h1>

            <p class="mt-6 text-lg md:text-xl text-gray-400 max-w-2xl mx-auto leading-relaxed">
                Lebih dari sekadar potong rambut. Kami memberikan rasa percaya diri melalui sentuhan tangan kapster profesional dan atmosfer yang eksklusif.
            </p>
        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce opacity-50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
        </div>
    </section>
<section id="kapster" class="py-24 relative bg-[#050505] overflow-hidden">
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[350px] h-[350px] bg-indigo-900/5 blur-[100px] pointer-events-none"></div>

    <div class="max-w-[1440px] mx-auto px-6 relative z-10">
        <div class="flex flex-col items-center text-center mb-16">
            <div class="inline-block">
                <p class="text-indigo-500 font-black uppercase tracking-[0.4em] text-[9px] mb-3">
                    Our Professional Artist Team
                </p>
                <div class="h-[1px] w-full bg-gradient-to-r from-transparent via-indigo-500 to-transparent mb-5"></div>
            </div>
            <h2 class="font-display text-4xl md:text-6xl font-bold text-white leading-tight tracking-tight">
                Master <span class="text-indigo-500 italic font-serif font-light">Groomers</span>
            </h2>
        </div>

        <div class="relative w-full overflow-hidden group/container" style="mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);">
            <div class="flex gap-5 loop-track group-hover/container:pause-animation">
                
                @foreach ($kapsters as $kps)
                <div class="flex-none w-[200px] md:w-[240px]">
                    <div class="group relative overflow-hidden rounded-[2.5rem] aspect-[4/5] border border-white/10 bg-white/[0.02] transition-all duration-700 hover:border-indigo-500/40 hover:-translate-y-2 shadow-2xl">
                        <img src="{{ asset('storage/' . ($kps->photo)) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $kps->nama }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-[#050505]/40 to-transparent opacity-90"></div>
                        <div class="absolute bottom-8 left-0 right-0 px-6 text-center">
                            <p class="text-indigo-500 font-black uppercase tracking-[0.3em] text-[8px] mb-2">Professional Artist</p>
                            <h3 class="text-xl font-bold text-white tracking-tight leading-none group-hover:text-indigo-400">{{ $kps->nama }}</h3>
                        </div>
                    </div>
                </div>
                @endforeach

                @foreach ($kapsters as $kps)
                <div class="flex-none w-[200px] md:w-[240px]" aria-hidden="true">
                    <div class="group relative overflow-hidden rounded-[2.5rem] aspect-[4/5] border border-white/10 bg-white/[0.02] transition-all duration-700 hover:border-indigo-500/40 hover:-translate-y-2 shadow-2xl">
                        <img src="{{ asset('storage/' . ($kps->photo)) }}" class="w-full h-full object-cover" alt="{{ $kps->nama }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-[#050505]/40 to-transparent opacity-90"></div>
                        <div class="absolute bottom-8 left-0 right-0 px-6 text-center">
                            <p class="text-indigo-500 font-black uppercase tracking-[0.3em] text-[8px] mb-2">Professional Artist</p>
                            <h3 class="text-xl font-bold text-white tracking-tight leading-none">{{ $kps->nama }}</h3>
                        </div>
                    </div>
                </div>
                @endforeach

                @foreach ($kapsters as $kps)
                <div class="flex-none w-[200px] md:w-[240px]" aria-hidden="true">
                    <div class="group relative overflow-hidden rounded-[2.5rem] aspect-[4/5] border border-white/10 bg-white/[0.02] transition-all duration-700 hover:border-indigo-500/40 hover:-translate-y-2 shadow-2xl">
                        <img src="{{ asset('storage/' . ($kps->photo)) }}" class="w-full h-full object-cover" alt="{{ $kps->nama }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-[#050505]/40 to-transparent opacity-90"></div>
                        <div class="absolute bottom-8 left-0 right-0 px-6 text-center">
                            <p class="text-indigo-500 font-black uppercase tracking-[0.3em] text-[8px] mb-2">Professional Artist</p>
                            <h3 class="text-xl font-bold text-white tracking-tight leading-none">{{ $kps->nama }}</h3>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    <style>
        .loop-track {
            display: flex;
            width: max-content; 
            /* Kecepatan 30 detik untuk kelancaran visual dengan 3 set */
            animation: scroll-triple 30s linear infinite;
        }

        .pause-animation {
            animation-play-state: paused;
        }

        @keyframes scroll-triple {
            0% {
                transform: translateX(0);
            }
            100% {
                /* Bergerak tepat 1/3 dari total lebar track karena ada 3 set data */
                transform: translateX(-33.3333%);
            }
        }

        @media (max-width: 768px) {
            .loop-track { animation: scroll-triple 15s linear infinite; }
        }
    </style>
</section>
<section id="services" class="py-32 bg-[#050505] relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/10 blur-[150px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-900/10 blur-[120px] pointer-events-none"></div>

    <div class="max-w-[1440px] mx-auto px-6 relative z-10">
        <div class="flex flex-col items-center text-center mb-16">
            <div class="inline-block">
                <p class="text-indigo-500 font-black uppercase tracking-[0.4em] text-[10px] mb-4">
                    The Art of Grooming
                </p>
                <div class="h-[1px] w-full bg-gradient-to-r from-transparent via-indigo-500 to-transparent mb-6"></div>
            </div>
            <h2 class="font-display text-4xl md:text-6xl font-bold text-white leading-tight tracking-tight">
                Layanan <span class="text-indigo-500 italic font-serif font-light">Exclusive</span>
            </h2>
        </div>

       <div class="flex flex-wrap justify-center gap-6 md:gap-12 mb-20">
    @foreach ($categories as $index => $category)
    <button onclick="filterCategory('{{ $category->id }}', this)" 
        class="category-tab group flex flex-col items-center gap-2 transition-all duration-500 {{ $index == 0 ? 'active-tab' : 'opacity-40 hover:opacity-100' }}">
        
        <span class="text-[11px] md:text-xs font-black uppercase tracking-[0.3em] text-white group-[.active-tab]:text-indigo-400 transition-colors duration-300">
            {{ $category->nama_kategori }}
        </span>

        <div class="h-[2px] w-0 bg-indigo-500 rounded-full transition-all duration-500 group-[.active-tab]:w-full shadow-[0_0_10px_rgba(99,102,241,0.8)]"></div>
    </button>
    @endforeach
</div>

        <div id="services-container">
            @foreach ($categories as $index => $category)
            <div id="cat-{{ $category->id }}" class="category-content {{ $index == 0 ? 'block' : 'hidden' }} animate-fade-in">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 items-stretch">
                    @foreach ($category->services as $srv)
                    <div class="group relative bg-white/[0.01] border border-white/10 rounded-[2.5rem] p-5 transition-all duration-700 hover:bg-white/[0.03] hover:border-indigo-500/40 hover:-translate-y-3 flex flex-col">
                        
                        <div class="relative overflow-hidden rounded-[2rem] h-64 mb-6 shadow-2xl flex-shrink-0">
                            <img src="{{ asset('storage/' . $srv->gambar) }}"
                                 class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                 alt="{{ $srv->nama_service }}">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-transparent to-transparent opacity-80"></div>
                            
                            <div class="absolute bottom-4 left-4 right-4 flex justify-center">
                                <div class="backdrop-blur-md bg-black/40 border border-white/10 px-4 py-2 rounded-xl transition-all duration-500 group-hover:bg-indigo-600">
                                    <span class="text-sm font-black text-white tracking-tighter">Rp {{ number_format($srv->harga, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-2 pb-2 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-white tracking-tight group-hover:text-indigo-400 transition-colors mb-3">
                                {{ $srv->nama_service }}
                            </h3>

                            <p class="text-gray-400 text-xs leading-relaxed mb-8 font-light italic">
                                {{ $srv->deskripsi }}
                            </p>

                            <div class="flex items-center justify-between border-t border-white/5 pt-5 mt-auto">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em]">{{ $srv->durasi }} Mins Session</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    function filterCategory(categoryId, element) {
        // 1. Sembunyikan semua konten kategori
        document.querySelectorAll('.category-content').forEach(content => {
            content.classList.add('hidden');
            content.classList.remove('block');
        });

        // 2. Tampilkan kategori yang diklik
        const selectedContent = document.getElementById('cat-' + categoryId);
        selectedContent.classList.remove('hidden');
        selectedContent.classList.add('block');

        // 3. Update styling tab (tombol)
        document.querySelectorAll('.category-tab').forEach(tab => {
            tab.classList.remove('active-tab', 'opacity-100');
            tab.classList.add('opacity-50');
        });
        element.classList.add('active-tab', 'opacity-100');
        element.classList.remove('opacity-50');
    }
</script>

<style>
    /* Animasi muncul halus saat klik */
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
    <section id="about" class="py-32 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="relative">
    <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-600/10 rounded-full blur-3xl"></div>
    
    <img src="{{ asset('gambar/bg1.jpeg') }}" 
         alt="Background Barbershop"
         class="relative z-10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] grayscale-[0.5] hover:grayscale-0 transition-all duration-700 object-cover">
</div>

            <div>
                <h4 class="text-indigo-500 font-bold tracking-[0.3em] uppercase text-sm mb-4">Legacy & Quality</h4>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-8 leading-tight">Membangun Karakter Melalui Potongan Rambut</h2>
                <p class="text-gray-400 text-lg leading-relaxed mb-8">
                    Setyo Barbershop lahir dari semangat untuk menghadirkan standar baru dalam dunia grooming pria di Klaten. Kami percaya bahwa setiap pria berhak mendapatkan perawatan terbaik dengan detail yang presisi.
                </p>

                <div class="grid grid-cols-2 gap-6">
                    <div class="flex items-start space-x-3">
                        <span class="text-indigo-500 font-bold">01.</span>
                        <span class="text-gray-200 font-medium">Kapster Berpengalaman</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <span class="text-indigo-500 font-bold">02.</span>
                        <span class="text-gray-200 font-medium">Alat Steril & Higienis</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <span class="text-indigo-500 font-bold">03.</span>
                        <span class="text-gray-200 font-medium">Layanan Profesional</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <span class="text-indigo-500 font-bold">04.</span>
                        <span class="text-gray-200 font-medium">Suasana Eksklusif</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

 <section id="contact" class="py-32 bg-[#050505] relative overflow-hidden">
    <div class="absolute top-1/2 left-0 w-[500px] h-[500px] bg-indigo-600/10 blur-[150px] -z-10"></div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 items-start">
            
            <div class="lg:col-span-1">
                <div class="inline-block mb-4">
                    <p class="text-indigo-500 font-black uppercase tracking-[0.4em] text-[10px]">Find Our Studio</p>
                    <div class="h-[1px] w-12 bg-indigo-500 mt-2"></div>
                </div>
                
                <h2 class="font-display text-5xl md:text-6xl font-bold text-white mb-10 leading-tight">
                    Get in <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 italic">Touch</span>
                </h2>

                <div class="space-y-12">
                    <a href="https://maps.google.com/?q=Setyo+Barbershop+Delanggu" target="_blank" class="flex items-start space-x-6 group cursor-pointer">
                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center justify-center group-hover:bg-indigo-600 group-hover:border-indigo-500 transition-all duration-500 group-hover:-translate-y-2 shadow-xl">
                            <svg class="w-6 h-6 text-indigo-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-[10px] uppercase tracking-[0.3em] font-black mb-1">Our Location</p>
                            <p class="text-white text-lg font-medium leading-relaxed group-hover:text-indigo-400 transition-colors">Jl. Lkr. Delanggu, Krecek,<br>Kab. Klaten, Jawa Tengah</p>
                        </div>
                    </a>

                    <div class="flex items-start space-x-6 group">
                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center justify-center group-hover:bg-indigo-600 group-hover:border-indigo-500 transition-all duration-500 group-hover:-translate-y-2 shadow-xl">
                            <svg class="w-6 h-6 text-indigo-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <p class="text-gray-500 text-[10px] uppercase tracking-[0.3em] font-black mb-5">Operating Hours</p>
                            
                            <div class="space-y-3.5 w-full max-w-[260px]">
                                <div class="flex justify-between items-center group/day">
                                    <span class="text-xs font-bold text-slate-500 group-hover/day:text-slate-300 transition-colors">Senin</span>
                                    <span class="text-[9px] font-black text-red-500/80 uppercase tracking-widest bg-red-500/5 px-3 py-1 rounded-lg border border-red-500/10">Tutup / Libur</span>
                                </div>
                                
                                @php
                                    $days = ['Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                @endphp
                                
                                @foreach($days as $day)
                                <div class="flex justify-between items-center group/day border-t border-white/[0.03] pt-3.5">
                                    <span class="text-xs font-bold text-slate-400 group-hover/day:text-white transition-colors">{{ $day }}</span>
                                    <span class="text-[11px] font-mono font-bold text-slate-200 group-hover/day:text-indigo-400 transition-colors">10:00 — 21:00</span>
                                </div>
                                @endforeach
                                
                                <div class="mt-5 pt-4 border-t border-indigo-500/10 flex items-center gap-2">
                                    <div class="w-1 h-1 rounded-full bg-indigo-500 animate-pulse"></div>
                                    <p class="text-[8px] text-indigo-400/60 font-black uppercase tracking-[0.2em]">WIB — Waktu Indonesia Barat</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="tel:085641728429" class="flex items-start space-x-6 group cursor-pointer">
                        <div class="w-14 h-14 shrink-0 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center justify-center group-hover:bg-indigo-600 group-hover:border-indigo-500 transition-all duration-500 group-hover:-translate-y-2 shadow-xl">
                            <svg class="w-6 h-6 text-indigo-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-[10px] uppercase tracking-[0.3em] font-black mb-1">Make a Call</p>
                            <p class="text-white text-2xl font-bold tracking-tighter group-hover:text-indigo-400 transition-colors">0856 4172 8429</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="lg:col-span-2 relative group h-full self-stretch">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[2.5rem] blur opacity-10 group-hover:opacity-30 transition duration-1000"></div>
                
                <div class="relative rounded-[2.5rem] overflow-hidden border border-white/10 h-[600px] lg:h-full min-h-[500px] shadow-2xl bg-[#111]">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.77457497274!2d110.6849493!3d-7.7073238!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwNDInMjYuNCJTIDExMMKwNDEnMDUuOCJF!5e0!3m2!1sid!2sid!4v1625000000000!5m2!1sid!2sid" 
                        width="100%" height="100%" style="border:0; filter: grayscale(100%) invert(92%) contrast(83%);" allowfullscreen="" loading="lazy">
                    </iframe>
                    
                    <div class="absolute bottom-8 left-8 right-8 p-6 backdrop-blur-md bg-black/40 border border-white/10 rounded-3xl flex items-center justify-between opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-700">
                        <div class="flex items-center space-x-4">
                            <div class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse shadow-[0_0_10px_#22c55e]"></div>
                            <div>
                                <p class="text-white font-bold text-sm uppercase tracking-widest">Studio Open Now</p>
                                <p class="text-[9px] text-slate-400 font-medium">Ready for your transformation</p>
                            </div>
                        </div>
                        <a href="https://maps.google.com/?q=Setyo+Barbershop+Delanggu" target="_blank" class="px-7 py-3 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-white hover:text-indigo-600 transition-all shadow-lg active:scale-95">Open in Maps</a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<footer class="bg-black pt-24 pb-12 border-t border-white/5 relative overflow-hidden">
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full h-[300px] bg-indigo-600/5 blur-[120px] -z-10"></div>

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col items-center text-center">
            <h2 class="font-display text-4xl font-bold text-white mb-4 tracking-tighter">Setyo<span class="text-indigo-500">.</span></h2>
            <div class="h-[1px] w-20 bg-gradient-to-r from-transparent via-indigo-500 to-transparent mb-8"></div>
            
            <p class="text-gray-400 max-w-md leading-relaxed text-sm mb-12">
                Elevating your grooming experience with professional touch and timeless style. Since 2017.
            </p>

            <div class="flex justify-center space-x-8 mb-16">
                <a href="https://www.instagram.com/stybarber.std/" target="_blank" class="group relative">
    <span class="text-gray-500 text-xs font-black uppercase tracking-[0.2em] group-hover:text-white transition-colors">Instagram</span>
    <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-indigo-500 transition-all duration-500 group-hover:w-full"></span>
</a>
              <a href="https://wa.me/6285641728429" target="_blank" class="group relative">
    <span class="text-gray-500 text-xs font-black uppercase tracking-[0.2em] group-hover:text-white transition-colors">WhatsApp</span>
    <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-indigo-500 transition-all duration-500 group-hover:w-full"></span>
</a>
            </div>

            <div class="pt-12 border-t border-white/5 w-full flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-gray-600 text-[9px] tracking-[0.3em] uppercase font-bold italic">
                    Designed for Excellence — Setyo Barbershop
                </p>
                <p class="text-gray-600 text-[9px] tracking-[0.3em] uppercase font-black">
                    © {{ date('Y') }} All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>