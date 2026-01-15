<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ប្រព័ន្ធគ្រប់គ្រងសណ្ឋាគារ - ជំនាន់ខ្ពស់</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kantumruy Pro', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        .room-card {
            transition: all 0.2s ease-in-out;
        }

        .room-card:hover {
            transform: translateY(-4px);
        }

        input[type="date"],
        input[type="time"] {
            min-height: 50px;
        }
    </style>
    <script>
        function hotelApp() {
            return {
                currentMenu: 'rooms',
                activeTab: 'all',
                showBookingModal: false,
                showDetailForm: false,
                showMaintenanceForm: false,
                showOccupiedForm: false,
                showAddRoomModal: false,
                showEditRoomModal: false,
                selectedRoomId: null,
                selectedStayType: '',
                isBookingMode: false,
                idCardPreview: null,

                newRoom: {
                    number: '',
                    type: 'Single',
                    floor: '1'
                },

                editRoomData: {
                    number: '',
                    type: '',
                    floor: ''
                },

                formData: {
                    guestName: '',
                    phone: '',
                    price: '',
                    deposit: '0',
                    checkInDate: new Date().toISOString().split('T')[0],
                    checkInTime: new Date().toTimeString().slice(0, 5), // បន្ថែមម៉ោងបច្ចុប្បន្ន
                    checkOutDate: '',
                    checkOutTime: '12:00',
                    paymentMethod: 'cash',
                },

                rooms: [{
                        id: 1,
                        number: '101',
                        type: 'Single',
                        floor: '1',
                        status: 'available',
                        guests: 0,
                        stayType: '',
                        checkIn: '-',
                        checkInTime: '-',
                        overtime: '0',
                        guestName: '',
                        phone: '',
                        deposit: '0'
                    },
                    {
                        id: 2,
                        number: '102',
                        type: 'Double',
                        floor: '1',
                        status: 'occupied',
                        guests: 2,
                        stayType: 'យប់',
                        checkIn: '2023-11-01',
                        checkInTime: '14:00',
                        overtime: '1h',
                        guestName: 'សៅរ់ាម៉ួ វិច្ឆិកា',
                        phone: '012 345 678',
                        deposit: '10'
                    },
                    {
                        id: 7,
                        number: '301',
                        type: 'Appartment',
                        floor: '3',
                        status: 'occupied',
                        guests: 2,
                        stayType: 'ខែ',
                        checkIn: '2023-10-15',
                        checkInTime: '09:00',
                        overtime: '0',
                        guestName: 'លី ហ៊ួរ',
                        phone: '010 111 222',
                        deposit: '100'
                    },
                ],

                filteredRooms() {
                    if (this.activeTab === 'all') return this.rooms;
                    return this.rooms.filter(r => r.status === this.activeTab);
                },

                countRooms(status) {
                    if (status === 'all') return this.rooms.length;
                    return this.rooms.filter(r => r.status === status).length;
                },

                openEditModal(room) {
                    this.selectedRoomId = room.id;
                    this.editRoomData = {
                        number: room.number,
                        type: room.type,
                        floor: room.floor
                    };
                    this.showEditRoomModal = true;
                    this.showBookingModal = false;
                    this.showOccupiedForm = false;
                    this.showMaintenanceForm = false;
                },

                updateRoom() {
                    const room = this.rooms.find(r => r.id === this.selectedRoomId);
                    if (room) {
                        room.number = this.editRoomData.number;
                        room.type = this.editRoomData.type;
                        room.floor = this.editRoomData.floor;
                    }
                    this.showEditRoomModal = false;
                },

                deleteRoom() {
                    const modal = document.createElement('div');
                    if (confirm('តើអ្នកពិតជាចង់លុបបន្ទប់លេខ ' + this.editRoomData.number + ' នេះចេញពីប្រព័ន្ធមែនទេ?')) {
                        this.rooms = this.rooms.filter(r => r.id !== this.selectedRoomId);
                        this.showEditRoomModal = false;
                    }
                },

                addNewRoom() {
                    if (this.newRoom.number === '') return;
                    const newId = this.rooms.length > 0 ? Math.max(...this.rooms.map(r => r.id)) + 1 : 1;
                    this.rooms.push({
                        id: newId,
                        number: this.newRoom.number,
                        type: this.newRoom.type,
                        floor: this.newRoom.floor,
                        status: 'available',
                        guests: 0,
                        stayType: '',
                        checkIn: '-',
                        checkInTime: '-',
                        overtime: '0',
                        guestName: '',
                        phone: '',
                        deposit: '0'
                    });
                    this.newRoom = {
                        number: '',
                        type: 'Single',
                        floor: '1'
                    };
                    this.showAddRoomModal = false;
                },

                handleStatusClick(room) {
                    this.selectedRoomId = room.id;
                    if (room.status === 'available') {
                        this.showBookingModal = true;
                    } else if (room.status === 'occupied' || room.status === 'booked') {
                        this.showOccupiedForm = true;
                    } else if (room.status === 'cleaning' || room.status === 'maintenance') {
                        this.showMaintenanceForm = true;
                    }
                },

                getSelectedRoom() {
                    return this.rooms.find(r => r.id === this.selectedRoomId) || {};
                },

                checkOut() {
                    const room = this.rooms.find(r => r.id === this.selectedRoomId);
                    if (room) {
                        room.status = 'cleaning';
                        this.resetRoomData(room);
                    }
                    this.showOccupiedForm = false;
                },

                cancelBooking() {
                    const room = this.rooms.find(r => r.id === this.selectedRoomId);
                    if (room) {
                        room.status = 'available';
                        this.resetRoomData(room);
                    }
                    this.showOccupiedForm = false;
                },

                resetRoomData(room) {
                    room.stayType = '';
                    room.guests = 0;
                    room.checkIn = '-';
                    room.checkInTime = '-';
                    room.guestName = '';
                    room.phone = '';
                    room.deposit = '0';
                    room.overtime = '0';
                },

                completeMaintenance() {
                    const room = this.rooms.find(r => r.id === this.selectedRoomId);
                    if (room) {
                        room.status = 'available';
                    }
                    this.showMaintenanceForm = false;
                },

                selectStayType(type, isBooking = false) {
                    this.selectedStayType = type;
                    this.isBookingMode = isBooking;
                    this.showBookingModal = false;
                    this.showDetailForm = true;
                    // Reset to current time on open
                    this.formData.checkInTime = new Date().toTimeString().slice(0, 5);
                },

                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.idCardPreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                confirmBooking() {
                    const room = this.rooms.find(r => r.id === this.selectedRoomId);
                    if (room) {
                        room.status = this.isBookingMode ? 'booked' : 'occupied';
                        room.stayType = this.selectedStayType;
                        room.guests = 1;
                        room.checkIn = this.formData.checkInDate;
                        room.checkInTime = this.formData.checkInTime;
                        room.guestName = this.formData.guestName;
                        room.phone = this.formData.phone;
                        room.deposit = this.formData.deposit;
                    }
                    this.showDetailForm = false;
                    this.resetForm();
                },

                resetForm() {
                    this.formData = {
                        guestName: '',
                        phone: '',
                        price: '',
                        deposit: '0',
                        checkInDate: new Date().toISOString().split('T')[0],
                        checkInTime: new Date().toTimeString().slice(0, 5),
                        checkOutDate: '',
                        checkOutTime: '12:00',
                        paymentMethod: 'cash'
                    };
                    this.idCardPreview = null;
                    this.isBookingMode = false;
                }
            }
        }
    </script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-50 min-h-screen" x-data="hotelApp()">

    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-slate-900 text-white flex-shrink-0">
            <div class="p-6 text-xl font-black border-b border-slate-800 flex items-center gap-3">
                <div class="bg-blue-500 p-2 rounded-lg text-lg">🏨</div>
                <span class="tracking-tighter uppercase">Hotel Pro</span>
            </div>
            <nav class="p-4 space-y-2">
                <button @click="currentMenu = 'rooms'" :class="currentMenu === 'rooms' ? 'bg-blue-600 shadow-lg shadow-blue-900/20' : 'hover:bg-slate-800 text-slate-400'" class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition-all font-bold">
                    <span>🔑</span> បន្ទប់ស្នាក់នៅ
                </button>
                <button @click="currentMenu = 'dashboard'" :class="currentMenu === 'dashboard' ? 'bg-blue-600 shadow-lg shadow-blue-900/20' : 'hover:bg-slate-800 text-slate-400'" class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition-all font-bold">
                    <span>📊</span> របាយការណ៍
                </button>
            </nav>
        </aside>

        <!-- Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-slate-200 p-4 flex justify-between items-center px-8 flex-shrink-0">
                <div>
                    <h2 class="text-xl font-black text-slate-800" x-text="currentMenu === 'rooms' ? 'ការគ្រប់គ្រងបន្ទប់' : 'ផ្ទាំងរបាយការណ៍'"></h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Real-time status management</p>
                </div>
                <div class="flex items-center gap-4">
                    <button @click="showAddRoomModal = true" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-black shadow-lg shadow-emerald-100 flex items-center gap-2 transition-all">
                        <span>+</span> បន្ថែមបន្ទប់
                    </button>
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-black text-slate-700 uppercase" x-text="new Date().toLocaleDateString('km-KH')"></div>
                        <div class="text-[10px] text-emerald-500 font-bold uppercase">System Online</div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 md:p-8">
                <template x-if="currentMenu === 'rooms'">
                    <div>
                        <!-- Statistics Bar -->
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
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

                        <!-- Filter Tabs -->
                        <div class="flex flex-wrap gap-2 mb-8 bg-white p-1 rounded-2xl shadow-sm border border-slate-200 w-fit">
                            <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">ទាំងអស់</button>
                            <button @click="activeTab = 'occupied'" :class="activeTab === 'occupied' ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">មានភ្ញៀវ</button>
                            <button @click="activeTab = 'available'" :class="activeTab === 'available' ? 'bg-emerald-600 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">ទំនេរ</button>
                            <button @click="activeTab = 'booked'" :class="activeTab === 'booked' ? 'bg-purple-600 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">កក់ទុក</button>
                            <button @click="activeTab = 'cleaning'" :class="activeTab === 'cleaning' ? 'bg-orange-500 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">កំពុងសម្អាត</button>
                            <button @click="activeTab = 'maintenance'" :class="activeTab === 'maintenance' ? 'bg-red-500 text-white' : 'text-slate-500 hover:bg-slate-50'" class="px-5 py-2 rounded-xl text-xs font-bold transition-all">ជួសជុល</button>
                        </div>

                        <!-- Rooms Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <template x-for="room in filteredRooms()" :key="room.id">
                                <div class="room-card bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden relative group cursor-pointer" @click="handleStatusClick(room)">
                                    <div class="absolute top-4 right-6 text-[10px] font-black bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md uppercase" x-text="'ជាន់ទី ' + room.floor"></div>
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
                                            'bg-orange-500 text-white shadow-lg shadow-orange-100': room.status === 'cleaning',
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

                <template x-if="currentMenu === 'dashboard'">
                    <div class="p-8 text-center bg-white rounded-3xl border border-slate-200 shadow-sm">
                        <span class="text-4xl block mb-4">📊</span>
                        <h3 class="font-black text-slate-800 uppercase">ផ្ទាំងរបាយការណ៍</h3>
                    </div>
                </template>
            </main>
        </div>
    </div>

    <!-- Modal: Edit/Update Room -->
    <div x-show="showEditRoomModal" x-cloak class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl relative">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black text-slate-800 uppercase">កែសម្រួលបន្ទប់</h3>
                <button @click="deleteRoom()" class="bg-red-50 text-red-500 p-2 rounded-xl hover:bg-red-100 transition-all flex items-center gap-1 text-[10px] font-black">
                    🗑️ លុបចេញ
                </button>
            </div>
            <div class="space-y-4 text-left">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">លេខបន្ទប់</label>
                    <input type="text" x-model="editRoomData.number" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl outline-none focus:border-blue-500 font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">ប្រភេទបន្ទប់</label>
                    <select x-model="editRoomData.type" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl outline-none font-bold">
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Suite">Suite</option>
                        <option value="King">King</option>
                        <option value="Twin">Twin</option>
                        <option value="Appartment">Appartment</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">ជាន់ទី</label>
                    <input type="number" x-model="editRoomData.floor" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl outline-none font-bold">
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
                <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">លេខបន្ទប់</label><input type="text" x-model="newRoom.number" placeholder="ឧទាហរណ៍៖ 401" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl outline-none focus:border-blue-500 font-bold"></div>
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
                <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ជាន់ទី</label><input type="number" x-model="newRoom.floor" class="w-full bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl outline-none font-bold"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-8">
                <button @click="showAddRoomModal = false" class="py-4 bg-slate-100 text-slate-400 rounded-xl font-black uppercase text-[10px]">បិទ</button>
                <button @click="addNewRoom()" class="py-4 bg-emerald-500 text-white rounded-xl font-black uppercase text-[10px] shadow-lg shadow-emerald-100">រក្សាទុក</button>
            </div>
        </div>
    </div>

    <!-- Booking Type Modal -->
    <div x-show="showBookingModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center">
            <div class="flex justify-between items-start mb-6 border-b border-slate-100 pb-2">
                <h3 class="text-xl font-black text-slate-800 uppercase text-left">បន្ទប់ #<span x-text="getSelectedRoom().number"></span></h3>
                <button @click="openEditModal(getSelectedRoom())" class="bg-slate-100 px-3 py-1.5 rounded-xl text-[10px] font-black text-slate-600 hover:bg-slate-200">✏️ កែប្រែ</button>
            </div>
            <div class="grid grid-cols-1 gap-3 overflow-y-auto max-h-[70vh] p-1">
                <div class="text-[10px] font-black text-slate-400 uppercase text-left ml-2 mb-1">ចូលស្នាក់នៅ (Check-in)</div>
                <div class="grid grid-cols-3 gap-2">
                    <button @click="selectStayType('ម៉ោង')" class="p-3 border-2 border-slate-50 rounded-2xl hover:border-blue-500 hover:bg-blue-50 transition-all flex flex-col items-center">
                        <span class="text-xl mb-1">⏰</span>
                        <span class="font-black text-slate-700 uppercase text-[9px]">ម៉ោង</span>
                    </button>
                    <button @click="selectStayType('យប់')" class="p-3 border-2 border-slate-50 rounded-2xl hover:border-blue-500 hover:bg-blue-50 transition-all flex flex-col items-center">
                        <span class="text-xl mb-1">🌙</span>
                        <span class="font-black text-slate-700 uppercase text-[9px]">យប់</span>
                    </button>
                    <button @click="selectStayType('ខែ')" class="p-3 border-2 border-slate-50 rounded-2xl hover:border-blue-500 hover:bg-blue-50 transition-all flex flex-col items-center">
                        <span class="text-xl mb-1">📅</span>
                        <span class="font-black text-slate-700 uppercase text-[9px]">ខែ</span>
                    </button>
                </div>

                <div class="text-[10px] font-black text-slate-400 uppercase text-left ml-2 mt-4 mb-1">កក់ទុក (Booking)</div>
                <div class="grid grid-cols-3 gap-2">
                    <button @click="selectStayType('ម៉ោង', true)" class="p-3 border-2 border-purple-50 bg-purple-50/30 rounded-2xl hover:border-purple-500 hover:bg-purple-100 transition-all flex flex-col items-center">
                        <span class="text-xl mb-1">⌚</span>
                        <span class="font-black text-purple-700 uppercase text-[9px]">កក់ម៉ោង</span>
                    </button>
                    <button @click="selectStayType('យប់', true)" class="p-3 border-2 border-purple-50 bg-purple-50/30 rounded-2xl hover:border-purple-500 hover:bg-purple-100 transition-all flex flex-col items-center">
                        <span class="text-xl mb-1">🛎️</span>
                        <span class="font-black text-purple-700 uppercase text-[9px]">កក់យប់</span>
                    </button>
                    <button @click="selectStayType('ខែ', true)" class="p-3 border-2 border-purple-50 bg-purple-50/30 rounded-2xl hover:border-purple-500 hover:bg-purple-100 transition-all flex flex-col items-center">
                        <span class="text-xl mb-1">📂</span>
                        <span class="font-black text-purple-700 uppercase text-[9px]">កក់ខែ</span>
                    </button>
                </div>
                <button @click="showBookingModal = false" class="mt-6 text-slate-400 font-black text-[10px] uppercase">បិទ</button>
            </div>
        </div>
    </div>

    <!-- Main Booking Form (ជាមួយវាលម៉ោងចូលថ្មី) -->
    <div x-show="showDetailForm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-md p-4 overflow-y-auto" x-transition>
        <div class="bg-white w-full max-w-4xl rounded-[2.5rem] p-8 shadow-2xl relative my-auto">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase" x-text="isBookingMode ? 'ព័ត៌មានកក់ទុកមុន' : 'ព័ត៌មានចូលស្នាក់នៅ'"></h3><span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest" x-text="'ប្រភេទ៖ ' + (isBookingMode ? 'កក់ជា' : 'ស្នាក់នៅជា') + selectedStayType"></span>
                </div>
                <button @click="showDetailForm = false" class="text-slate-400 hover:text-slate-600 text-2xl font-black">✕</button>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ឈ្មោះភ្ញៀវ</label><input type="text" x-model="formData.guestName" class="w-full bg-slate-50 border border-slate-200 px-4 py-2 rounded-xl outline-none focus:border-blue-500"></div>
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">លេខទូរស័ព្ទ</label><input type="text" x-model="formData.phone" class="w-full bg-slate-50 border border-slate-200 px-4 py-2 rounded-xl outline-none focus:border-blue-500"></div>
                    </div>
                    <!-- វាលកាលបរិច្ឆេទ និង ម៉ោង -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ថ្ងៃចូល</label><input type="date" x-model="formData.checkInDate" class="w-full bg-slate-50 border border-slate-200 px-3 py-2 rounded-xl outline-none focus:border-blue-500"></div>
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ម៉ោងចូល</label><input type="time" x-model="formData.checkInTime" class="w-full bg-blue-50 border border-blue-200 px-3 py-2 rounded-xl outline-none focus:border-blue-500 font-bold text-blue-700"></div>
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ប្រាក់កក់ ($)</label><input type="number" x-model="formData.deposit" class="w-full bg-slate-50 border border-slate-200 px-3 py-2 rounded-xl outline-none focus:border-blue-500 font-black text-orange-600"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ថ្ងៃចេញ (ប៉ាន់ស្មាន)</label><input type="date" x-model="formData.checkOutDate" class="w-full bg-white border border-slate-200 px-3 py-2 rounded-xl outline-none"></div>
                        <div><label class="block text-[10px] font-black text-slate-400 uppercase mb-1">ម៉ោងចេញ (ប៉ាន់ស្មាន)</label><input type="time" x-model="formData.checkOutTime" class="w-full bg-white border border-slate-200 px-3 py-2 rounded-xl outline-none"></div>
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

    <!-- Modal: Occupied/Booked Details -->
    <div x-show="showOccupiedForm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white w-full max-md rounded-[2.5rem] p-8 shadow-2xl">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-4">
                    <div :class="getSelectedRoom().status === 'booked' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600'" class="w-16 h-16 rounded-3xl flex items-center justify-center text-3xl font-black" x-text="'#' + getSelectedRoom().number"></div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 uppercase">ព័ត៌មានភ្ញៀវ</h3><span :class="getSelectedRoom().status === 'booked' ? 'text-purple-500' : 'text-blue-500'" class="text-[10px] font-bold uppercase tracking-widest" x-text="getSelectedRoom().status === 'booked' ? 'ស្ថានភាព៖ កក់ទុក' : 'ស្ថានភាព៖ មានភ្ញៀវ'"></span>
                    </div>
                </div>
                <button @click="openEditModal(getSelectedRoom())" class="bg-slate-100 px-3 py-1.5 rounded-xl text-[10px] font-black text-slate-600 hover:bg-slate-200">✏️ កែប្រែ</button>
            </div>
            <div class="space-y-4 bg-slate-50 p-6 rounded-3xl border border-slate-100">
                <div class="flex justify-between border-b border-slate-200 pb-2"><span class="text-[10px] font-black text-slate-400 uppercase">ឈ្មោះភ្ញៀវ</span><span class="text-sm font-black text-slate-700" x-text="getSelectedRoom().guestName || '-'"></span></div>
                <div class="flex justify-between border-b border-slate-200 pb-2"><span class="text-[10px] font-black text-slate-400 uppercase">លេខទូរស័ព្ទ</span><span class="text-sm font-black text-slate-700" x-text="getSelectedRoom().phone || '-'"></span></div>
                <div class="flex justify-between border-b border-slate-200 pb-2"><span class="text-[10px] font-black text-slate-400 uppercase">ប្រភេទស្នាក់នៅ</span><span class="text-sm font-black text-slate-700" x-text="'ស្នាក់នៅជា' + getSelectedRoom().stayType"></span></div>
                <div class="flex justify-between border-b border-slate-200 pb-2"><span class="text-[10px] font-black text-slate-400 uppercase">ថ្ងៃ/ម៉ោង ចូល</span><span class="text-sm font-black text-slate-700" x-text="getSelectedRoom().checkIn + ' ' + (getSelectedRoom().checkInTime || '')"></span></div>
                <div class="flex justify-between"><span class="text-[10px] font-black text-slate-400 uppercase">ប្រាក់កក់</span><span class="text-sm font-black text-orange-600" x-text="'$' + getSelectedRoom().deposit"></span></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-8">
                <button @click="showOccupiedForm = false" class="py-4 bg-slate-100 text-slate-400 rounded-xl font-black uppercase text-[10px]">បិទ</button>
                <button @click="getSelectedRoom().status === 'booked' ? cancelBooking() : checkOut()" class="py-4 bg-red-500 text-white rounded-xl font-black uppercase text-[10px] shadow-lg shadow-red-100" x-text="getSelectedRoom().status === 'booked' ? 'បោះបង់ការកក់' : 'CHECK OUT'"></button>
            </div>
        </div>
    </div>

    <!-- Modal: Maintenance/Cleaning -->
    <div x-show="showMaintenanceForm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8 shadow-2xl text-center">
            <div class="flex justify-between items-start mb-4">
                <span class="text-[10px] font-black text-slate-400 uppercase">ស្ថានភាពបន្ទប់</span>
                <button @click="openEditModal(getSelectedRoom())" class="bg-slate-100 px-3 py-1 rounded-xl text-[10px] font-black text-slate-600 hover:bg-slate-200">✏️ កែប្រែ</button>
            </div>
            <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">✨</div>
            <h3 class="text-xl font-black text-slate-800 uppercase" x-text="'បន្ទប់ #' + getSelectedRoom().number"></h3>
            <div class="grid grid-cols-2 gap-4 mt-8">
                <button @click="showMaintenanceForm = false" class="py-4 bg-slate-100 text-slate-400 rounded-xl font-black uppercase text-[10px]">បិទ</button>
                <button @click="completeMaintenance()" class="py-4 bg-orange-500 text-white rounded-xl font-black uppercase text-[10px] shadow-lg shadow-orange-100">រួចរាល់</button>
            </div>
        </div>
    </div>

</body>

</html>