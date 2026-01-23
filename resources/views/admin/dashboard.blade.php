@extends('layouts.app')

@section('title', 'ផ្ទាំងគ្រប់គ្រង')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
            <div class="text-[10px] font-black text-slate-400 uppercase">សរុប</div>
            <div class="text-2xl font-black text-slate-900">{{ $totalRooms }}</div>
        </div>
        <div class="bg-blue-50 p-4 rounded-2xl shadow-sm border border-blue-100">
            <div class="text-[10px] font-black text-blue-400 uppercase">មានភ្ញៀវ</div>
            <div class="text-2xl font-black text-blue-600">{{ $occupiedRooms }}</div>
        </div>
        <div class="bg-emerald-50 p-4 rounded-2xl shadow-sm border border-emerald-100">
            <div class="text-[10px] font-black text-emerald-400 uppercase">ទំនេរ</div>
            <div class="text-2xl font-black text-emerald-600">{{ $availableRooms }}</div>
        </div>
        <div class="bg-purple-50 p-4 rounded-2xl shadow-sm border border-purple-100">
            <div class="text-[10px] font-black text-purple-400 uppercase">កក់ទុក</div>
            <div class="text-2xl font-black text-purple-600">{{ $bookedRooms }}</div>
        </div>
        <div class="bg-orange-50 p-4 rounded-2xl shadow-sm border border-orange-100">
            <div class="text-[10px] font-black text-orange-400 uppercase">សម្អាត</div>
            <div class="text-2xl font-black text-orange-600">{{ $cleaningRooms }}</div>
        </div>
        <div class="bg-red-50 p-4 rounded-2xl shadow-sm border border-red-100">
            <div class="text-[10px] font-black text-red-400 uppercase">ជួសជុល</div>
            <div class="text-2xl font-black text-red-600">{{ $maintenanceRooms }}</div>
        </div>
    </div>

    <!-- Rooms Section -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8 border-b border-slate-100">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black text-slate-800 uppercase">ការគ្រប់គ្រងបន្ទប់</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                        Room Management
                    </p>
                </div>
                <button onclick="showAddRoomModal()"
                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-black shadow-lg shadow-emerald-100 flex items-center gap-2 transition-all">
                    <span>+</span> បន្ថែមបន្ទប់
                </button>
            </div>

            <!-- Room Status Tabs -->
            <div class="flex flex-wrap gap-2 mt-6 bg-white p-1 rounded-2xl shadow-sm border border-slate-200 w-fit">
                <button onclick="filterRooms('all')" id="tab-all"
                    class="{{ !request('status') ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-50' }} px-5 py-2 rounded-xl text-xs font-bold transition-all">
                    ទាំងអស់
                </button>
                <button onclick="filterRooms('occupied')" id="tab-occupied"
                    class="{{ request('status') == 'occupied' ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-50' }} px-5 py-2 rounded-xl text-xs font-bold transition-all">
                    មានភ្ញៀវ
                </button>
                <button onclick="filterRooms('available')" id="tab-available"
                    class="{{ request('status') == 'available' ? 'bg-emerald-600 text-white' : 'text-slate-500 hover:bg-slate-50' }} px-5 py-2 rounded-xl text-xs font-bold transition-all">
                    ទំនេរ
                </button>
                <button onclick="filterRooms('booked')" id="tab-booked"
                    class="{{ request('status') == 'booked' ? 'bg-purple-600 text-white' : 'text-slate-500 hover:bg-slate-50' }} px-5 py-2 rounded-xl text-xs font-bold transition-all">
                    កក់ទុក
                </button>
                <button onclick="filterRooms('cleaning')" id="tab-cleaning"
                    class="{{ request('status') == 'cleaning' ? 'bg-orange-500 text-white' : 'text-slate-500 hover:bg-slate-50' }} px-5 py-2 rounded-xl text-xs font-bold transition-all">
                    កំពុងសម្អាត
                </button>
                <button onclick="filterRooms('maintenance')" id="tab-maintenance"
                    class="{{ request('status') == 'maintenance' ? 'bg-red-500 text-white' : 'text-slate-500 hover:bg-slate-50' }} px-5 py-2 rounded-xl text-xs font-bold transition-all">
                    ជួសជុល
                </button>
            </div>
        </div>

        <!-- Rooms Grid -->
        <div class="p-8">
            <div id="rooms-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($rooms as $room)
                <div class="room-card bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden relative cursor-pointer transition-all duration-300 hover:shadow-lg hover:-translate-y-1"
                    data-room-id="{{ $room->id }}"
                    data-room-status="{{ $room->status }}"
                    data-room-number="{{ $room->number }}"
                    data-room-type="{{ $room->type }}"
                    data-room-floor="{{ $room->floor }}"
                    data-room-price="{{ $room->base_price }}"
                    onclick="handleRoomClick(this)">

                    <div class="absolute top-4 right-6 flex flex-col items-end gap-1">
                        <div class="text-[10px] font-black bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md uppercase">
                            ជាន់ទី {{ $room->floor }}
                        </div>
                        <div class="text-xs font-black text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">
                            ${{ number_format($room->base_price, 2) }}
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="flex items-end gap-2 mb-1">
                            <span class="text-4xl font-black text-slate-900">#{{ $room->number }}</span>
                            <span class="text-[11px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">
                                {{ $room->type }}
                            </span>
                        </div>

                        <div class="h-6 mb-4">
                            @if($room->stay_type)
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter 
                          {{ $room->stay_type === 'ខែ' ? 'bg-indigo-100 text-indigo-600' : 
                             ($room->stay_type === 'ម៉ោង' ? 'bg-orange-100 text-orange-600' : 
                             ($room->stay_type === 'សប្តាហ៍' ? 'bg-yellow-100 text-yellow-600' : 
                             ($room->stay_type === 'ឆ្នាំ' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600'))) }}">
                                ស្នាក់នៅជា{{ $room->stay_type }}
                            </span>
                            @endif
                        </div>

                        <!-- Status Badge -->
                        <div class="status-badge mb-6">
                            <div class="flex items-center justify-center py-3 rounded-2xl font-black text-xs uppercase tracking-[0.1em] 
                              {{ $room->status === 'occupied' ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 
                                 ($room->status === 'available' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 
                                 ($room->status === 'booked' ? 'bg-purple-600 text-white shadow-lg shadow-purple-100' : 
                                 ($room->status === 'cleaning' ? 'bg-orange-500 text-white shadow-lg shadow-orange-100 animate-pulse' : 
                                 'bg-red-500 text-white shadow-lg shadow-red-100'))) }}">
                                {{ $room->status === 'occupied' ? 'មានភ្ញៀវ' : 
                           ($room->status === 'available' ? 'ទំនេរ' : 
                           ($room->status === 'booked' ? 'កក់ទុក' : 
                           ($room->status === 'cleaning' ? 'កំពុងសម្អាត' : 'ជួសជុល'))) }}
                            </div>
                        </div>

                        <!-- Guest Information if available -->
                        @if($room->guest_name)
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-slate-800 truncate">{{ $room->guest_name }}</div>
                                    <div class="text-xs text-slate-500">{{ $room->phone }}</div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Time Information -->
                        <div class="grid grid-cols-2 gap-4 border-t border-slate-50 pt-5">
                            <div>
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-tighter mb-0.5">
                                    ថ្ងៃ/ម៉ោង ចូល
                                </div>
                                <div class="text-[10px] font-black text-slate-700">
                                    {{ $room->check_in_date ? \Carbon\Carbon::parse($room->check_in_date)->format('d/m/Y') : '-' }}<br>
                                    {{ $room->check_in_time ? \Carbon\Carbon::parse($room->check_in_time)->format('H:i') : '' }}
                                </div>

                            </div>
                            <div class="text-right">
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-tighter mb-0.5">
                                    ម៉ោងលើស
                                </div>
                                <div class="text-xs font-black {{ $room->overtime_hours > 0 ? 'text-red-500' : 'text-slate-700' }}">
                                    {{ $room->overtime_hours > 0 ? $room->overtime_hours . ' ម៉ោង' : '0' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Click Instruction -->
                    <div class="bg-slate-900 text-white text-[10px] font-black text-center py-3 opacity-0 hover:opacity-100 transition-all uppercase tracking-[0.2em]">
                        ចុចដើម្បីប្តូរស្ថានភាព
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="hidden text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                    <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">មិនមានបន្ទប់</h3>
                <p class="text-gray-500 mb-6">គ្មានបន្ទប់ក្នុងស្ថានភាពនេះទេ</p>
                <button onclick="filterRooms('all')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium">
                    មើលបន្ទប់ទាំងអស់
                </button>
            </div>
        </div>
    </div>

    <!-- Current Guests Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8 border-b border-slate-100">
            <h3 class="text-xl font-black text-slate-800 uppercase">
                បញ្ជីឈ្មោះភ្ញៀវដែលកំពុងស្នាក់នៅ
            </h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                Currently staying or booked guests
            </p>
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
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">ថ្ងៃចេញ</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">ស្ថានភាព</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($currentGuests as $guest)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-xs">
                                    {{ $guest->number }}
                                </div>
                                <span class="text-[10px] font-black text-slate-400 uppercase">{{ $guest->type }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-sm font-black text-slate-700">{{ $guest->guest_name }}</div>
                            <div class="text-[10px] font-bold text-slate-400">{{ $guest->phone }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-sm font-black text-slate-700">${{ number_format($guest->base_price, 2) }}</div>
                            <div class="text-[9px] font-black text-blue-400 uppercase">{{ $guest->stay_type }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-black text-orange-600">${{ number_format($guest->deposit, 2) }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-xs font-bold text-slate-700"> {{ $room->check_in_date ? \Carbon\Carbon::parse($room->check_in_date)->format('d/m/Y') : '-' }}
                            </div>
                            <div class="text-[9px] font-black text-slate-400 uppercase">{{ $guest->check_in_time }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-xs font-bold text-slate-700">{{ $room->check_out_date ? \Carbon\Carbon::parse($room->check_out_date)->format('d/m/Y') : '-' }}</div>
                            <div class="text-[9px] font-black text-slate-400 uppercase">{{ $guest->check_out_time }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter 
                                  {{ $guest->status === 'occupied' ? 'bg-blue-50 text-blue-500' : 'bg-purple-50 text-purple-500' }}">
                                {{ $guest->status === 'occupied' ? 'ស្នាក់នៅ' : 'បានកក់' }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <button onclick="editGuest('{{ $guest->id }}')"
                                class="text-[10px] font-black text-blue-500 hover:text-blue-700 uppercase underline tracking-widest">
                                កែប្រែ
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.modals.add-room')
@include('admin.modals.edit-guest')
@include('admin.modals.room-status')

@endsection

@push('scripts')
<script>
    // Global variables
    let currentRoomId = null;
    let currentRoomStatus = null;
    let basePrice = 0;

    // Main function to handle room card click
    function handleRoomClick(cardElement) {
        console.log('Room card clicked');

        // Prevent multiple clicks
        if (cardElement.classList.contains('clicking')) return;
        cardElement.classList.add('clicking');

        // Get data from card attributes
        const roomId = cardElement.getAttribute('data-room-id');
        const status = cardElement.getAttribute('data-room-status');
        const roomNumber = cardElement.getAttribute('data-room-number');
        const roomType = cardElement.getAttribute('data-room-type');
        const roomFloor = cardElement.getAttribute('data-room-floor');
        const roomPrice = parseFloat(cardElement.getAttribute('data-room-price')) || 0;

        // Show the modal
        showRoomStatusModal(roomId, status, roomNumber, roomType, roomFloor, roomPrice);

        // Remove clicking class after animation
        setTimeout(() => {
            cardElement.classList.remove('clicking');
        }, 300);
    }

    // Function to show room status modal
    function showRoomStatusModal(roomId, status, roomNumber, roomType, roomFloor, roomPrice) {
        console.log('Showing modal for room:', {
            roomId,
            status,
            roomNumber,
            roomType,
            roomFloor,
            roomPrice
        });

        // Set global variables
        currentRoomId = roomId;
        currentRoomStatus = status;
        basePrice = roomPrice;

        // Get modal element
        const modal = document.getElementById('roomStatusModal');
        if (!modal) {
            console.error('Room status modal not found!');
            return;
        }

        // Show modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Set basic information
        document.getElementById('roomId').value = roomId;
        document.getElementById('currentStatus').value = status;
        document.getElementById('roomBasePrice').value = roomPrice;

        // Update display fields
        const statusSelect = document.getElementById('statusSelect');
        if (statusSelect) {
            statusSelect.value = status;
        }

        const roomNumberDisplay = document.getElementById('roomNumberDisplay');
        if (roomNumberDisplay) {
            roomNumberDisplay.textContent = roomNumber || 'N/A';
        }

        const roomTypeDisplay = document.getElementById('roomTypeDisplay');
        if (roomTypeDisplay) {
            roomTypeDisplay.textContent = roomType || 'N/A';
        }

        const roomFloorDisplay = document.getElementById('roomFloorDisplay');
        if (roomFloorDisplay) {
            roomFloorDisplay.textContent = roomFloor || 'N/A';
        }

        const basePriceDisplay = document.getElementById('basePriceDisplay');
        if (basePriceDisplay) {
            basePriceDisplay.textContent = `$${roomPrice.toFixed(2)}`;
        }

        // Load room information from API
        loadRoomInfo(roomId);

        // Toggle guest fields based on status
        toggleGuestFields();

        // Calculate initial price
        calculateTotalPrice();
    }

    // Load room information from API
    function loadRoomInfo(roomId) {
        fetch(`/admin/rooms/${roomId}/info`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Room info loaded:', data.room);
                    populateForm(data.room);
                } else {
                    console.error('Failed to load room info:', data);
                    showErrorMessage('មិនអាចទាញយកព័ត៌មានបន្ទប់បានទេ');
                }
            })
            .catch(error => {
                console.error('Error loading room info:', error);
                // Don't show error to user, just use empty form
            });
    }

    // Populate form with room data
    function populateForm(room) {
        console.log('Populating form with:', room);

        // Personal information
        setValue('guestName', room.guest_name);
        setValue('email', room.email);
        setValue('phone', room.phone);
        setValue('cartId', room.cart_id);
        setValue('numberOfGuests', room.number_of_guests || 1);
        setValue('childrenCount', room.children_count || 0);
        setValue('stayType', room.stay_type);
        setValue('gender', room.gender);
        setValue('age', room.age);
        setValue('address', room.address);
        setValue('guestType', room.guest_type);
        setValue('country', room.country);
        setValue('idType', room.id_type);

        // Stay information
        setValue('checkInDate', room.check_in_date);
        setValue('checkInTime', room.check_in_time);
        setValue('checkOutDate', room.check_out_date);
        setValue('checkOutTime', room.check_out_time);
        setValue('deposit', room.deposit || 0);
        setValue('paymentMethod', room.payment_method);
        setValue('notes', room.notes);

        // Photo preview
        if (room.photo) {
            const photoPreview = document.getElementById('photoPreview');
            const previewImage = document.getElementById('previewImage');
            if (photoPreview && previewImage) {
                photoPreview.classList.remove('hidden');
                previewImage.src = room.photo;
            }
        }

        // Check overtime
        checkOvertime(room);

        // Calculate duration
        calculateDuration();

        // Calculate prices
        calculateTotalPrice();
        calculateBalance();
    }

    // Helper function to set form values
    function setValue(elementId, value) {
        const element = document.getElementById(elementId);
        if (element && value !== null && value !== undefined) {
            element.value = value;
        }
    }

    // Toggle guest fields based on status
    function toggleGuestFields() {
        const status = document.getElementById('statusSelect')?.value;
        const guestFields = document.getElementById('guestFields');
        const noGuestInfo = document.getElementById('noGuestInfo');
        const bookedActions = document.getElementById('bookedActions');
        const occupiedActions = document.getElementById('occupiedActions');
        const cleaningActions = document.getElementById('cleaningActions');
        const additionalServices = document.getElementById('additionalServices');

        if (!status) return;

        // Hide all sections first
        if (guestFields) guestFields.classList.add('hidden');
        if (noGuestInfo) noGuestInfo.classList.add('hidden');
        if (bookedActions) bookedActions.classList.add('hidden');
        if (occupiedActions) occupiedActions.classList.add('hidden');
        if (cleaningActions) cleaningActions.classList.add('hidden');
        if (additionalServices) additionalServices.classList.add('hidden');

        // Show relevant sections based on status
        switch (status) {
            case 'occupied':
            case 'booked':
                if (guestFields) guestFields.classList.remove('hidden');
                if (additionalServices) additionalServices.classList.remove('hidden');
                if (status === 'booked' && bookedActions) bookedActions.classList.remove('hidden');
                if (status === 'occupied' && occupiedActions) occupiedActions.classList.remove('hidden');
                break;
            case 'cleaning':
                if (cleaningActions) cleaningActions.classList.remove('hidden');
                break;
            case 'available':
            case 'maintenance':
                if (noGuestInfo) noGuestInfo.classList.remove('hidden');
                break;
        }
    }

    // Calculate total price based on stay type and number of guests
    function calculateTotalPrice() {
        const stayType = document.getElementById('stayType')?.value;
        const numberOfGuests = parseInt(document.getElementById('numberOfGuests')?.value) || 1;
        const childrenCount = parseInt(document.getElementById('childrenCount')?.value) || 0;

        let priceMultiplier = 1;

        // Set multiplier based on stay type
        switch (stayType) {
            case 'ម៉ោង':
                priceMultiplier = 0.2; // 20% of daily rate
                break;
            case 'យប់':
                priceMultiplier = 1; // Full day rate
                break;
            case 'សប្តាហ៍':
                priceMultiplier = 5; // 5 days (discounted week)
                break;
            case 'ខែ':
                priceMultiplier = 20; // 20 days (discounted month)
                break;
            case 'ឆ្នាំ':
                priceMultiplier = 240; // 240 days (discounted year)
                break;
            default:
                priceMultiplier = 1;
        }

        // Calculate base room price
        let roomPrice = basePrice * priceMultiplier;

        // Add extra charges for additional guests (beyond 2)
        if (numberOfGuests > 2) {
            const extraGuests = numberOfGuests - 2;
            roomPrice += (extraGuests * 10 * priceMultiplier);
        }

        // Add charges for children (half price)
        const childrenCharge = childrenCount * 5 * priceMultiplier;

        const totalRoomPrice = roomPrice + childrenCharge;

        // Update displays
        updateDisplay('totalPriceDisplay', totalRoomPrice);
        updateDisplay('roomPriceSummary', totalRoomPrice);

        // Calculate grand total including services
        calculateGrandTotal(totalRoomPrice);
    }

    // Calculate grand total including additional services
    function calculateGrandTotal(roomPrice) {
        // Calculate additional services
        let servicesTotal = 0;
        const servicePrices = {
            'breakfast': 5,
            'laundry': 10,
            'airport_pickup': 25,
            'tour_guide': 50
        };

        document.querySelectorAll('input[name="additional_services[]"]:checked').forEach(checkbox => {
            servicesTotal += servicePrices[checkbox.value] || 0;
        });

        // Calculate tax (10%)
        const tax = (roomPrice + servicesTotal) * 0.1;
        const grandTotal = roomPrice + servicesTotal + tax;

        // Update displays
        updateDisplay('servicesPriceSummary', servicesTotal);
        updateDisplay('taxAmount', tax);
        updateDisplay('grandTotal', grandTotal);

        // Update balance
        calculateBalance(grandTotal);
    }

    // Calculate balance after deposit
    function calculateBalance(grandTotal = null) {
        if (grandTotal === null) {
            const grandTotalText = document.getElementById('grandTotal')?.textContent || '$0';
            grandTotal = parseFloat(grandTotalText.replace('$', '')) || 0;
        }

        const deposit = parseFloat(document.getElementById('deposit')?.value) || 0;
        const balance = grandTotal - deposit;

        updateDisplay('depositSummary', deposit);
        updateDisplay('balanceAmount', balance);

        // Highlight if deposit is insufficient
        const balanceElement = document.getElementById('balanceAmount');
        if (balanceElement) {
            if (balance > 0) {
                balanceElement.classList.remove('text-green-600');
                balanceElement.classList.add('text-orange-600');
            } else {
                balanceElement.classList.remove('text-orange-600');
                balanceElement.classList.add('text-green-600');
            }
        }
    }

    // Calculate stay duration
    function calculateDuration() {
        const checkInDate = document.getElementById('checkInDate')?.value;
        const checkOutDate = document.getElementById('checkOutDate')?.value;

        if (checkInDate && checkOutDate) {
            const startDate = new Date(checkInDate);
            const endDate = new Date(checkOutDate);
            const timeDiff = endDate.getTime() - startDate.getTime();
            const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

            if (dayDiff > 0) {
                const durationInfo = document.getElementById('durationInfo');
                const durationDays = document.getElementById('durationDays');
                if (durationInfo && durationDays) {
                    durationDays.textContent = dayDiff;
                    durationInfo.classList.remove('hidden');
                }
            }
        }
    }

    // Check overtime
    function checkOvertime(room) {
        if (room.overtime_hours > 0) {
            const overtimeWarning = document.getElementById('overtimeWarning');
            const overtimeMessage = document.getElementById('overtimeMessage');

            if (overtimeWarning && overtimeMessage) {
                overtimeWarning.classList.remove('hidden');
                overtimeMessage.textContent = `ភ្ញៀវនេះលើស ${room.overtime_hours} ម៉ោង។ សូមបញ្ចូលតម្លៃបន្ថែម។`;
            }
        }
    }

    // Helper function to update display with currency format
    function updateDisplay(elementId, value) {
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = `$${value.toFixed(2)}`;
        }
    }

    // Hide room status modal
    function hideRoomStatusModal() {
        const modal = document.getElementById('roomStatusModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';

            // Reset form
            const form = document.getElementById('roomStatusForm');
            if (form) form.reset();

            // Reset photo preview
            const photoPreview = document.getElementById('photoPreview');
            if (photoPreview) photoPreview.classList.add('hidden');

            // Reset global variables
            currentRoomId = null;
            currentRoomStatus = null;
            basePrice = 0;
        }
    }

    // Filter rooms by status
    function filterRooms(status) {
        console.log('Filtering rooms by status:', status);

        const roomCards = document.querySelectorAll('.room-card');
        const tabs = document.querySelectorAll('.flex.flex-wrap.gap-2.mt-6.bg-white button');
        const emptyState = document.getElementById('empty-state');
        const roomsContainer = document.getElementById('rooms-container');
        let visibleCount = 0;

        // Update active tab
        tabs.forEach(tab => {
            tab.classList.remove('bg-slate-900', 'bg-blue-600', 'bg-emerald-600', 'bg-purple-600', 'bg-orange-500', 'bg-red-500', 'text-white');
            tab.classList.add('text-slate-500', 'hover:bg-slate-50');
        });

        const activeTab = document.getElementById(`tab-${status}`);
        if (activeTab) {
            activeTab.classList.remove('text-slate-500', 'hover:bg-slate-50');

            switch (status) {
                case 'all':
                    activeTab.classList.add('bg-slate-900', 'text-white');
                    break;
                case 'occupied':
                    activeTab.classList.add('bg-blue-600', 'text-white');
                    break;
                case 'available':
                    activeTab.classList.add('bg-emerald-600', 'text-white');
                    break;
                case 'booked':
                    activeTab.classList.add('bg-purple-600', 'text-white');
                    break;
                case 'cleaning':
                    activeTab.classList.add('bg-orange-500', 'text-white');
                    break;
                case 'maintenance':
                    activeTab.classList.add('bg-red-500', 'text-white');
                    break;
            }
        }

        // Filter cards
        roomCards.forEach(card => {
            const cardStatus = card.getAttribute('data-room-status');

            if (status === 'all' || cardStatus === status) {
                card.style.display = 'block';
                visibleCount++;

                // Add animation
                card.style.opacity = '0';
                card.style.transform = 'translateY(10px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide empty state
        if (visibleCount === 0) {
            if (emptyState) emptyState.classList.remove('hidden');
            if (roomsContainer) roomsContainer.classList.add('hidden');
        } else {
            if (emptyState) emptyState.classList.add('hidden');
            if (roomsContainer) roomsContainer.classList.remove('hidden');
        }

        console.log(`Showing ${visibleCount} rooms for status: ${status}`);
    }

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing room management system');

        // Attach click events to all room cards
        document.querySelectorAll('.room-card').forEach(card => {
            card.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                handleRoomClick(this);
            });
        });

        // Also attach click to status badges
        document.querySelectorAll('.status-badge').forEach(badge => {
            badge.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const card = this.closest('.room-card');
                if (card) {
                    handleRoomClick(card);
                }
            });
        });

        // Apply initial filter based on URL
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status') || 'all';
        filterRooms(status);

        console.log(`Room management system initialized with ${document.querySelectorAll('.room-card').length} rooms`);
    });

    // Error message helper
    function showErrorMessage(message) {
        // You can implement a toast notification system here
        console.error('Error:', message);
        alert(message);
    }
</script>

<style>
    /* Room Card Styles */
    .room-card {
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        -webkit-tap-highlight-color: transparent;
    }

    .room-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .room-card.clicking {
        transform: scale(0.98);
        transition: transform 0.1s ease;
    }

    /* Status Badge */
    .status-badge {
        cursor: pointer;
        transition: opacity 0.2s ease;
    }

    .status-badge:hover>div {
        opacity: 0.9;
    }

    /* Click instruction hover effect */
    .room-card:hover .bg-slate-900 {
        opacity: 1 !important;
        transform: translateY(0);
    }

    .room-card .bg-slate-900 {
        transform: translateY(100%);
        transition: all 0.3s ease;
    }

    /* Animation for empty state */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #empty-state {
        animation: fadeIn 0.5s ease;
    }

    /* Modal scrollbar */
    #roomStatusModal .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }

    #roomStatusModal .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    #roomStatusModal .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    #roomStatusModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Form focus styles */
    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        ring: 2px;
        ring-color: rgba(59, 130, 246, 0.5);
        border-color: #3b82f6;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .room-card {
            margin: 0.5rem;
        }

        #roomStatusModal>div {
            max-height: 95vh;
            margin: 0.5rem;
        }
    }
</style>
@endpush