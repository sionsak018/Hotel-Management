<!-- resources/views/admin/modals/add-room.blade.php -->
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

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">សមត្ថភាព</label>
                    <input type="number" name="capacity" required min="1" max="10"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

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

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ការពិពណ៌នា</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
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

<script>
    function hideAddRoomModal() {
        document.getElementById('addRoomModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('addRoomModal');
        if (event.target === modal) {
            hideAddRoomModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hideAddRoomModal();
        }
    });
</script>