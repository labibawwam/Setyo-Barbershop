<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#050505] font-sans text-slate-300">
        
        <x-sidebar />

        <main class="flex-1 flex flex-col justify-center items-center relative overflow-hidden px-6 lg:px-10">
            
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-600/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-600/5 blur-[100px] pointer-events-none"></div>

            <div class="w-full max-w-xl relative z-10">
                
                <div class="mb-10 text-center">
                    <h1 class="text-4xl font-black text-white tracking-tight uppercase">
                        Modify <span class="text-indigo-500 italic font-serif lowercase">identity</span>
                    </h1>
                    <div class="flex items-center justify-center gap-3 mt-3">
                        <span class="h-px w-8 bg-indigo-500/30"></span>
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-500">
                            Editing: {{ $user->name }}
                        </p>
                        <span class="h-px w-8 bg-indigo-500/30"></span>
                    </div>
                </div>

                <div class="bg-white/[0.02] border border-white/[0.05] backdrop-blur-3xl rounded-[3rem] p-8 lg:p-12 shadow-[0_25px_80px_rgba(0,0,0,0.7)]">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="group">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">
                                Full Name
                            </label>
                            <input type="text" name="name" value="{{ $user->name }}" class="w-full mt-2 bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300" required>
                        </div>

                        <div class="group">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">
                                Email Address
                            </label>
                            <input type="email" name="email" value="{{ $user->email }}" class="w-full mt-2 bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300" required>
                        </div>

                        <div class="group">
                            <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400/80 ml-1 group-focus-within:text-indigo-400 transition-colors">
                                Access Privilege
                            </label>
                            <div class="relative">
                                <select name="role" class="w-full mt-2 bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }} class="bg-[#0b0b0b]">Standard User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }} class="bg-[#0b0b0b]">Administrator</option>
                                </select>
                                <div class="absolute right-6 top-1/2 translate-y-1 mt-1 pointer-events-none text-indigo-500/50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 flex flex-col md:flex-row items-center gap-4">
                            <button type="submit" class="w-full md:flex-1 group relative bg-indigo-600 text-white py-4 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] transition-all hover:bg-indigo-500 active:scale-95 shadow-[0_10px_30px_rgba(79,70,229,0.3)] overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                    Update Identity
                                </span>
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="w-full md:w-auto px-10 py-4 border border-white/10 rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] text-slate-500 hover:text-white hover:bg-white/5 transition-all text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-10 text-center opacity-30 shrink-0">
                    <p class="text-[8px] font-bold text-slate-500 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="w-12 h-px bg-slate-700"></span>
                        Authorized Node Access Only
                        <span class="w-12 h-px bg-slate-700"></span>
                    </p>
                </div>
            </div>
        </main>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&display=swap');
        
        body, html { 
            overflow: hidden !important; 
            height: 100vh; 
            width: 100vw;
            background-color: #050505; 
        }

        .font-serif { font-family: 'Playfair Display', serif; }

        .z-10 {
            animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes luxuryEntrance {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</x-app-layout>