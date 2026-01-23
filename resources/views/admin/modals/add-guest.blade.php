<!-- Add Guest Modal -->
<div id="addGuestModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0"
        id="modalContent">
        <!-- Modal Header -->
        <div class="px-8 pt-8 pb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">បន្ថែមភ្ញៀវថ្មី</h3>
                        <p class="text-sm text-gray-500 mt-1">បំពេញព័ត៌មានភ្ញៀវដើម្បីបន្ថែមទៅក្នុងប្រព័ន្ធ</p>
                    </div>
                </div>
                <button onclick="hideAddGuestModal()"
                    class="p-2 hover:bg-gray-100 rounded-xl transition-colors group">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Progress Steps (Optional) -->
        <div class="px-8 pb-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div id="formProgress" class="h-full bg-blue-600 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>
                <span id="stepCounter" class="text-sm font-medium text-gray-500 ml-3">ជំហាន 1/3</span>
            </div>
        </div>

        <form action="{{ route('admin.guests.store') }}" method="POST" id="addGuestForm" class="space-y-0">
            @csrf

            <!-- Form Steps Container -->
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-300" id="formSteps">
                    <!-- Step 1: Basic Info -->
                    <div class="w-full flex-shrink-0 px-8 pb-8" data-step="1">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2 flex items-center gap-1">
                                    <span>ឈ្មោះពេញ</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="name" required
                                        class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200"
                                        placeholder="បញ្ចូលឈ្មោះភ្ញៀវ"
                                        id="guestName"
                                        autocomplete="off">
                                </div>
                                <p class="text-xs text-red-500 hidden mt-2 px-1" id="nameError">
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    សូមបញ្ចូលឈ្មោះភ្ញៀវ
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-800 mb-2">លេខទូរស័ព្ទ</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                        <input type="tel" name="phone" required
                                            class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200"
                                            placeholder="012 345 678"
                                            id="guestPhone"
                                            autocomplete="off">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2 px-1">ទំរង់៖ 012 345 678 ឬ +85512345678</p>
                                    <p class="text-xs text-red-500 hidden mt-2 px-1" id="phoneError">
                                        <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span id="phoneErrorMessage">លេខទូរស័ព្ទមិនត្រឹមត្រូវ</span>
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-800 mb-2">អ៊ីមែល</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="email" name="email"
                                            class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200"
                                            placeholder="អ៊ីមែល"
                                            id="guestEmail"
                                            autocomplete="off">
                                    </div>
                                    <p class="text-xs text-red-500 hidden mt-2 px-1" id="emailError">
                                        <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        អ៊ីមែលមិនត្រឹមត្រូវ
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Additional Info -->
                    <div class="w-full flex-shrink-0 px-8 pb-8" data-step="2">
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-800 mb-2">លេខអត្តសញ្ញាណ</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                            </svg>
                                        </div>
                                        <input type="text" name="id_number"
                                            class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200"
                                            placeholder="លេខអត្តសញ្ញាណប័ណ្ណ"
                                            autocomplete="off">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-800 mb-2">ប្រភេទភ្ញៀវ</label>
                                    <div class="relative">
                                        <select name="type"
                                            class="w-full px-4 py-3.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200 appearance-none bg-white">
                                            <option value="ជនជាតិ">ជនជាតិ</option>
                                            <option value="ជនបរទេស">ជនបរទេស</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">អាស័យដ្ឋាន</label>
                                <textarea name="address" rows="2"
                                    class="w-full px-4 py-3.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200 resize-none"
                                    placeholder="អាស័យដ្ឋានពេញលេញ"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">ក្រុមហ៊ុន/ស្ថាប័ន</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <input type="text" name="company"
                                        class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200"
                                        placeholder="ក្រុមហ៊ុន ឬ ស្ថាប័ន"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Status & Notes -->
                    <div class="w-full flex-shrink-0 px-8 pb-8" data-step="3">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-4">ស្ថានភាពភ្ញៀវ</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="status" value="active" class="sr-only peer" checked>
                                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200 hover:border-blue-300">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">សកម្ម</div>
                                                    <div class="text-xs text-gray-500">ភ្ញៀវអាចទទួលបានសេវាកម្ម</div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="status" value="inactive" class="sr-only peer">
                                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-gray-400 peer-checked:bg-gray-50 transition-all duration-200 hover:border-gray-300">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">អសកម្ម</div>
                                                    <div class="text-xs text-gray-500">បញ្ឈប់សេវាកម្មបណ្តោះអាសន្ន</div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">កំណត់ចំណាំពិសេស</label>
                                <textarea name="notes" rows="3"
                                    class="w-full px-4 py-3.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200 resize-none"
                                    placeholder="ចំណាំពិសេសសម្រាប់ភ្ញៀវនេះ..."></textarea>
                                <p class="text-xs text-gray-500 mt-2">អាចទុកទទេបាន</p>
                            </div>

                            <!-- Preview Card -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg" id="previewInitial">?</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900" id="previewName">ឈ្មោះភ្ញៀវ</div>
                                        <div class="text-sm text-gray-600 flex items-center gap-2 mt-1">
                                            <span id="previewPhone">លេខទូរស័ព្ទ</span>
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full" id="previewType">ជនជាតិ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-8 pt-6 pb-8 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                <div class="flex items-center justify-between">
                    <button type="button" onclick="prevStep()" id="prevBtn"
                        class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-white hover:border-gray-400 transition-all duration-200 flex items-center gap-2 opacity-0 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        ថយក្រោយ
                    </button>

                    <div class="flex items-center gap-3">
                        <button type="button" onclick="hideAddGuestModal()"
                            class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-white transition-all duration-200">
                            បោះបង់
                        </button>
                        <button type="button" onclick="nextStep()" id="nextBtn"
                            class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-sm hover:shadow">
                            បន្ត
                            <svg class="w-4 h-4 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <button type="submit" id="submitBtn"
                            class="hidden px-6 py-2.5 rounded-xl bg-gradient-to-r from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-sm hover:shadow">
                            បន្ថែមភ្ញៀវ
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    input:focus,
    textarea:focus,
    select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Add Guest Modal with Multi-step Form
    document.addEventListener('DOMContentLoaded', function() {
        const addGuestModal = document.getElementById('addGuestModal');
        const modalContent = document.getElementById('modalContent');
        const formSteps = document.getElementById('formSteps');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        const formProgress = document.getElementById('formProgress');
        const stepCounter = document.getElementById('stepCounter');

        let currentStep = 1;
        const totalSteps = 3;

        // Initialize modal animation
        function showModal() {
            addGuestModal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);

            // Focus on first input
            document.getElementById('guestName').focus();
            updateStep();
        }

        function hideModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                addGuestModal.classList.add('hidden');
                resetForm();
            }, 200);
        }

        // Step Navigation
        function updateStep() {
            // Update progress bar
            const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
            formProgress.style.width = `${progress}%`;

            // Update step counter
            stepCounter.textContent = `ជំហាន ${currentStep}/${totalSteps}`;

            // Move form steps
            formSteps.style.transform = `translateX(-${(currentStep - 1) * 100}%)`;

            // Update buttons
            if (currentStep === 1) {
                prevBtn.classList.add('opacity-0', 'pointer-events-none');
            } else {
                prevBtn.classList.remove('opacity-0', 'pointer-events-none');
            }

            if (currentStep === totalSteps) {
                nextBtn.classList.add('hidden');
                submitBtn.classList.remove('hidden');
                updatePreview();
            } else {
                nextBtn.classList.remove('hidden');
                submitBtn.classList.add('hidden');
            }
        }

        function nextStep() {
            if (validateCurrentStep()) {
                currentStep = Math.min(currentStep + 1, totalSteps);
                updateStep();
            }
        }

        function prevStep() {
            currentStep = Math.max(currentStep - 1, 1);
            updateStep();
        }

        // Step Validation
        function validateCurrentStep() {
            let isValid = true;

            if (currentStep === 1) {
                const name = document.getElementById('guestName').value.trim();
                const phone = document.getElementById('guestPhone').value.trim();
                const email = document.getElementById('guestEmail').value.trim();

                // Validate name
                if (!name) {
                    showError('nameError', 'សូមបញ្ចូលឈ្មោះភ្ញៀវ');
                    isValid = false;
                } else {
                    hideError('nameError');
                }

                // Validate phone
                if (!phone) {
                    showError('phoneError', 'សូមបញ្ចូលលេខទូរស័ព្ទ');
                    document.getElementById('phoneErrorMessage').textContent = 'សូមបញ្ចូលលេខទូរស័ព្ទ';
                    isValid = false;
                } else if (!validatePhone(phone)) {
                    showError('phoneError', 'លេខទូរស័ព្ទមិនត្រឹមត្រូវ');
                    document.getElementById('phoneErrorMessage').textContent = 'លេខទូរស័ព្ទមិនត្រឹមត្រូវ';
                    isValid = false;
                } else {
                    hideError('phoneError');
                }

                // Validate email (optional)
                if (email && !validateEmail(email)) {
                    showError('emailError', 'អ៊ីមែលមិនត្រឹមត្រូវ');
                    isValid = false;
                } else {
                    hideError('emailError');
                }
            }

            return isValid;
        }

        // Phone number formatting and validation
        const guestPhone = document.getElementById('guestPhone');
        guestPhone.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            // Auto-add country code for Cambodian numbers
            if (value.startsWith('0') && value.length <= 9) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})/, '$1 $2 $3');
            } else if ((value.startsWith('855') || value.startsWith('855')) && value.length >= 12) {
                value = '+855 ' + value.substring(3).replace(/(\d{3})(\d{3})(\d{3})/, '$1 $2 $3');
            }

            e.target.value = value;
        });

        function validatePhone(phone) {
            const cleaned = phone.replace(/\s+/g, '');
            const patterns = [
                /^0[1-9][0-9]{7,8}$/,
                /^\+855[1-9][0-9]{7,8}$/,
                /^855[1-9][0-9]{7,8}$/
            ];
            return patterns.some(pattern => pattern.test(cleaned));
        }

        function validateEmail(email) {
            if (!email) return true;
            const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return pattern.test(email);
        }

        // Error handling
        function showError(elementId, message) {
            const errorEl = document.getElementById(elementId);
            errorEl.textContent = message;
            errorEl.classList.remove('hidden');

            // Add error styling to input
            const inputId = elementId.replace('Error', '');
            const input = document.getElementById(inputId);
            if (input) {
                input.classList.remove('border-gray-300', 'focus:border-blue-500');
                input.classList.add('border-red-500', 'focus:border-red-500');
                input.focus();
            }
        }

        function hideError(elementId) {
            const errorEl = document.getElementById(elementId);
            errorEl.classList.add('hidden');

            const inputId = elementId.replace('Error', '');
            const input = document.getElementById(inputId);
            if (input) {
                input.classList.remove('border-red-500', 'focus:border-red-500');
                input.classList.add('border-gray-300', 'focus:border-blue-500');
            }
        }

        // Update preview card
        function updatePreview() {
            const name = document.getElementById('guestName').value.trim();
            const phone = document.getElementById('guestPhone').value.trim();
            const type = document.querySelector('select[name="type"]').value;

            document.getElementById('previewName').textContent = name || 'ឈ្មោះភ្ញៀវ';
            document.getElementById('previewPhone').textContent = phone || 'លេខទូរស័ព្ទ';
            document.getElementById('previewType').textContent = type;

            if (name) {
                document.getElementById('previewInitial').textContent = name.charAt(0).toUpperCase();
            }
        }

        // Real-time preview updates
        document.getElementById('guestName').addEventListener('input', updatePreview);
        document.getElementById('guestPhone').addEventListener('input', updatePreview);
        document.querySelector('select[name="type"]').addEventListener('change', updatePreview);

        // Form submission
        const addGuestForm = document.getElementById('addGuestForm');
        addGuestForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!validateCurrentStep()) return;

            // Check for duplicate phone
            const phone = guestPhone.value.trim();
            const isDuplicate = await checkDuplicatePhone(phone);

            if (isDuplicate) {
                showError('phoneError', 'លេខទូរស័ព្ទនេះមានរួចហើយ');
                document.getElementById('phoneErrorMessage').textContent = 'លេខទូរស័ព្ទនេះមានរួចហើយ';
                currentStep = 1;
                updateStep();
                return;
            }

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    <svg class="animate-spin w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    កំពុងបន្ថែម...
                </span>
            `;

            // Submit form
            this.submit();
        });

        // Check duplicate phone
        async function checkDuplicatePhone(phone) {
            try {
                const response = await fetch('{{ route("admin.guests") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        phone
                    })
                });

                const data = await response.json();
                return data.exists || false;
            } catch (error) {
                console.error('Error checking duplicate phone:', error);
                return false;
            }
        }

        // Reset form
        function resetForm() {
            addGuestForm.reset();
            currentStep = 1;
            updateStep();

            // Clear errors
            hideError('nameError');
            hideError('phoneError');
            hideError('emailError');

            // Reset preview
            document.getElementById('previewName').textContent = 'ឈ្មោះភ្ញៀវ';
            document.getElementById('previewPhone').textContent = 'លេខទូរស័ព្ទ';
            document.getElementById('previewType').textContent = 'ជនជាតិ';
            document.getElementById('previewInitial').textContent = '?';

            // Reset submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'បន្ថែមភ្ញៀវ';
        }

        // Global functions
        window.showAddGuestModal = showModal;
        window.hideAddGuestModal = hideModal;
        window.nextStep = nextStep;
        window.prevStep = prevStep;

        // Keyboard shortcuts
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !addGuestModal.classList.contains('hidden')) {
                hideModal();
            }

            if (event.key === 'Enter' && event.ctrlKey && currentStep < totalSteps) {
                event.preventDefault();
                nextStep();
            }

            if (event.key === 'Enter' && event.ctrlKey && event.shiftKey && currentStep > 1) {
                event.preventDefault();
                prevStep();
            }
        });

        // Close modal when clicking outside
        addGuestModal.addEventListener('click', function(event) {
            if (event.target === addGuestModal) {
                hideModal();
            }
        });
    });
</script>
@endpush