<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Login | Setyo Barbershop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Instrument+Serif:italic&display=swap');
        
        :root {
            --primary-blue: #2563eb;
            --primary-purple: #7c3aed;
            --bg-deep: #020617;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-deep);
            color: #e2e8f0;
            overflow-x: hidden;
        }

        .font-serif { font-family: 'Instrument Serif', serif; }

        .glass-panel {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(40px) saturate(200%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.5);
        }

        .input-cyber {
            background: rgba(30, 41, 59, 0.3);
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .input-cyber:focus {
            background: rgba(15, 23, 42, 0.9);
            border-color: var(--primary-blue);
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.3);
        }

        .mesh-bg {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background: 
                radial-gradient(circle at 10% 10%, rgba(37, 99, 235, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(124, 58, 237, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(15, 23, 42, 1) 0%, transparent 100%);
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0px) rotate(12deg); filter: drop-shadow(0 0 10px rgba(37, 99, 235, 0.4)); }
            50% { transform: translateY(-15px) rotate(14deg); filter: drop-shadow(0 0 25px rgba(124, 58, 237, 0.6)); }
        }
        .animate-float-luxury { animation: floatLogo 5s ease-in-out infinite; }

        .reveal {
            opacity: 0;
            transform: translateY(15px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .btn-cyber-gradient {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-purple));
            box-shadow: 0 10px 25px -10px rgba(124, 58, 237, 0.5);
        }
        .btn-cyber-gradient:hover {
            box-shadow: 0 15px 35px -5px rgba(37, 99, 235, 0.6);
            transform: scale(1.02);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 relative antialiased">
    
    <div class="mesh-bg"></div>

    <div class="w-full max-w-5xl flex flex-col md:flex-row overflow-hidden rounded-[3rem] glass-panel relative">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-blue-500 to-purple-500 opacity-50"></div>

        <div class="md:w-[45%] flex flex-col justify-center items-center text-center p-12 relative overflow-hidden bg-black/40 border-b md:border-b-0 md:border-r border-white/5">
            <div class="absolute top-[-50px] left-[-50px] w-64 h-64 bg-blue-600/10 blur-[80px] rounded-full"></div>
            
            <div class="relative z-10">
                <div class="w-28 h-28 md:w-36 md:h-36 bg-black/50 rounded-[2.8rem] flex items-center justify-center shadow-2xl mb-12 mx-auto border border-blue-500/30 overflow-hidden animate-float-luxury p-1">
                    <img src="{{ asset('gambar/setyo1.jpg') }}" 
                         alt="Logo Setyo Barbershop" 
                         class="-rotate-12 w-full h-full object-cover rounded-[2.3rem]">
                </div>
                
                <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tighter leading-none reveal">
                    Setyo<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 font-serif italic py-2 block">
                        Barbershop
                    </span>
                </h1>
                <div class="flex items-center justify-center gap-3 mt-6 reveal">
                    <span class="h-[1px] w-6 bg-blue-500/50"></span>
                    <p class="text-blue-400 text-[10px] font-black tracking-[0.5em] uppercase">Private Studio</p>
                    <span class="h-[1px] w-6 bg-blue-500/50"></span>
                </div>
            </div>
            <div class="mt-14 reveal">
                <span class="px-6 py-2 bg-blue-500/10 rounded-full border border-blue-500/20 text-[10px] text-blue-300 font-bold tracking-widest backdrop-blur-md">EST. 2017</span>
            </div>
        </div>

        <div class="md:w-[55%] w-full p-10 md:p-16 lg:p-24 flex flex-col justify-center">
            <div class="max-w-sm mx-auto w-full">
                <div class="mb-12 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-3 tracking-tight reveal">Login Access</h2>
                    <p class="text-slate-400 text-sm font-medium reveal">Otentikasi ritual ketampanan Anda.</p>
                </div>

                <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf

                    <div class="reveal">
                        <label class="block text-[10px] font-bold text-blue-400 uppercase tracking-[0.25em] mb-3 ml-1">Identification</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <input id="email" type="email" name="email" required autofocus
                                class="input-cyber block w-full text-white rounded-2xl p-4 pl-12 outline-none placeholder:text-slate-600 text-sm"
                                placeholder="Email Address">
                        </div>
                    </div>

                    <div class="reveal">
                        <div class="flex justify-between items-center mb-3 ml-1">
                            <label class="block text-[10px] font-bold text-blue-400 uppercase tracking-[0.25em]">Secret Key</label>
                            <a href="#" class="text-[10px] text-purple-400 font-bold hover:text-blue-400 transition-colors">Forgot?</a>
                        </div>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <input id="password" type="password" name="password" required
                                class="input-cyber block w-full text-white rounded-2xl p-4 pl-12 pr-12 outline-none placeholder:text-slate-600 text-sm"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-blue-400 transition-all focus:outline-none">
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path id="eye-open" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="eye-open-body" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path id="eye-closed" class="hidden" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-6 reveal">
                        <button type="submit"
                            class="btn-cyber-gradient w-full text-white text-xs font-black uppercase tracking-[0.3em] rounded-2xl py-5 transition-all duration-500 flex items-center justify-center gap-3">
                            <span>Get Access</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>

                    <p class="text-center text-slate-500 text-[10px] font-bold uppercase tracking-widest reveal">
                        No Membership? 
                        <a href="{{ route('register') }}" class="text-blue-400 hover:text-white transition-all ml-1 border-b border-blue-500/30">Register Now</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.reveal');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.classList.add('active');
                }, 100 * index);
            });

            // LOGIKA INGAT EMAIL (REMEMBER EMAIL)
            const emailInput = document.getElementById('email');
            const loginForm = document.getElementById('login-form');

            // 1. Cek apakah ada email yang tersimpan di browser
            const savedEmail = localStorage.getItem('remembered_email');
            if (savedEmail) {
                emailInput.value = savedEmail;
                // Pindahkan fokus ke password jika email sudah terisi
                document.getElementById('password').focus();
            }

            // 2. Simpan email saat tombol submit diklik
            loginForm.addEventListener('submit', () => {
                localStorage.setItem('remembered_email', emailInput.value);
            });
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeOpenBody = document.getElementById('eye-open-body');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeOpenBody.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeOpenBody.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</body>
</html>