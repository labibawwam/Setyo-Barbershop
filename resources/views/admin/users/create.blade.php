<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col justify-center items-center relative overflow-hidden px-6 lg:px-10">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-600/5 blur-[100px] pointer-events-none"></div>
            <div class="w-full max-w-xl relative z-10 entrance-animation">
                <div class="mb-10 text-center">
                    <h1 class="text-4xl font-black text-white tracking-tight uppercase">
                        Create <span class="text-indigo-500 italic font-serif lowercase tracking-normal">new entry</span>
                    </h1>
                    <div class="flex items-center justify-center gap-3 mt-3">
                        <span class="h-[1px] w-8 bg-indigo-500/30"></span>
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-500">User Directory Management</p>
                        <span class="h-[1px] w-8 bg-indigo-500/30"></span>
                    </div>
                </div>

                <div class="bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[3rem] p-8 lg:p-12 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="group">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Full Name</label>
                            <input type="text" name="name" class="w-full mt-2 bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300" placeholder="Enter user name..." required>
                        </div>

                        <div class="group">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Email Address</label>
                            <input type="email" name="email" class="w-full mt-2 bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300" placeholder="user@company.com" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Access Privilege</label>
                                <div class="relative mt-2">
                                    <select name="role" class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all appearance-none cursor-pointer pr-12">
                                        <option value="user" class="bg-[#0b0b0b]">Standard User</option>
                                        <option value="admin" class="bg-[#0b0b0b]">Administrator</option>
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="group">
                                <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">Password</label>
                                <div class="relative mt-2">
                                    <input type="password" name="password" id="passwordInput"
                                        class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 pr-12 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300" 
                                        placeholder="••••••••" required>
                                    
                                    <button type="button" onclick="togglePasswordVisibility()" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 hover:text-indigo-400 transition-all duration-300 focus:outline-none group-focus-within:text-slate-400">
                                        <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path class="eye-open transition-all duration-300" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path class="eye-open transition-all duration-300" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <path class="eye-closed hidden transition-all duration-300" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 flex flex-col md:flex-row items-center gap-4">
                            <button type="submit" class="w-full md:flex-1 group relative bg-white text-black py-4 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] transition-all hover:bg-indigo-500 hover:text-white hover:shadow-[0_0_30px_rgba(99,102,241,0.4)] active:scale-95 overflow-hidden">
                                <span class="relative z-10">Finalize Entry</span>
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="w-full md:w-auto px-10 py-4 border border-white/10 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 hover:text-white hover:bg-white/5 transition-all text-center">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('passwordInput');
            const openPaths = document.querySelectorAll('.eye-open');
            const closedPath = document.querySelector('.eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                openPaths.forEach(p => p.classList.add('hidden'));
                closedPath.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                openPaths.forEach(p => p.classList.remove('hidden'));
                closedPath.classList.add('hidden');
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Instrument+Serif:italic&display=swap');
        .font-serif { font-family: 'Instrument Serif', serif; }
        .entrance-animation { animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes luxuryEntrance { from { opacity: 0; transform: translateY(20px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
        ::-webkit-scrollbar { width: 0px; background: transparent; }
        
        /* Dropdown styling */
        select option { background: #0b0b0b; color: white; padding: 10px; }
        select { background-image: none !important; } /* Hilangkan arrow bawaan browser */

        .glass-info { background: rgba(255, 255, 255, 0.01); backdrop-filter: blur(10px); }
    </style>
</x-app-layout>