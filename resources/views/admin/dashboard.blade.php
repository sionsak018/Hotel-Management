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
                    class="{{ !request('status') ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-50' }} px-5 py-2 rounded-xl text-xs font-bold transition-all active-tab">
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
                <div class="room-card bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden relative cursor-pointer"
                    data-room-id="{{ $room->id }}"
                    data-room-status="{{ $room->status }}"
                    onclick="handleRoomClickFromElement(this)">

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
                             ($room->stay_type === 'ម៉ោង' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600') }}">
                                ស្នាក់នៅជា{{ $room->stay_type }}
                            </span>
                            @endif
                        </div>

                        <div class="flex items-center justify-center py-3 rounded-2xl font-black text-xs mb-6 uppercase tracking-[0.1em] 
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

                        <div class="grid grid-cols-2 gap-4 border-t border-slate-50 pt-5">
                            <div>
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-tighter mb-0.5">
                                    ថ្ងៃ/ម៉ោង ចូល
                                </div>
                                <div class="text-[10px] font-black text-slate-700">
                                    {{ $room->check_in_date ?: '-' }} {{ $room->check_in_time ?: '' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-tighter mb-0.5">
                                    ម៉ោងលើស
                                </div>
                                <div class="text-xs font-black {{ $room->overtime !== '0' ? 'text-red-500' : 'text-slate-700' }}">
                                    {{ $room->overtime }}
                                </div>
                            </div>
                        </div>
                    </div>

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
                            <div class="text-xs font-bold text-slate-700">{{ $guest->check_in_date }}</div>
                            <div class="text-[9px] font-black text-slate-400 uppercase">{{ $guest->check_in_time }}</div>
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
    // Filter rooms function - JavaScript only, no page reload
    function filterRooms(status) {
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
            // Remove all hover classes first
            activeTab.classList.remove('text-slate-500', 'hover:bg-slate-50');

            // Add appropriate color based on status
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

                // Add fade-in animation
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
            emptyState.classList.remove('hidden');
            roomsContainer.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            roomsContainer.classList.remove('hidden');
        }

        // Update URL without reloading page (optional)
        const url = new URL(window.location);
        if (status === 'all') {
            url.searchParams.delete('status');
        } else {
            url.searchParams.set('status', status);
        }
        window.history.pushState({}, '', url);
    }

    // Initialize filter based on URL parameter on page load
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status') || 'all';

        // Update tabs based on URL
        const tabs = document.querySelectorAll('.flex.flex-wrap.gap-2.mt-6.bg-white button');
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

        // Apply filter
        filterRooms(status);
    });

    // Modal functions
    function showAddRoomModal() {
        document.getElementById('addRoomModal').classList.remove('hidden');
    }

    function hideAddRoomModal() {
        document.getElementById('addRoomModal').classList.add('hidden');
    }

    function handleRoomClickFromElement(element) {
        const roomId = element.dataset.roomId;
        const status = element.dataset.roomStatus;
        handleRoomClick(roomId, status);
    }

    function handleRoomClick(roomId, status) {
        document.getElementById('roomStatusModal').classList.remove('hidden');
        document.getElementById('selectedRoomId').value = roomId;
        document.getElementById('selectedRoomStatus').value = status;

        // Load room details via AJAX
        fetch(`/admin/rooms/${roomId}`)
            .then(response => response.json())
            .then(data => {
                // Update modal with room details
                // You can fill form fields here if needed
            });
    }

    function editGuest(guestId) {
        fetch(`/admin/guests/${guestId}`)
            .then(response => response.json())
            .then(data => {
                // Populate edit form
                document.getElementById('guestEditModal').classList.remove('hidden');
                // Fill form fields with data
            });
    }
</script>
<style>
    .room-card {
        transition: all 0.3s ease;
    }

    .room-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .active-tab {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush