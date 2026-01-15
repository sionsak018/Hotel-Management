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

        @include('layouts_admin.sidebar')

        <div class="flex-1 flex flex-col">
            @include('layouts_admin.header')

            <main class="flex-1 p-6 overflow-y-auto custom-scrollbar">
                @yield('content')
            </main>
        </div>

    </div>

</body>

</html>