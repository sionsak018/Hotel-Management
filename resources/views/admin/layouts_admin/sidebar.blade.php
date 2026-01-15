        <aside class="w-full md:w-64 bg-slate-900 text-white flex-shrink-0 flex flex-col">
            <div class="p-6 text-xl font-black border-b border-slate-800 flex items-center gap-3">
                <div class="bg-blue-500 p-2 rounded-lg text-lg">🏨</div>
                <span class="tracking-tighter uppercase">Hotel Pro</span>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="p-4 space-y-2 flex-1">
                <button @click="currentMenu = 'rooms'" :class="currentMenu === 'rooms' ? 'bg-blue-600 shadow-lg shadow-blue-900/20' : 'hover:bg-slate-800 text-slate-400'" class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition-all font-bold">
                    <span>🔑</span> បន្ទប់ស្នាក់នៅ
                </button>
                <button @click="currentMenu = 'dashboard'" :class="currentMenu === 'dashboard' ? 'bg-blue-600 shadow-lg shadow-blue-900/20' : 'hover:bg-slate-800 text-slate-400'" class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition-all font-bold">
                    <span>👥</span> បញ្ជីឈ្មោះភ្ញៀវ
                </button>
            </nav>

            <!-- Sidebar Profile Section -->
            <div class="p-4 border-t border-slate-800">
                <div class="bg-slate-800/50 p-4 rounded-2xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="relative">
                            <img :src="user.avatar" class="w-10 h-10 rounded-xl object-cover border-2 border-blue-500 profile-glow">
                            <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-500 border-2 border-slate-900 rounded-full"></span>
                        </div>
                        <div class="overflow-hidden">
                            <div class="text-[11px] font-black truncate" x-text="user.name"></div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase truncate" x-text="user.role"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <button @click="showProfileMenu = true" class="bg-slate-700 hover:bg-slate-600 p-2 rounded-lg flex items-center justify-center transition-all group" title="Settings">
                            <span class="text-xs group-hover:scale-110 transition-transform">⚙️</span>
                        </button>


                        <!-- <button @click="handleLogout()" class="bg-red-500/10 hover:bg-red-500/20 text-red-400 p-2 rounded-lg flex items-center justify-center transition-all group" title="Logout"> 
                            <span class="text-xs group-hover:translate-x-0.5 transition-transform">🚪</span> 
                        </button> -->

                        <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="button"
                                id="logoutBtn"
                                class="bg-red-500/10 hover:bg-red-500/20 text-red-400 p-2 rounded-lg flex items-center justify-center transition-all group"
                                title="Logout">
                                <span class="text-xs group-hover:translate-x-0.5 transition-transform">🚪</span>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </aside>