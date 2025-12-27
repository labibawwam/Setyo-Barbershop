<header id="navbar" class="fixed w-full z-50 transition-all duration-500 backdrop-blur-lg bg-black/20 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <a href="/" class="flex items-center space-x-4 group">
            <div class="relative">
                <div class="absolute inset-0 bg-indigo-500 rounded-full blur-md opacity-0 group-hover:opacity-50 transition-opacity duration-500"></div>
                <div class="h-10 w-10 md:h-12 md:w-12 rounded-full overflow-hidden border-2 border-indigo-400/50 shadow-2xl relative z-10 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                    <img src="{{ asset('gambar/setyo1.jpg') }}" 
                         alt="Setyo Barbershop" 
                         class="h-full w-full object-cover">
                </div>
            </div>

            <div class="flex flex-col">
                <span class="text-lg md:text-xl font-black tracking-tighter text-white leading-none group-hover:text-indigo-400 transition-colors">
                    SETYO
                </span>
                <span class="text-[8px] md:text-[10px] font-bold tracking-[0.3em] text-indigo-400 uppercase">
                    Barbershop
                </span>
            </div>
        </a>

        <nav class="hidden md:flex items-center space-x-8">
            <div class="flex items-center space-x-6 text-sm font-medium tracking-wide">
                @php 
                    $navItems = [
                        ['name' => 'Hair Artist', 'link' => '#kapster'],
                        ['name' => 'Services', 'link' => '#services'],
                        ['name' => 'Booking', 'link' => route('booking.create')],
                        ['name' => 'About', 'link' => '#about'],
                    ];
                @endphp

                @foreach($navItems as $item)
                <a href="{{ $item['link'] }}" class="relative text-gray-300 hover:text-white transition-colors group py-2">
                    {{ $item['name'] }}
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-500 transition-all duration-300 group-hover:w-full"></span>
                </a>
                @endforeach
            </div>

            <div class="h-6 w-px bg-white/10 mx-2"></div>

            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-white hover:text-indigo-400 transition">Log in</a>
                    <a href="{{ route('register') }}" 
                       class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold px-6 py-2.5 rounded-full shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                        Daftar
                    </a>
                @else
                    <div class="flex items-center space-x-4 bg-white/5 border border-white/10 py-1.5 pl-4 pr-1.5 rounded-full">
                        <span class="text-xs font-bold text-gray-200 uppercase tracking-tighter">
                            Hi, {{ explode(' ', Auth::user()->name)[0] }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500/20 hover:bg-red-500 text-red-500 hover:text-white p-2 rounded-full transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </nav>

        <button id="menu-toggle" class="md:hidden p-2 text-white transition-all">
            <div id="hamburger" class="w-6 h-5 relative flex flex-col justify-between">
                <span class="w-full h-0.5 bg-white transition-all duration-300 origin-left"></span>
                <span class="w-full h-0.5 bg-white transition-all duration-300"></span>
                <span class="w-full h-0.5 bg-white transition-all duration-300 origin-left"></span>
            </div>
        </button>
    </div>

    <div id="mobile-menu" class="fixed inset-x-0 top-[73px] hidden md:hidden bg-[#050505]/95 backdrop-blur-2xl border-b border-white/5 transition-all duration-500 ease-in-out opacity-0 -translate-y-4">
        <div class="p-8 flex flex-col space-y-6">
            @foreach($navItems as $item)
            <a href="{{ $item['link'] }}" class="text-2xl font-bold text-white hover:text-indigo-500 transition-colors">
                {{ $item['name'] }}
            </a>
            @endforeach
            
            <div class="pt-8 border-t border-white/10 flex flex-col gap-4">
                @guest
                    <a href="{{ route('login') }}" class="w-full py-4 text-center text-white font-bold border border-white/10 rounded-2xl">Log in</a>
                    <a href="{{ route('register') }}" class="w-full py-4 text-center bg-indigo-600 text-white font-bold rounded-2xl">Daftar Sekarang</a>
                @else
                    <div class="flex items-center justify-between bg-white/5 p-5 rounded-2xl border border-white/10">
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase tracking-widest font-black">Logged in as</p>
                            <p class="font-bold text-white">{{ Auth::user()->name }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500/10 text-red-500 px-4 py-2 rounded-xl text-sm font-bold">Logout</button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburger = document.getElementById('hamburger');
    const spans = hamburger.querySelectorAll('span');

    menuToggle.addEventListener('click', () => {
        const isHidden = mobileMenu.classList.contains('hidden');
        
        if (isHidden) {
            // Open Menu
            mobileMenu.classList.remove('hidden');
            setTimeout(() => {
                mobileMenu.classList.remove('opacity-0', '-translate-y-4');
                mobileMenu.classList.add('opacity-100', 'translate-y-0');
            }, 10);
            
            // Animate Hamburger
            spans[0].classList.add('rotate-45', 'translate-x-1');
            spans[1].classList.add('opacity-0');
            spans[2].classList.add('-rotate-45', 'translate-x-1');
        } else {
            // Close Menu
            mobileMenu.classList.add('opacity-0', '-translate-y-4');
            mobileMenu.classList.remove('opacity-100', 'translate-y-0');
            
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 500);

            // Reset Hamburger
            spans[0].classList.remove('rotate-45', 'translate-x-1');
            spans[1].classList.remove('opacity-0');
            spans[2].classList.remove('-rotate-45', 'translate-x-1');
        }
    });

    // Perubahan Style Navbar saat Scroll
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
        if (window.scrollY > 50) {
            nav.classList.add('py-1', 'bg-black/80');
            nav.classList.remove('py-4', 'bg-black/20');
        } else {
            nav.classList.add('py-4', 'bg-black/20');
            nav.classList.remove('py-1', 'bg-black/80');
        }
    });
</script>