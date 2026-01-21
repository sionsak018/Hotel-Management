<!-- resources/views/admin/modals/room-status.blade.php -->
<div id="roomStatusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold mb-6">ផ្លាស់ប្តូរស្ថានភាពបន្ទប់</h3>

        <form id="roomStatusForm">
            @csrf
            <input type="hidden" id="roomId" name="room_id">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ស្ថានភាព</label>
                    <select name="status" required
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
                        <input type="text" name="guest_name"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">លេខទូរស័ព្ទ</label>
                        <input type="text" name="phone"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ប្រាក់កក់</label>
                        <input type="number" step="0.01" name="deposit"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ប្រភេទស្នាក់នៅ</label>
                        <select name="stay_type"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">ជ្រើសរើស</option>
                            <option value="ម៉ោង">ម៉ោង</option>
                            <option value="យប់">យប់</option>
                            <option value="ខែ">ខែ</option>
                        </select>
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
                    បន្ទាន់សម័យ
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function hideRoomStatusModal() {
        document.getElementById('roomStatusModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('roomStatusModal');
        if (event.target === modal) {
            hideRoomStatusModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hideRoomStatusModal();
        }
    });

    // Form submission
    document.getElementById('roomStatusForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const roomId = document.getElementById('roomId').value;
        const url = `/admin/rooms/${roomId}/status`;

        fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('មិនអាចផ្លាស់ប្តូរស្ថានភាពបានទេ');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('មានបញ្ហាកើតឡើង');
            });
    });
</script>