    <!-- Modal: Profile & Settings -->
    <div x-show="showProfileMenu" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white w-full max-w-md rounded-[2.5rem] p-0 shadow-2xl relative overflow-hidden" @click.away="showProfileMenu = false">
            <div class="bg-slate-900 p-8 pb-16 relative">
                <button @click="showProfileMenu = false" class="absolute top-6 right-6 text-slate-400 hover:text-white transition-colors">✕</button>
                <div class="flex items-center gap-4">
                    <img :src="user.avatar" class="w-16 h-16 rounded-2xl border-4 border-blue-500/30">
                    <div>
                        <h3 class="text-xl font-black text-white uppercase" x-text="user.name"></h3>
                        <p class="text-xs font-bold text-blue-400 uppercase tracking-widest" x-text="user.role"></p>
                    </div>
                </div>
            </div>

            <div class="px-8 pb-8 -mt-8 relative z-10">
                <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-2 space-y-1">
                    <div class="px-4 py-3 border-b border-slate-50 mb-1">
                        <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">ចូលប្រើប្រព័ន្ធចុងក្រោយ</div>
                        <div class="text-xs font-bold text-slate-600" x-text="user.lastLogin"></div>
                    </div>

                    <button class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-50 transition-all group">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">👤</span>
                            <span class="text-xs font-black text-slate-700 uppercase tracking-tight">កែប្រែព័ត៌មានផ្ទាល់ខ្លួន</span>
                        </div>
                        <span class="text-slate-300 group-hover:translate-x-1 transition-transform">→</span>
                    </button>

                    <button class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-50 transition-all group">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">🛡️</span>
                            <span class="text-xs font-black text-slate-700 uppercase tracking-tight">សុវត្ថិភាព និងលេខសម្ងាត់</span>
                        </div>
                        <span class="text-slate-300 group-hover:translate-x-1 transition-transform">→</span>
                    </button>

                    <button class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-50 transition-all group">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">🔔</span>
                            <span class="text-xs font-black text-slate-700 uppercase tracking-tight">ការកំណត់ការជូនដំណឹង</span>
                        </div>
                        <span class="text-slate-300 group-hover:translate-x-1 transition-transform">→</span>
                    </button>

                    <div class="pt-2">
                        <button @click="handleLogout()" class="w-full flex items-center gap-3 px-4 py-4 rounded-2xl bg-red-50 text-red-500 hover:bg-red-100 transition-all">
                            <span class="text-lg">🚪</span>
                            <span class="text-xs font-black uppercase tracking-widest">ចាកចេញពីប្រព័ន្ធ</span>
                        </button>
                    </div>
                </div>

                <p class="text-center mt-6 text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em]">Hotel Pro v2.4.0 • 2024</p>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Room -->
    <div x-show="showEditRoomModal" x-cloak class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl relative">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black text-slate-800 uppercase">កែសម្រួលបន្ទប់</h3>
                <button @click="deleteRoom()" class="bg-red-50 text-red-500 p-2 rounded-xl hover:bg-red-100 transition-all flex items-center gap-1 text-[10px] font-black">🗑️ លុប</button>
            </div>
            <div class="space-y-4 text-left">
                <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">លេខបន្ទប់</label><input type="text" x-model="editRoomData.number" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl outline-none font-bold"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">ជាន់ទី</label><input type="number" x-model="editRoomData.floor" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl outline-none font-bold"></div>
                    <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">តម្លៃគោល ($)</label><input type="number" x-model="editRoomData.basePrice" class="w-full bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl outline-none font-black"></div>
                </div>
                <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">ប្រភេទបន្ទប់</label>
                    <select x-model="editRoomData.type" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl outline-none font-bold">
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Suite">Suite</option>
                        <option value="King">King</option>
                        <option value="Twin">Twin</option>
                        <option value="Appartment">Appartment</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-8">
                <button @click="showEditRoomModal = false" class="py-4 bg-slate-100 text-slate-400 rounded-xl font-black uppercase text-[10px]">បោះបង់</button>
                <button @click="updateRoom()" class="py-4 bg-blue-600 text-white rounded-xl font-black uppercase text-[10px] shadow-lg shadow-blue-100">រក្សាទុក</button>
            </div>
        </div>
    </div>

    <!-- Modal: Add New Room -->
    <div x-show="showAddRoomModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl">
            <h3 class="text-xl font-black mb-6 text-slate-800 uppercase text-center">បន្ថែមបន្ទប់ថ្មី</h3>
            <div class="space-y-4">
                <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">លេខបន្ទប់</label><input type="text" x-model="newRoom.number" placeholder="ឧទាហរណ៍៖ 401" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl outline-none font-bold"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ជាន់ទី</label><input type="number" x-model="newRoom.floor" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl outline-none font-bold"></div>
                    <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">តម្លៃ ($)</label><input type="number" x-model="newRoom.basePrice" class="w-full bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl outline-none font-black"></div>
                </div>
                <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ប្រភេទបន្ទប់</label>
                    <select x-model="newRoom.type" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl outline-none font-bold">
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Suite">Suite</option>
                        <option value="King">King</option>
                        <option value="Twin">Twin</option>
                        <option value="Appartment">Appartment</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-8">
                <button @click="showAddRoomModal = false" class="py-4 bg-slate-100 text-slate-400 rounded-xl font-black uppercase text-[10px]">បិទ</button>
                <button @click="addNewRoom()" class="py-4 bg-emerald-500 text-white rounded-xl font-black uppercase text-[10px] shadow-lg shadow-emerald-100">រក្សាទុក</button>
            </div>
        </div>
    </div>

    <!-- Modal: Maintenance / Cleaning Status -->
    <div x-show="showMaintenanceForm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center">
            <div class="mb-6">
                <div :class="getSelectedRoom().status === 'cleaning' ? 'bg-orange-100 text-orange-600' : 'bg-red-100 text-red-600'" class="w-20 h-20 rounded-full mx-auto flex items-center justify-center text-4xl mb-4">
                    <span x-text="getSelectedRoom().status === 'cleaning' ? '🧹' : '🔧'"></span>
                </div>
                <h3 class="text-xl font-black text-slate-800 uppercase" x-text="'បន្ទប់ #' + getSelectedRoom().number"></h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1" x-text="getSelectedRoom().status === 'cleaning' ? 'កំពុងសម្អាតបន្ទប់' : 'កំពុងជួសជុល'"></p>
            </div>

            <button @click="completeMaintenance()" class="w-full py-4 bg-emerald-500 text-white rounded-2xl font-black uppercase text-xs tracking-[0.2em] shadow-lg shadow-emerald-100 mb-3 flex items-center justify-center gap-2">
                <span>✅</span> សម្អាត/ជួសជុល រួចរាល់
            </button>

            <button @click="showMaintenanceForm = false" class="w-full py-4 bg-slate-100 text-slate-400 rounded-2xl font-black uppercase text-[10px] tracking-widest">បិទ</button>
        </div>
    </div>

    <!-- Booking Type Modal -->
    <div x-show="showBookingModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center">
            <div class="flex justify-between items-start mb-6 border-b border-slate-100 pb-2">
                <div>
                    <h3 class="text-xl font-black text-slate-800 uppercase text-left">បន្ទប់ #<span x-text="getSelectedRoom().number"></span></h3>
                    <p class="text-xs font-black text-emerald-500 text-left uppercase" x-text="'តម្លៃគោល៖ $' + getSelectedRoom().basePrice"></p>
                </div>
                <div class="flex gap-2">
                    <button @click="getSelectedRoom().status = 'maintenance'; showBookingModal = false; showMaintenanceForm = true;" class="bg-red-50 px-3 py-1.5 rounded-xl text-[10px] font-black text-red-500 hover:bg-red-100">🔧 ជួសជុល</button>
                    <button @click="openEditModal(getSelectedRoom())" class="bg-slate-100 px-3 py-1.5 rounded-xl text-[10px] font-black text-slate-600 hover:bg-slate-200">✏️ កែប្រែ</button>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-3 overflow-y-auto max-h-[70vh] p-1 text-left">
                <div class="text-[10px] font-black text-slate-400 uppercase ml-2 mb-1">ចូលស្នាក់នៅ (Check-in)</div>
                <div class="grid grid-cols-3 gap-2">
                    <button @click="selectStayType('ម៉ោង')" class="p-3 border-2 border-slate-50 rounded-2xl hover:border-blue-500 hover:bg-blue-50 transition-all flex flex-col items-center"><span class="text-xl mb-1">⏰</span><span class="font-black text-slate-700 uppercase text-[9px]">ម៉ោង</span></button>
                    <button @click="selectStayType('យប់')" class="p-3 border-2 border-slate-50 rounded-2xl hover:border-blue-500 hover:bg-blue-50 transition-all flex flex-col items-center"><span class="text-xl mb-1">🌙</span><span class="font-black text-slate-700 uppercase text-[9px]">យប់</span></button>
                    <button @click="selectStayType('ខែ')" class="p-3 border-2 border-slate-50 rounded-2xl hover:border-blue-500 hover:bg-blue-50 transition-all flex flex-col items-center"><span class="text-xl mb-1">📅</span><span class="font-black text-slate-700 uppercase text-[9px]">ខែ</span></button>
                </div>
                <div class="text-[10px] font-black text-slate-400 uppercase ml-2 mt-4 mb-1">កក់ទុក (Booking)</div>
                <div class="grid grid-cols-3 gap-2">
                    <button @click="selectStayType('ម៉ោង', true)" class="p-3 border-2 border-purple-50 bg-purple-50/30 rounded-2xl hover:border-purple-500 hover:bg-purple-100 transition-all flex flex-col items-center"><span class="text-xl mb-1">⌚</span><span class="font-black text-purple-700 uppercase text-[9px]">កក់ម៉ោង</span></button>
                    <button @click="selectStayType('យប់', true)" class="p-3 border-2 border-purple-50 bg-purple-50/30 rounded-2xl hover:border-purple-500 hover:bg-purple-100 transition-all flex flex-col items-center"><span class="text-xl mb-1">🛎️</span><span class="font-black text-purple-700 uppercase text-[9px]">កក់យប់</span></button>
                    <button @click="selectStayType('ខែ', true)" class="p-3 border-2 border-purple-50 bg-purple-50/30 rounded-2xl hover:border-purple-500 hover:bg-purple-100 transition-all flex flex-col items-center"><span class="text-xl mb-1">📂</span><span class="font-black text-purple-700 uppercase text-[9px]">កក់ខែ</span></button>
                </div>
                <button @click="showBookingModal = false" class="mt-6 text-slate-400 font-black text-[10px] uppercase w-full text-center">បិទ</button>
            </div>
        </div>
    </div>

    <!-- Main Booking Form -->
    <div x-show="showDetailForm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-md p-4 overflow-y-auto" x-transition>
        <div class="bg-white w-full max-w-4xl rounded-[2.5rem] p-8 shadow-2xl relative my-auto">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase" x-text="isBookingMode ? 'ព័ត៌មានកក់ទុកមុន' : 'ព័ត៌មានចូលស្នាក់នៅ'"></h3>
                    <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest" x-text="'បន្ទប់ #' + getSelectedRoom().number + ' | ' + (isBookingMode ? 'កក់ជា' : 'ស្នាក់នៅជា') + selectedStayType"></span>
                </div>
                <button @click="showDetailForm = false" class="text-slate-400 hover:text-slate-600 text-2xl font-black">✕</button>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ឈ្មោះភ្ញៀវ</label><input type="text" x-model="formData.guestName" class="w-full bg-slate-50 border border-slate-200 px-4 py-2 rounded-xl outline-none font-bold"></div>
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">លេខទូរស័ព្ទ</label><input type="text" x-model="formData.phone" class="w-full bg-slate-50 border border-slate-200 px-4 py-2 rounded-xl outline-none font-bold"></div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ថ្ងៃចូល</label><input type="date" x-model="formData.checkInDate" class="w-full bg-slate-50 border border-slate-200 px-3 py-2 rounded-xl outline-none"></div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ម៉ោងចូល</label>
                            <input type="time" x-model="formData.checkInTime" class="w-full bg-blue-50 border border-blue-200 text-blue-700 px-3 py-2 rounded-xl outline-none font-black text-lg">
                        </div>
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">តម្លៃស្នាក់នៅ ($)</label><input type="number" x-model="formData.price" class="w-full bg-blue-50 border border-blue-200 text-blue-700 px-3 py-2 rounded-xl outline-none font-black text-lg"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ប្រាក់កក់ ($)</label><input type="number" x-model="formData.deposit" class="w-full bg-white border border-slate-200 px-3 py-2 rounded-xl outline-none font-black text-orange-600 text-lg"></div>
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ថ្ងៃចេញ (ប៉ាន់ស្មាន)</label><input type="date" x-model="formData.checkOutDate" class="w-full bg-white border border-slate-200 px-3 py-2 rounded-xl outline-none"></div>
                    </div>
                </div>
                <div class="flex flex-col"><label class="block text-[10px] font-black text-slate-400 uppercase mb-3 text-center">រូបអត្តសញ្ញាណប័ណ្ណ</label>
                    <div class="flex-1 min-h-[180px] bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] flex flex-col items-center justify-center p-4 hover:border-blue-500 cursor-pointer overflow-hidden relative" @click="$refs.idFileInput.click()">
                        <input type="file" x-ref="idFileInput" class="hidden" accept="image/*" @change="handleFileUpload">
                        <template x-if="!idCardPreview">
                            <div><span class="text-4xl block mb-2">🪪</span>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">បញ្ចូលរូបភាព</p>
                            </div>
                        </template>
                        <template x-if="idCardPreview"><img :src="idCardPreview" class="absolute inset-0 w-full h-full object-cover"></template>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-8">
                <button @click="showDetailForm = false" class="py-4 bg-slate-100 text-slate-400 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-slate-200">បោះបង់</button>
                <button @click="confirmBooking()" :class="isBookingMode ? 'bg-purple-600' : 'bg-blue-600'" class="py-4 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl transition-all">
                    <span x-text="isBookingMode ? 'បញ្ជាក់ការកក់ទុក (BOOK)' : 'ចាប់ផ្តើមចូលស្នាក់នៅ (START)'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Occupied Details -->
    <div x-show="showOccupiedForm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white w-full max-md rounded-[2.5rem] p-8 shadow-2xl">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-4">
                    <div :class="getSelectedRoom().status === 'booked' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600'" class="w-16 h-16 rounded-3xl flex items-center justify-center text-3xl font-black" x-text="'#' + getSelectedRoom().number"></div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 uppercase">ព័ត៌មានភ្ញៀវ</h3>
                        <span :class="getSelectedRoom().status === 'booked' ? 'text-purple-500' : 'text-blue-500'" class="text-[10px] font-bold uppercase tracking-widest" x-text="getSelectedRoom().status === 'booked' ? 'ស្ថានភាព៖ កក់ទុក' : 'ស្ថានភាព៖ មានភ្ញៀវ'"></span>
                    </div>
                </div>
                <button @click="openEditModal(getSelectedRoom())" class="bg-slate-100 px-3 py-1.5 rounded-xl text-[10px] font-black text-slate-600 hover:bg-slate-200">✏️ កែប្រែ</button>
            </div>
            <div class="space-y-4 bg-slate-50 p-6 rounded-3xl border border-slate-100">
                <div class="flex justify-between border-b border-slate-200 pb-2"><span class="text-[10px] font-black text-slate-400 uppercase">ឈ្មោះភ្ញៀវ</span><span class="text-sm font-black text-slate-700" x-text="getSelectedRoom().guestName || '-'"></span></div>
                <div class="flex justify-between border-b border-slate-200 pb-2"><span class="text-[10px] font-black text-slate-400 uppercase">តម្លៃបន្ទប់</span><span class="text-sm font-black text-emerald-600" x-text="'$' + getSelectedRoom().basePrice"></span></div>
                <div class="flex justify-between border-b border-slate-200 pb-2"><span class="text-[10px] font-black text-slate-400 uppercase">ប្រភេទស្នាក់នៅ</span><span class="text-sm font-black text-slate-700" x-text="'ស្នាក់នៅជា' + getSelectedRoom().stayType"></span></div>
                <div class="flex justify-between border-b border-slate-200 pb-2"><span class="text-[10px] font-black text-slate-400 uppercase">ថ្ងៃ/ម៉ោង ចូល</span><span class="text-sm font-black text-slate-700" x-text="getSelectedRoom().checkIn + ' ' + (getSelectedRoom().checkInTime || '')"></span></div>
                <div class="flex justify-between"><span class="text-[10px] font-black text-slate-400 uppercase">ប្រាក់កក់</span><span class="text-sm font-black text-orange-600" x-text="'$' + getSelectedRoom().deposit"></span></div>
            </div>

            <template x-if="getSelectedRoom().status === 'booked'">
                <div class="mt-6">
                    <button @click="startCheckInFromBooking()" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black uppercase text-xs tracking-[0.2em] shadow-lg shadow-blue-100 flex items-center justify-center gap-2 hover:bg-blue-700 transition-all">
                        <span>▶️</span> ចាប់ផ្តើមចូលស្នាក់នៅ (START)
                    </button>
                </div>
            </template>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <button @click="showOccupiedForm = false" class="py-4 bg-slate-100 text-slate-400 rounded-xl font-black uppercase text-[10px]">បិទ</button>
                <button @click="getSelectedRoom().status === 'booked' ? cancelBooking() : checkOut()" class="py-4 bg-red-500 text-white rounded-xl font-black uppercase text-[10px] shadow-lg shadow-red-100" x-text="getSelectedRoom().status === 'booked' ? 'បោះបង់ការកក់' : 'CHECK OUT'"></button>
            </div>
        </div>
    </div>