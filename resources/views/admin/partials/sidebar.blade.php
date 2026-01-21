<div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
    <div class="flex-1 flex flex-col min-h-0 bg-slate-900">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-4">
                <div class="p-2 bg-blue-500 rounded-lg text-white text-lg">🏨</div>
                <span class="ml-3 text-xl font-black text-white tracking-tighter uppercase">Hotel Pro</span>
            </div>

            <nav class="mt-5 flex-1 px-2 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800' }} group flex items-center px-4 py-3 text-sm font-bold rounded-xl">
                    🔑 បន្ទប់ស្នាក់នៅ
                </a>

                <a href="{{ route('admin.rooms') }}"
                    class="{{ request()->routeIs('admin.rooms*') ? 'bg-blue-600 shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800' }} group flex items-center px-4 py-3 text-sm font-bold rounded-xl">
                    🏨 បន្ទប់ទាំងអស់
                </a>

                <a href="{{ route('admin.guests') }}"
                    class="{{ request()->routeIs('admin.guests*') ? 'bg-blue-600 shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800' }} group flex items-center px-4 py-3 text-sm font-bold rounded-xl">
                    👥 បញ្ជីឈ្មោះភ្ញៀវ
                </a>

                <a href="{{ route('admin.bookings.index') }}"
                    class="{{ request()->routeIs('admin.bookings*') ? 'bg-blue-600 shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800' }} group flex items-center px-4 py-3 text-sm font-bold rounded-xl">
                    📅 ការកក់ទុក
                </a>

                <a href="{{ route('admin.reports.index') }}"
                    class="{{ request()->routeIs('admin.reports*') ? 'bg-blue-600 shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800' }} group flex items-center px-4 py-3 text-sm font-bold rounded-xl">
                    📊 របាយការណ៍
                </a>
            </nav>
        </div>

        <div class="flex-shrink-0 flex border-t border-slate-800 p-4">
            <div class="w-full bg-slate-800/50 p-3 rounded-2xl">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img class="w-10 h-10 rounded-xl border-2 border-blue-500 profile-glow"
                            src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=3b82f6&color=fff"
                            alt="{{ auth()->user()->name }}">
                        <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-500 border-2 border-slate-900 rounded-full"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 font-bold uppercase truncate">អ្នកគ្រប់គ្រង (Admin)</p>
                    </div>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2">
                    <a href="#"
                        class="bg-slate-700 hover:bg-slate-600 p-2 rounded-lg flex items-center justify-center transition-all group">
                        <span class="text-xs group-hover:scale-110 transition-transform">⚙️</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 p-2 rounded-lg flex items-center justify-center transition-all group">
                            <span class="text-xs group-hover:translate-x-0.5 transition-transform">🚪</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>