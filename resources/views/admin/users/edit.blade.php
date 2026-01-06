<x-app-layout>
    <div class="flex h-screen w-screen overflow-hidden bg-[#f8fafc] font-sans text-slate-600">
        
        <x-sidebar>

        <main class="flex-1 flex flex-col items-center relative overflow-y-auto custom-scroll bg-[#f8fafc] px-6 md:px-8 lg:px-12 py-8 md:py-12 lg:py-16">
            
            <div class="absolute top-0 right-0 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-indigo-500/[0.05] blur-[80px] md:blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[200px] md:w-[400px] h-[200px] md:h-[400px] bg-purple-500/[0.03] blur-[70px] md:blur-[100px] pointer-events-none"></div>

            <div class="w-full max-w-xl relative z-10 my-auto entrance-animation">
                
                <div class="mb-8 md:mb-10 text-center">
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight uppercase">
                        Modify <span class="text-indigo-600 italic font-serif lowercase">identity</span>
                    </h1>
                    <div class="flex items-center justify-center gap-3 mt-3">
                        <span class="h-px w-6 md:w-8 bg-indigo-200"></span>
                        <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.2em] md:tracking-[0.3em] text-slate-400 truncate px-2">
                            Editing: {{ $user->name }}
                        </p>
                        <span class="h-px w-6 md:w-8 bg-indigo-200"></span>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 backdrop-blur-3xl rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-10 lg:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.04)]">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5 md:space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">
                                Full Name
                            </label>
                            <input type="text" name="name" value="{{ $user->name }}" class="w-full mt-2 bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-5 md:px-6 py-3.5 md:py-4 text-sm text-slate-900 font-semibold focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all duration-300" required>
                        </div>

                        <div class="group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">
                                Email Address
                            </label>
                            <input type="email" name="email" value="{{ $user->email }}" class="w-full mt-2 bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-5 md:px-6 py-3.5 md:py-4 text-sm text-slate-900 font-semibold focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition-all duration-300" required>
                        </div>

                        <div class="group">
                            <label class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1 group-focus-within:text-indigo-600 transition-colors">
                                Access Privilege
                            </label>
                            <div class="relative">
                                <select name="role" class="w-full mt-2 bg-[#f8fafc] border border-slate-200 rounded-xl md:rounded-2xl px-5 md:px-6 py-3.5 md:py-4 text-sm text-slate-900 font-bold focus:outline-none focus:border-indigo-500 transition-all appearance-none cursor-pointer pr-12">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }} class="bg-white">Standard User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }} class="bg-white">Administrator</option>
                                </select>
                                <div class="absolute right-5 md:right-6 top-1/2 translate-y-1 mt-1 pointer-events-none text-slate-400 group-focus-within:text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 md:pt-6 flex flex-col sm:flex-row items-center gap-4">
                            <button type="submit" class="w-full sm:flex-1 group relative bg-indigo-600 text-white py-3.5 md:py-4 rounded-xl md:rounded-2xl text-[10px] md:text-[11px] font-black uppercase tracking-[0.2em] transition-all hover:bg-indigo-700 active:scale-95 shadow-lg shadow-indigo-100">
                                Update Identity
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="w-full sm:w-auto px-10 py-3.5 md:py-4 border border-slate-200 rounded-xl md:rounded-2xl text-[10px] md:text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-slate-700 hover:bg-slate-50 transition-all text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-8 md:mt-10 text-center opacity-50">
                    <p class="text-[7px] md:text-[8px] font-bold text-slate-400 uppercase tracking-[0.5em] flex items-center justify-center gap-4">
                        <span class="hidden xs:block w-8 md:w-12 h-px bg-slate-200"></span>
                        Authorized Node Access Only
                        <span class="hidden xs:block w-8 md:w-12 h-px bg-slate-200"></span>
                    </p>
                </div>
            </div>
        </main>
        </x-sidebar>
    </div>

    <style>
        /* Modern Scrollbar Styling Soft */
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        
        body, html { 
            background-color: #f8fafc; 
            margin: 0;
            padding: 0;
        }

        .entrance-animation {
            animation: luxuryEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes luxuryEntrance {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Prevent Tap Highlight on Mobile */
        * { -webkit-tap-highlight-color: transparent; }
    </style>
</x-app-layout>