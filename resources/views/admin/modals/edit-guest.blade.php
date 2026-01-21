<!-- resources/views/admin/modals/edit-room.blade.php -->
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

<script>
    function hideEditRoomModal() {
        document.getElementById('editRoomModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('editRoomModal');
        if (event.target === modal) {
            hideEditRoomModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hideEditRoomModal();
        }
    });
</script>