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

        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .profile-glow {
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
        }
    </style>
    <script>
        function hotelApp() {
            return {
                isLoggedIn: true,
                currentMenu: 'rooms',
                activeTab: 'all',
                searchGuest: '',
                showBookingModal: false,
                showDetailForm: false,
                showMaintenanceForm: false,
                showOccupiedForm: false,
                showAddRoomModal: false,
                showEditRoomModal: false,
                showProfileMenu: false,
                selectedRoomId: null,
                selectedStayType: '',
                isBookingMode: false,
                idCardPreview: null,
                currentTimeDisplay: '',

                user: {
                    name: 'រដ្ឋា វិបុល',
                    role: 'អ្នកគ្រប់គ្រង (Admin)',
                    avatar: 'https://ui-avatars.com/api/?name=RV&background=3b82f6&color=fff',
                    lastLogin: 'ថ្ងៃនេះ ម៉ោង ០៨:៣០ ព្រឹក'
                },

                init() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                },

                updateClock() {
                    const now = new Date();
                    this.currentTimeDisplay = now.toLocaleTimeString('km-KH', {
                        hour12: true,
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                },

                handleLogout() {
                    if (confirm('តើអ្នកពិតជាចង់ចាកចេញពីប្រព័ន្ធមែនទេ?')) {
                        this.isLoggedIn = false;
                        // In a real app, redirect or clear tokens here
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                },

                newRoom: {
                    number: '',
                    type: 'Single',
                    floor: '1',
                    basePrice: '15'
                },

                editRoomData: {
                    number: '',
                    type: '',
                    floor: '',
                    basePrice: ''
                },

                formData: {
                    guestName: '',
                    phone: '',
                    price: '',
                    deposit: '0',
                    checkInDate: new Date().toISOString().split('T')[0],
                    checkInTime: new Date().toTimeString().slice(0, 5),
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
                        deposit: '0',
                        basePrice: '15'
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
                        deposit: '10',
                        basePrice: '25'
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
                        deposit: '100',
                        basePrice: '250'
                    },
                ],

                filteredRooms() {
                    if (this.activeTab === 'all') return this.rooms;
                    return this.rooms.filter(r => r.status === this.activeTab);
                },

                get currentGuests() {
                    return this.rooms.filter(r => (r.status === 'occupied' || r.status === 'booked') && r.guestName !== '').filter(g => {
                        return g.guestName.toLowerCase().includes(this.searchGuest.toLowerCase()) ||
                            g.phone.includes(this.searchGuest) ||
                            g.number.includes(this.searchGuest);
                    });
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
                        floor: room.floor,
                        basePrice: room.basePrice || '0'
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
                        room.basePrice = this.editRoomData.basePrice;
                    }
                    this.showEditRoomModal = false;
                },

                deleteRoom() {
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
                        basePrice: this.newRoom.basePrice,
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
                        floor: '1',
                        basePrice: '15'
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

                startCheckInFromBooking() {
                    const room = this.rooms.find(r => r.id === this.selectedRoomId);
                    if (room) {
                        room.status = 'occupied';
                        room.checkInTime = new Date().toTimeString().slice(0, 5);
                        room.checkIn = new Date().toISOString().split('T')[0];
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
                    const room = this.getSelectedRoom();

                    const now = new Date();
                    this.formData.checkInDate = now.toISOString().split('T')[0];
                    this.formData.checkInTime = now.toTimeString().slice(0, 5);
                    this.formData.price = room.basePrice || '0';

                    this.showBookingModal = false;
                    this.showDetailForm = true;
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
                    const now = new Date();
                    this.formData = {
                        guestName: '',
                        phone: '',
                        price: '',
                        deposit: '0',
                        checkInDate: now.toISOString().split('T')[0],
                        checkInTime: now.toTimeString().slice(0, 5),
                        checkOutDate: '',
                        checkOutTime: '12:00',
                        paymentMethod: 'cash'
                    };
                    this.idCardPreview = null;
                    this.isBookingMode = false;
                }
            }

        }
        document.addEventListener('DOMContentLoaded', () => {
            const logoutBtn = document.getElementById('logoutBtn');
            const logoutForm = document.getElementById('logoutForm');

            logoutBtn.addEventListener('click', (e) => {
                e.preventDefault();

                if (confirm('តើអ្នកចង់ចាកចេញពីប្រព័ន្ធមែនទេ?')) {
                    logoutForm.submit();
                }
            });
        });
    </script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-50 min-h-screen" x-data="hotelApp()" x-init="init()">

    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
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

                <!-- Guest List Template -->
                <template x-if="currentMenu === 'dashboard'">
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
                            <div>
                                <h3 class="text-xl font-black text-slate-800 uppercase">បញ្ជីឈ្មោះភ្ញៀវដែលកំពុងស្នាក់នៅ</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Currently staying or booked guests</p>
                            </div>
                            <div class="relative w-full md:w-80">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">🔍</span>
                                <input type="text" x-model="searchGuest" placeholder="ស្វែងរកតាមឈ្មោះ លេខទូរស័ព្ទ ឬបន្ទប់..." class="w-full bg-slate-50 border border-slate-200 pl-11 pr-4 py-3 rounded-2xl outline-none focus:border-blue-500 text-sm font-bold">
                            </div>
                        </div>

                        <div class="overflow-x-auto custom-scrollbar">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">បន្ទប់</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">ឈ្មោះភ្ញៀវ</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">តម្លៃបន្ទប់</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">ប្រាក់កក់</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">ថ្ងៃចូល</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">ស្ថានភាព</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">សកម្មភាព</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="guest in currentGuests" :key="guest.id">
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-8 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-xs" x-text="guest.number"></div>
                                                    <span class="text-[10px] font-black text-slate-400 uppercase" x-text="guest.type"></span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5">
                                                <div class="text-sm font-black text-slate-700" x-text="guest.guestName"></div>
                                                <div class="text-[10px] font-bold text-slate-400" x-text="guest.phone"></div>
                                            </td>
                                            <td class="px-8 py-5">
                                                <div class="text-sm font-black text-slate-700" x-text="'$' + guest.basePrice"></div>
                                                <div class="text-[9px] font-black text-blue-400 uppercase" x-text="guest.stayType"></div>
                                            </td>
                                            <td class="px-8 py-5">
                                                <span class="text-sm font-black text-orange-600" x-text="'$' + guest.deposit"></span>
                                            </td>
                                            <td class="px-8 py-5">
                                                <div class="text-xs font-bold text-slate-700" x-text="guest.checkIn"></div>
                                                <div class="text-[9px] font-black text-slate-400 uppercase" x-text="guest.checkInTime"></div>
                                            </td>
                                            <td class="px-8 py-5">
                                                <span :class="guest.status === 'occupied' ? 'bg-blue-50 text-blue-500' : 'bg-purple-50 text-purple-500'" class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter" x-text="guest.status === 'occupied' ? 'ស្នាក់នៅ' : 'បានកក់'"></span>
                                            </td>
                                            <td class="px-8 py-5">
                                                <button @click="handleStatusClick(guest)" class="text-[10px] font-black text-blue-500 hover:text-blue-700 uppercase underline tracking-widest">លម្អិត</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </template>
            </main>
        </div>
    </div>

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

</body>

</html>