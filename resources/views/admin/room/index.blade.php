@extends('admin.layouts_admin.app')
@section('content')
<!-- Main Content Area -->
<div class="flex-1 flex flex-col overflow-hidden">
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

    <main class="flex-1 overflow-y-auto p-6 md:p-8">
        <!-- Room List Template -->
        <template x-if="currentMenu === 'rooms'">
            <div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8 text-center">
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
                        <div class="text-[10px] font-black text-slate-400 uppercase">សរុប</div>
                        <div class="text-2xl font-black text-slate-900" x-text="countRooms('all')"></div>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-2xl shadow-sm border border-blue-100">
                        <div class="text-[10px] font-black text-blue-400 uppercase">មានភ្ញៀវ</div>
                        <div class="text-2xl font-black text-blue-600" x-text="countRooms('occupied')"></div>
                    </div>
                    <div class="bg-emerald-50 p-4 rounded-2xl shadow-sm border border-emerald-100">
                        <div class="text-[10px] font-black text-emerald-400 uppercase">ទំនេរ</div>
                        <div class="text-2xl font-black text-emerald-600" x-text="countRooms('available')"></div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-2xl shadow-sm border border-purple-100">
                        <div class="text-[10px] font-black text-purple-400 uppercase">កក់ទុក</div>
                        <div class="text-2xl font-black text-purple-600" x-text="countRooms('booked')"></div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-2xl shadow-sm border border-orange-100">
                        <div class="text-[10px] font-black text-orange-400 uppercase">សម្អាត</div>
                        <div class="text-2xl font-black text-orange-600" x-text="countRooms('cleaning')"></div>
                    </div>
                    <div class="bg-red-50 p-4 rounded-2xl shadow-sm border border-red-100">
                        <div class="text-[10px] font-black text-red-400 uppercase">ជួសជុល</div>
                        <div class="text-2xl font-black text-red-600" x-text="countRooms('maintenance')"></div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 mb-8 bg-white p-1 rounded-2xl shadow-sm border border-slate-200 w-fit">
                    <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">ទាំងអស់</button>
                    <button @click="activeTab = 'occupied'" :class="activeTab === 'occupied' ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">មានភ្ញៀវ</button>
                    <button @click="activeTab = 'available'" :class="activeTab === 'available' ? 'bg-emerald-600 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">ទំនេរ</button>
                    <button @click="activeTab = 'booked'" :class="activeTab === 'booked' ? 'bg-purple-600 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">កក់ទុក</button>
                    <button @click="activeTab = 'cleaning'" :class="activeTab === 'cleaning' ? 'bg-orange-500 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">កំពុងសម្អាត</button>
                    <button @click="activeTab = 'maintenance'" :class="activeTab === 'maintenance' ? 'bg-red-500 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">ជួសជុល</button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <template x-for="room in filteredRooms()" :key="room.id">
                        <div class="room-card bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden relative group cursor-pointer" @click="handleStatusClick(room)">
                            <div class="absolute top-4 right-6 flex flex-col items-end gap-1">
                                <div class="text-[10px] font-black bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md uppercase" x-text="'ជាន់ទី ' + room.floor"></div>
                                <div class="text-xs font-black text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg" x-text="'$' + room.basePrice"></div>
                            </div>
                            <div class="p-8">
                                <div class="flex items-end gap-2 mb-1">
                                    <span class="text-4xl font-black text-slate-900" x-text="'#' + room.number"></span>
                                    <span class="text-[11px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider" x-text="room.type"></span>
                                </div>
                                <div class="h-6 mb-4">
                                    <template x-if="room.stayType">
                                        <span :class="room.stayType === 'ខែ' ? 'bg-indigo-100 text-indigo-600' : (room.stayType === 'ម៉ោង' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600')" class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter" x-text="'ស្នាក់នៅជា' + room.stayType"></span>
                                    </template>
                                </div>
                                <div :class="{
                                            'bg-blue-600 text-white shadow-lg shadow-blue-100': room.status === 'occupied',
                                            'bg-emerald-500 text-white shadow-lg shadow-emerald-100': room.status === 'available',
                                            'bg-purple-600 text-white shadow-lg shadow-purple-100': room.status === 'booked',
                                            'bg-orange-500 text-white shadow-lg shadow-orange-100 animate-pulse': room.status === 'cleaning',
                                            'bg-red-500 text-white shadow-lg shadow-red-100': room.status === 'maintenance'
                                        }" class="flex items-center justify-center py-3 rounded-2xl font-black text-xs mb-6 uppercase tracking-[0.1em] transition-all">
                                    <span x-text="room.status === 'occupied' ? 'មានភ្ញៀវ' : (room.status === 'available' ? 'ទំនេរ' : (room.status === 'booked' ? 'កក់ទុក' : (room.status === 'cleaning' ? 'កំពុងសម្អាត' : 'ជួសជុល')))"></span>
                                </div>
                                <div class="grid grid-cols-2 gap-4 border-t border-slate-50 pt-5">
                                    <div>
                                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-tighter mb-0.5">ថ្ងៃ/ម៉ោង ចូល</div>
                                        <div class="text-[10px] font-black text-slate-700" x-text="room.checkIn + ' ' + (room.checkInTime || '')"></div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-tighter mb-0.5">ម៉ោងលើស</div>
                                        <div :class="room.overtime !== '0' ? 'text-red-500' : 'text-slate-700'" class="text-xs font-black" x-text="room.overtime"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-900 text-white text-[10px] font-black text-center py-3 opacity-0 group-hover:opacity-100 transition-all uppercase tracking-[0.2em] transform translate-y-2 group-hover:translate-y-0">ចុចដើម្បីប្តូរស្ថានភាព</div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </main>
</div>
@endsection