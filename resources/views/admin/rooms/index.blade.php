@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <main class="md:pl-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">បន្ទប់ទាំងអស់</h1>
                <button onclick="showAddRoomModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2">
                    <span>+</span>
                    បន្ថែមបន្ទប់ថ្មី
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">សរុបបន្ទប់</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $rooms->count() }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-xl">
                            <span class="text-2xl">🏨</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">បន្ទប់ទំនេរ</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $rooms->where('status', 'available')->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-xl">
                            <span class="text-2xl">✅</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">មានភ្ញៀវ</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $rooms->where('status', 'occupied')->count() }}</p>
                        </div>
                        <div class="p-3 bg-red-50 rounded-xl">
                            <span class="text-2xl">👥</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">បានកក់</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $rooms->where('status', 'booked')->count() }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-xl">
                            <span class="text-2xl">📅</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">កំពុងសម្អាត</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $rooms->where('status', 'cleaning')->count() }}</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-xl">
                            <span class="text-2xl">🧹</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rooms Grid -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    បន្ទប់
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ប្រភេទ
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ជាន់
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    តម្លៃ
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ស្ថានភាព
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    សកម្មភាព
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($rooms as $room)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <span class="font-bold text-blue-600">{{ $room->number }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $room->number }}
                                            </div>
                                            @if($room->guest_name)
                                            <div class="text-xs text-gray-500">
                                                👤 {{ $room->guest_name }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $room->type === 'Suite' ? 'bg-purple-100 text-purple-800' : ($room->type === 'Double' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $room->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                        ជាន់ទី {{ $room->floor }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($room->base_price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                    $statusColors = [
                                    'available' => 'bg-green-100 text-green-800',
                                    'occupied' => 'bg-red-100 text-red-800',
                                    'booked' => 'bg-yellow-100 text-yellow-800',
                                    'cleaning' => 'bg-purple-100 text-purple-800',
                                    'maintenance' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $statusTexts = [
                                    'available' => 'ទំនេរ',
                                    'occupied' => 'មានភ្ញៀវ',
                                    'booked' => 'បានកក់',
                                    'cleaning' => 'កំពុងសម្អាត',
                                    'maintenance' => 'កំពុងជួសជុល',
                                    ];
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusColors[$room->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusTexts[$room->status] ?? $room->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="showRoomStatusModal('{{ $room->id }}', '{{ $room->status }}', '{{ addslashes($room->guest_name) }}', '{{ $room->phone }}', '{{ $room->deposit }}', '{{ $room->stay_type }}')"
                                            class="text-blue-600 hover:text-blue-900">
                                            ផ្លាស់ប្តូរស្ថានភាព
                                        </button>
                                        <button onclick="showEditRoomModal('{{ $room->id }}')"
                                            class="text-green-600 hover:text-green-900">
                                            កែប្រែ
                                        </button>
                                        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('តើអ្នកពិតជាចង់លុបបន្ទប់នេះមែនទេ?')"
                                                class="text-red-600 hover:text-red-900">
                                                លុប
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Add Room Modal -->
<div id="addRoomModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold mb-6">បន្ថែមបន្ទប់ថ្មី</h3>

        <form action="{{ route('admin.rooms.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">លេខបន្ទប់</label>
                    <input type="text" name="number" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ជាន់</label>
                    <input type="number" name="floor" required min="1"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ប្រភេទបន្ទប់</label>
                    <select name="type" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">ជ្រើសរើសប្រភេទ</option>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Suite">Suite</option>
                        <option value="King">King</option>
                        <option value="Twin">Twin</option>
                        <option value="Appartment">Appartment</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">តម្លៃគណនី ($)</label>
                    <input type="number" step="0.01" name="base_price" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="hideAddRoomModal()"
                    class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
                    បោះបង់
                </button>
                <button type="submit"
                    class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700">
                    បន្ថែម
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Room Modal -->
<div id="editRoomModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold mb-6">កែប្រែបន្ទប់</h3>

        <form id="editRoomForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">លេខបន្ទប់</label>
                    <input type="text" name="number" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ជាន់</label>
                    <input type="number" name="floor" required min="1"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ប្រភេទបន្ទប់</label>
                    <select name="type" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">ជ្រើសរើសប្រភេទ</option>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Suite">Suite</option>
                        <option value="King">King</option>
                        <option value="Twin">Twin</option>
                        <option value="Appartment">Appartment</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">តម្លៃគណនី ($)</label>
                    <input type="number" step="0.01" name="base_price" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="hideEditRoomModal()"
                    class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
                    បោះបង់
                </button>
                <button type="submit"
                    class="px-6 py-3 rounded-xl bg-green-600 text-white hover:bg-green-700">
                    រក្សាទុក
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Room Status Modal -->
<div id="roomStatusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold mb-6">ផ្លាស់ប្តូរស្ថានភាពបន្ទប់</h3>

        <form id="roomStatusForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="roomId" name="room_id">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ស្ថានភាព</label>
                    <select id="statusSelect" name="status" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="available">ទំនេរ</option>
                        <option value="occupied">មានភ្ញៀវ</option>
                        <option value="booked">បានកក់</option>
                        <option value="cleaning">កំពុងសម្អាត</option>
                        <option value="maintenance">កំពុងជួសជុល</option>
                    </select>
                </div>

                <div id="guestFields" class="hidden space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ឈ្មោះភ្ញៀវ</label>
                        <input type="text" name="guest_name" id="guestName"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="បញ្ចូលឈ្មោះភ្ញៀវ">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">លេខទូរស័ព្ទ</label>
                        <input type="text" name="phone" id="guestPhone"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="បញ្ចូលលេខទូរស័ព្ទ">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ប្រភេទស្នាក់នៅ</label>
                        <select name="stay_type" id="stayType"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">ជ្រើសរើសប្រភេទ</option>
                            <option value="ម៉ោង">ម៉ោង</option>
                            <option value="យប់">យប់</option>
                            <option value="ខែ">ខែ</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ប្រាក់កក់ ($)</label>
                        <input type="number" step="0.01" name="deposit" id="deposit"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="0.00">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="hideRoomStatusModal()"
                    class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
                    បោះបង់
                </button>
                <button type="submit"
                    class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700">
                    ផ្លាស់ប្តូរ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Modal functions
    function showAddRoomModal() {
        document.getElementById('addRoomModal').classList.remove('hidden');
    }

    function hideAddRoomModal() {
        document.getElementById('addRoomModal').classList.add('hidden');
    }

    function showEditRoomModal(roomId) {
        // Load room data via AJAX
        fetch(`/admin/rooms/${roomId}/edit`)
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('editRoomForm');
                form.action = `/admin/rooms/${roomId}`;
                form.querySelector('[name="number"]').value = data.number || '';
                form.querySelector('[name="type"]').value = data.type || '';
                form.querySelector('[name="floor"]').value = data.floor || '';
                form.querySelector('[name="base_price"]').value = data.base_price || '';

                document.getElementById('editRoomModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('មិនអាចទាញយកទិន្នន័យបន្ទប់បានទេ');
            });
    }

    function hideEditRoomModal() {
        document.getElementById('editRoomModal').classList.add('hidden');
    }

    function showRoomStatusModal(roomId, currentStatus, guestName = '', phone = '', deposit = '', stayType = '') {
        const form = document.getElementById('roomStatusForm');
        form.action = `/admin/rooms/${roomId}/status`;
        document.getElementById('roomId').value = roomId;

        const statusSelect = document.getElementById('statusSelect');
        statusSelect.value = currentStatus;

        // Fill in guest information if available
        document.getElementById('guestName').value = guestName;
        document.getElementById('guestPhone').value = phone;
        document.getElementById('deposit').value = deposit;
        document.getElementById('stayType').value = stayType;

        // Show/hide guest fields
        toggleGuestFields(currentStatus);

        // Update form action based on status
        updateStatusFormAction(statusSelect);

        // Add event listener for status change
        statusSelect.addEventListener('change', function() {
            toggleGuestFields(this.value);
            updateStatusFormAction(this);
        });

        document.getElementById('roomStatusModal').classList.remove('hidden');
    }

    function hideRoomStatusModal() {
        document.getElementById('roomStatusModal').classList.add('hidden');
    }

    function toggleGuestFields(status) {
        const guestFields = document.getElementById('guestFields');
        if (status === 'occupied' || status === 'booked') {
            guestFields.classList.remove('hidden');
        } else {
            guestFields.classList.add('hidden');
        }
    }

    function updateStatusFormAction(selectElement) {
        const form = document.getElementById('roomStatusForm');
        const roomId = document.getElementById('roomId').value;
        form.action = `/admin/rooms/${roomId}/status`;
    }

    // Handle form submissions
    document.getElementById('roomStatusForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('ស្ថានភាពត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ!');
                    location.reload();
                } else {
                    alert('មានបញ្ហាក្នុងការផ្លាស់ប្តូរស្ថានភាព');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('មានបញ្ហាក្នុងការផ្លាស់ប្តូរស្ថានភាព');
            });
    });

    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        const modals = ['addRoomModal', 'editRoomModal', 'roomStatusModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal && !modal.classList.contains('hidden') &&
                event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hideAddRoomModal();
            hideEditRoomModal();
            hideRoomStatusModal();
        }
    });
</script>
@endpush