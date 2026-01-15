            <header class="bg-white border-b border-slate-200 p-4 flex justify-between items-center px-8 flex-shrink-0">
                <div class="flex items-center gap-6">
                    <div>
                        <h2 class="text-xl font-black text-slate-800" x-text="currentMenu === 'rooms' ? 'ការគ្រប់គ្រងបន្ទប់' : 'បញ្ជីឈ្មោះភ្ញៀវស្នាក់នៅ'"></h2>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest" x-text="currentTimeDisplay"></span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button @click="showAddRoomModal = true" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-black shadow-lg shadow-emerald-100 flex items-center gap-2 transition-all">
                        <span>+</span> បន្ថែមបន្ទប់
                    </button>
                    <div class="w-px h-6 bg-slate-200 hidden md:block mx-2"></div>
                    <button @click="showProfileMenu = true" class="flex items-center gap-2 p-1 pr-3 rounded-full hover:bg-slate-50 transition-all border border-transparent hover:border-slate-200">
                        <img :src="user.avatar" class="w-8 h-8 rounded-full">
                        <span class="text-[10px] font-black text-slate-600 hidden lg:block uppercase" x-text="user.name"></span>
                    </button>
                </div>
            </header>