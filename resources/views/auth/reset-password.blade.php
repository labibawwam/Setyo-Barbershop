<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Identity | Setyo Barbershop</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
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
                    Update<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400 font-serif italic py-2 block">
                        Identity
                    </span>
                </h1>
            </div>
            <div class="mt-14 reveal">
                <span class="px-6 py-2 bg-purple-500/10 rounded-full border border-purple-500/20 text-[10px] text-purple-300 font-bold tracking-widest backdrop-blur-md">SECURITY ENFORCED</span>
            </div>
        </div>

        <div class="md:w-[55%] w-full p-10 md:p-16 lg:p-24 flex flex-col justify-center">
            <div class="max-w-sm mx-auto w-full">
                <div class="mb-10 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-3 tracking-tight reveal">Set New Key</h2>
                    <p class="text-slate-400 text-sm font-medium reveal">Amankan kembali ritual ketampanan Anda.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    
                    <div class="reveal">
                        <label class="block text-[10px] font-bold text-blue-400 uppercase tracking-[0.25em] mb-3 ml-1">Identity Verification</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required readonly
                            class="input-cyber block w-full text-slate-400 rounded-2xl p-4 outline-none text-sm cursor-not-allowed opacity-70">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] text-red-400 font-bold uppercase" />
                    </div>

                    <div class="reveal">
                        <label class="block text-[10px] font-bold text-blue-400 uppercase tracking-[0.25em] mb-3 ml-1">New Secret Key</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <input id="password" type="password" name="password" required autofocus
                                class="input-cyber block w-full text-white rounded-2xl p-4 pl-12 outline-none placeholder:text-slate-600 text-sm"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] text-red-400 font-bold uppercase" />
                    </div>

                    <div class="reveal">
                        <label class="block text-[10px] font-bold text-blue-400 uppercase tracking-[0.25em] mb-3 ml-1">Confirm Secret Key</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="input-cyber block w-full text-white rounded-2xl p-4 pl-12 outline-none placeholder:text-slate-600 text-sm"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-[10px] text-red-400 font-bold uppercase" />
                    </div>

                    <div class="pt-4 reveal">
                        <button type="submit"
                            class="btn-cyber-gradient w-full text-white text-xs font-black uppercase tracking-[0.3em] rounded-2xl py-5 transition-all duration-500 flex items-center justify-center gap-3">
                            <span>Update Access</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
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
        });
    </script>
</body>
</html>