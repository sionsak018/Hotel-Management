<div id="addRoomModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">បន្ថែមបន្ទប់ថ្មី</h3>
                    <p class="text-sm text-gray-500 mt-1">បំពេញព័ត៌មានដើម្បីបន្ថែមបន្ទប់ថ្មី</p>
                </div>
                <button onclick="hideAddRoomModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="p-6">
            <form id="addRoomForm" action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">លេខបន្ទប់ *</label>
                        <input type="text" name="number" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="ឧទាហរណ៍: 101, 201A">
                        <p class="text-xs text-gray-500 mt-1">លេខបន្ទប់ត្រូវតែមិនសូវដូចគ្នា</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ជាន់ទី *</label>
                        <input type="text" name="floor" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                            placeholder="ឧទាហរណ៍: 1, 2, 3">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ប្រភេទបន្ទប់ *</label>
                        <select name="type" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="">ជ្រើសរើសប្រភេទបន្ទប់</option>
                            <option value="Standard">Standard</option>
                            <option value="Deluxe">Deluxe</option>
                            <option value="Suite">Suite</option>
                            <option value="VIP">VIP</option>
                            <option value="Family">Family</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">តម្លៃបន្ទប់ ($) *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" step="0.01" name="base_price" required min="0"
                                class="w-full pl-8 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                placeholder="0.00">
                        </div>
                    </div>
                </div>

                <!-- Validation Errors -->
                <div id="addRoomErrors" class="hidden mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="text-sm text-red-600 space-y-1"></div>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="p-6 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-end gap-3">
                <button type="button" onclick="hideAddRoomModal()"
                    class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                    បោះបង់
                </button>
                <button type="submit" form="addRoomForm"
                    class="px-6 py-3 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 font-medium transition-colors">
                    បន្ថែមបន្ទប់
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Show add room modal
    function showAddRoomModal() {
        console.log('Showing add room modal');
        const modal = document.getElementById('addRoomModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Reset form
            const form = document.getElementById('addRoomForm');
            if (form) form.reset();

            // Clear errors
            const errorDiv = document.getElementById('addRoomErrors');
            if (errorDiv) {
                errorDiv.classList.add('hidden');
                errorDiv.querySelector('div').innerHTML = '';
            }

            // Focus on first input
            setTimeout(() => {
                const firstInput = form.querySelector('input[name="number"]');
                if (firstInput) firstInput.focus();
            }, 100);
        } else {
            console.error('Add room modal not found!');
            showError('មិនអាចបើកទម្រង់បន្ថែមបន្ទប់បានទេ');
        }
    }

    // Hide add room modal
    function hideAddRoomModal() {
        const modal = document.getElementById('addRoomModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    // Handle form submission
    document.getElementById('addRoomForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        const errorDiv = document.getElementById('addRoomErrors');

        // Disable button and show loading
        submitButton.disabled = true;
        submitButton.textContent = 'កំពុងបន្ថែម...';

        // Hide previous errors
        if (errorDiv) {
            errorDiv.classList.add('hidden');
            errorDiv.querySelector('div').innerHTML = '';
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                // Success - show success message and reload
                showSuccess('បន្ទប់ត្រូវបានបន្ថែមដោយជោគជ័យ!');
                hideAddRoomModal();
                setTimeout(() => location.reload(), 1500);
            } else {
                // Handle validation errors
                if (response.status === 422 && data.errors) {
                    let errorHtml = '<div class="font-medium text-red-600">មានកំហុសក្នុងការបំពេញទិន្នន័យ:</div>';

                    for (const field in data.errors) {
                        errorHtml += `<div class="mt-1">• ${data.errors[field][0]}</div>`;
                    }

                    if (errorDiv) {
                        errorDiv.querySelector('div').innerHTML = errorHtml;
                        errorDiv.classList.remove('hidden');
                    }

                    // Scroll to errors
                    errorDiv?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                } else {
                    throw new Error(data.message || 'មានបញ្ហាកើតឡើង');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            showError(error.message || 'មិនអាចភ្ជាប់ទៅម៉ាស៊ីនបម្រើបានទេ');
        } finally {
            // Reset button
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        }
    });

    // Close modal when clicking outside or pressing Escape
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('addRoomModal');
        if (event.target === modal) {
            hideAddRoomModal();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('addRoomModal');
            if (modal && !modal.classList.contains('hidden')) {
                hideAddRoomModal();
            }
        }
    });
</script>