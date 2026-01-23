<!-- resources/views/admin/modals/room-status.blade.php -->
<div id="roomStatusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-6xl max-h-[90vh] overflow-hidden flex flex-col">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-200 flex-shrink-0">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">ផ្លាស់ប្តូរស្ថានភាពបន្ទប់</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        បន្ទប់ #<span id="roomNumberDisplay">-</span> |
                        ប្រភេទ: <span id="roomTypeDisplay">-</span> |
                        ជាន់ទី: <span id="roomFloorDisplay">-</span>
                    </p>
                </div>
                <button onclick="hideRoomStatusModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="flex-1 overflow-y-auto p-6">
            <form id="roomStatusForm">
                @csrf
                <input type="hidden" id="roomId" name="room_id">
                <input type="hidden" id="currentStatus" name="current_status">
                <input type="hidden" id="roomBasePrice" name="room_base_price" value="0">

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <!-- Column 1: Status & Actions -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-gray-50 p-5 rounded-xl">
                            <h4 class="font-semibold text-gray-900 mb-4">ស្ថានភាពបន្ទប់</h4>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ស្ថានភាព</label>
                                    <select name="status" id="statusSelect" required
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                        onchange="toggleGuestFields()">
                                        <option value="available">ទំនេរ</option>
                                        <option value="occupied">មានភ្ញៀវ</option>
                                        <option value="booked">បានកក់</option>
                                        <option value="cleaning">កំពុងសម្អាត</option>
                                        <option value="maintenance">កំពុងជួសជុល</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ប្រភេទស្នាក់នៅ</label>
                                    <select name="stay_type" id="stayType"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                        onchange="calculateTotalPrice()">
                                        <option value="">ជ្រើសរើស</option>
                                        <option value="ម៉ោង">ម៉ោង</option>
                                        <option value="យប់">យប់</option>
                                        <option value="សប្តាហ៍">សប្តាហ៍</option>
                                        <option value="ខែ">ខែ</option>
                                        <option value="ឆ្នាំ">ឆ្នាំ</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">ភ្ញៀវ</label>
                                        <input type="number" name="number_of_guests" id="numberOfGuests" min="1" max="20" value="1"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                            onchange="calculateTotalPrice()">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">ក្មេង</label>
                                        <input type="number" name="children_count" id="childrenCount" min="0" max="10" value="0"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                            onchange="calculateTotalPrice()">
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-gray-200 space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-700">តម្លៃបន្ទប់:</span>
                                        <span class="text-sm font-bold text-emerald-600" id="basePriceDisplay">$0.00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-700">តម្លៃសរុប:</span>
                                        <span class="text-lg font-bold text-blue-600" id="totalPriceDisplay">$0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div id="bookedActions" class="hidden space-y-3">
                            <button type="button" onclick="startStay()"
                                class="w-full px-4 py-3 rounded-lg bg-green-600 text-white hover:bg-green-700 font-medium transition-colors">
                                🏁 ចាប់ផ្តើមស្នាក់នៅ
                            </button>
                            <button type="button" onclick="cancelBooking()"
                                class="w-full px-4 py-3 rounded-lg bg-red-600 text-white hover:bg-red-700 font-medium transition-colors">
                                ❌ លុបចោលការកក់
                            </button>
                        </div>

                        <div id="occupiedActions" class="hidden space-y-3">
                            <button type="button" onclick="checkoutRoom()"
                                class="w-full px-4 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium transition-colors">
                                🚪 Check-out
                            </button>

                            <button type="button" onclick="showExtendModal()"
                                class="w-full px-4 py-3 rounded-lg bg-purple-600 text-white hover:bg-purple-700 font-medium transition-colors">
                                ⏱️ ពន្យារពេល
                            </button>
                        </div>

                        <div id="cleaningActions" class="hidden">
                            <button type="button" onclick="finishCleaning()"
                                class="w-full px-4 py-3 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 font-medium transition-colors">
                                ✅ បញ្ចប់សម្អាត
                            </button>
                        </div>
                    </div>

                    <!-- Columns 2-4: Guest Information -->
                    <div class="lg:col-span-3">
                        <div id="guestFields" class="hidden">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Personal Information -->
                                <div class="space-y-6">
                                    <div class="bg-gray-50 p-5 rounded-xl">
                                        <h4 class="font-semibold text-gray-900 mb-4">ព័ត៌មានផ្ទាល់ខ្លួន</h4>

                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">ឈ្មោះភ្ញៀវ *</label>
                                                <input type="text" name="guest_name" id="guestName" required
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">ភេទ</label>
                                                    <select name="gender" id="gender"
                                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                                        <option value="">ជ្រើសរើស</option>
                                                        <option value="male">ប្រុស</option>
                                                        <option value="female">ស្រី</option>
                                                        <option value="other">ផ្សេងៗ</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">អាយុ</label>
                                                    <input type="number" name="age" id="age" min="1" max="120"
                                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">លេខទូរស័ព្ទ *</label>
                                                <input type="text" name="phone" id="phone" required
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">អ៊ីមែល</label>
                                                <input type="email" name="email" id="email"
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">អាសយដ្ឋាន</label>
                                                <textarea name="address" id="address" rows="2"
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">ប្រភេទភ្ញៀវ</label>
                                                <select name="guest_type" id="guestType"
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                                    <option value="">ជ្រើសរើស</option>
                                                    <option value="tourist">ទេសចរណ៍</option>
                                                    <option value="business">អាជីវកម្ម</option>
                                                    <option value="family">គ្រួសារ</option>
                                                    <option value="group">ក្រុម</option>
                                                    <option value="student">សិស្ស</option>
                                                    <option value="local">ម្ចាស់ស្រុក</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ID Information -->
                                    <div class="bg-gray-50 p-5 rounded-xl">
                                        <h4 class="font-semibold text-gray-900 mb-4">ព័ត៌មានអត្តសញ្ញាណ</h4>

                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">ប្រភេទអត្តសញ្ញាណ</label>
                                                <select name="id_type" id="idType"
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                                    <option value="">ជ្រើសរើស</option>
                                                    <option value="passport">លិខិតឆ្លងដែន</option>
                                                    <option value="national_id">អត្តសញ្ញាណប័ណ្ណ</option>
                                                    <option value="driver_license">បើកបរ</option>
                                                    <option value="other">ផ្សេងៗ</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">លេខអត្តសញ្ញាណ</label>
                                                <input type="text" name="cart_id" id="cartId"
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">ប្រទេស</label>
                                                <input type="text" name="country" id="country"
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">រូបភាពអត្តសញ្ញាណ</label>
                                                <input type="file" name="photo" id="photo" accept="image/*"
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                                    onchange="previewImage(event)">
                                                <div id="photoPreview" class="hidden mt-3">
                                                    <div class="flex items-center gap-4 p-3 bg-white border border-gray-200 rounded-lg">
                                                        <img id="previewImage" class="w-24 h-16 object-cover rounded-md">
                                                        <div class="flex-1">
                                                            <p class="text-sm text-gray-600 mb-1">រូបភាពដែលបានជ្រើសរើស</p>
                                                            <button type="button" onclick="removeImage()"
                                                                class="text-xs text-red-600 hover:text-red-700">
                                                                លុបរូបភាព
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stay & Payment Information -->
                                <div class="space-y-6">
                                    <!-- Stay Information -->
                                    <div class="bg-gray-50 p-5 rounded-xl">
                                        <h4 class="font-semibold text-gray-900 mb-4">ព័ត៌មានស្នាក់នៅ</h4>

                                        <div class="space-y-4">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">ថ្ងៃចូល</label>
                                                    <input type="date" name="check_in_date" id="checkInDate"
                                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                                        onchange="calculateDuration()">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">ម៉ោងចូល</label>
                                                    <input type="time" name="check_in_time" id="checkInTime"
                                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">ថ្ងៃចេញ</label>
                                                    <input type="date" name="check_out_date" id="checkOutDate"
                                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                                        onchange="calculateDuration()">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">ម៉ោងចេញ</label>
                                                    <input type="time" name="check_out_time" id="checkOutTime"
                                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                                </div>
                                            </div>

                                            <div id="durationInfo" class="hidden p-3 bg-blue-50 rounded-lg">
                                                <div class="text-sm text-blue-700">
                                                    រយៈពេលស្នាក់នៅ: <span id="durationDays">0</span> ថ្ងៃ
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Information -->
                                    <div class="bg-gray-50 p-5 rounded-xl">
                                        <h4 class="font-semibold text-gray-900 mb-4">ព័ត៌មានការទូទាត់</h4>

                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">ប្រាក់កក់ ($)</label>
                                                <div class="relative">
                                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                                    <input type="number" step="0.01" name="deposit" id="deposit" value="0"
                                                        class="w-full pl-8 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                                        onchange="calculateBalance()">
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">វិធីសាស្រ្តទូទាត់</label>
                                                <select name="payment_method" id="paymentMethod"
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                                    <option value="">ជ្រើសរើស</option>
                                                    <option value="cash">សាច់ប្រាក់</option>
                                                    <option value="credit_card">កាតឥណទាន</option>
                                                    <option value="bank_transfer">ផ្ទេរតាមធនាគារ</option>
                                                    <option value="mobile_payment">ទូទាត់តាមទូរស័ព្ទ</option>
                                                    <option value="other">ផ្សេងៗ</option>
                                                </select>
                                            </div>

                                            <!-- Price Summary -->
                                            <div class="p-4 bg-white border border-gray-200 rounded-lg">
                                                <div class="space-y-2">
                                                    <div class="flex justify-between">
                                                        <span class="text-sm text-gray-600">តម្លៃបន្ទប់:</span>
                                                        <span class="text-sm font-medium" id="roomPriceSummary">$0.00</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-sm text-gray-600">ពន្ធ (10%):</span>
                                                        <span class="text-sm font-medium" id="taxAmount">$0.00</span>
                                                    </div>
                                                    <div class="pt-2 border-t border-gray-200 flex justify-between">
                                                        <span class="text-base font-semibold text-gray-900">សរុប:</span>
                                                        <span class="text-lg font-bold text-blue-600" id="grandTotal">$0.00</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-sm text-gray-600">ប្រាក់កក់:</span>
                                                        <span class="text-sm font-medium text-red-600" id="depositSummary">$0.00</span>
                                                    </div>
                                                    <div class="pt-2 border-t border-gray-200 flex justify-between">
                                                        <span class="text-sm font-semibold text-gray-900">នៅខ្វះ:</span>
                                                        <span class="text-base font-bold text-orange-600" id="balanceAmount">$0.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Services -->
                                    <div class="bg-gray-50 p-5 rounded-xl">
                                        <h4 class="font-semibold text-gray-900 mb-4">សេវាកម្មបន្ថែម</h4>
                                        <div class="space-y-3">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="additional_services[]" value="breakfast" class="rounded border-gray-300 text-blue-600" onchange="calculateTotalPrice()">
                                                <span class="ml-2 text-sm text-gray-700">អាហារពេលព្រឹក</span>
                                                <span class="ml-auto text-sm font-medium text-gray-600">$5</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="additional_services[]" value="laundry" class="rounded border-gray-300 text-blue-600" onchange="calculateTotalPrice()">
                                                <span class="ml-2 text-sm text-gray-700">សេវាកម្មបោកគក់</span>
                                                <span class="ml-auto text-sm font-medium text-gray-600">$10</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div class="bg-gray-50 p-5 rounded-xl">
                                        <h4 class="font-semibold text-gray-900 mb-4">កំណត់សម្គាល់</h4>
                                        <textarea name="notes" id="notes" rows="4"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Overtime Warning -->
                            <div id="overtimeWarning" class="hidden mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-yellow-800">ព្រមាន: ម៉ោងលើស</p>
                                        <p class="text-xs text-yellow-600 mt-1" id="overtimeMessage"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- No Guest Info Message -->
                        <div id="noGuestInfo" class="hidden text-center py-12">
                            <div class="mx-auto h-20 w-20 text-gray-300 mb-4">
                                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500">បំពេញព័ត៌មានភ្ញៀវនៅពេលជ្រើសរើស "មានភ្ញៀវ" ឬ "បានកក់"</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="p-6 border-t border-gray-200 bg-gray-50 flex-shrink-0">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600" id="formStatusMessage">
                    កំពុងកែសម្រួលបន្ទប់
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="hideRoomStatusModal()"
                        class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                        បោះបង់
                    </button>
                    <button type="submit" id="submitButton" form="roomStatusForm"
                        class="px-6 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium transition-colors">
                        រក្សាទុកព័ត៌មាន
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Extend Stay Modal -->
<div id="extendStayModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[60] p-4">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold mb-6">ពន្យារពេលស្នាក់នៅ</h3>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ចំនួនថ្ងៃ</label>
                <input type="number" id="extendDays" min="0" max="30" value="1"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ចំនួនម៉ោង</label>
                <input type="number" id="extendHours" min="0" max="23" value="0"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div id="extendPriceInfo" class="p-4 bg-blue-50 rounded-lg hidden">
                <div class="text-sm text-blue-700">
                    តម្លៃបន្ថែម: <span id="extendPrice">$0.00</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-8">
            <button type="button" onclick="hideExtendModal()"
                class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">
                បោះបង់
            </button>
            <button type="button" onclick="extendStay()"
                class="px-6 py-3 rounded-lg bg-purple-600 text-white hover:bg-purple-700 font-medium">
                ពន្យារពេល
            </button>
        </div>
    </div>
</div>

<script>
    // Image Preview
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('photoPreview');
        const previewImage = document.getElementById('previewImage');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.classList.remove('hidden');
                previewImage.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        document.getElementById('photo').value = '';
        document.getElementById('photoPreview').classList.add('hidden');
        document.getElementById('previewImage').src = '';
    }

    // Extend Stay Functions
    function showExtendModal() {
        document.getElementById('extendStayModal').classList.remove('hidden');
        calculateExtendPrice();
    }

    function hideExtendModal() {
        document.getElementById('extendStayModal').classList.add('hidden');
    }

    function calculateExtendPrice() {
        const extendDays = parseInt(document.getElementById('extendDays').value) || 0;
        const extendHours = parseInt(document.getElementById('extendHours').value) || 0;
        const totalHours = (extendDays * 24) + extendHours;

        // Calculate price based on stay type
        const stayType = document.getElementById('stayType')?.value || 'យប់';
        let hourlyRate = basePrice / 24; // Default hourly rate

        switch (stayType) {
            case 'ម៉ោង':
                hourlyRate = basePrice * 0.2 / 24; // 20% of daily rate
                break;
            case 'យប់':
                hourlyRate = basePrice / 24;
                break;
            case 'សប្តាហ៍':
                hourlyRate = (basePrice * 5) / (7 * 24); // Weekly rate
                break;
            case 'ខែ':
                hourlyRate = (basePrice * 20) / (30 * 24); // Monthly rate
                break;
            case 'ឆ្នាំ':
                hourlyRate = (basePrice * 240) / (365 * 24); // Yearly rate
                break;
        }

        const extendPrice = totalHours * hourlyRate;

        const extendPriceInfo = document.getElementById('extendPriceInfo');
        const extendPriceElement = document.getElementById('extendPrice');

        if (extendPriceInfo && extendPriceElement) {
            extendPriceElement.textContent = `$${extendPrice.toFixed(2)}`;
            extendPriceInfo.classList.remove('hidden');
        }
    }

    // Form Submission
    // ជំនួសកូដទាំងមូលនៃ addEventListener submit
    document.getElementById('roomStatusForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        console.log('=== Form Submit Started ===');

        const status = document.getElementById('statusSelect')?.value;
        const form = this;
        const formData = new FormData(form);

        // Validate required fields for occupied/booked status
        if (status === 'occupied' || status === 'booked') {
            const guestName = document.getElementById('guestName')?.value;
            const phone = document.getElementById('phone')?.value;

            if (!guestName?.trim()) {
                alert('សូមបញ្ចូលឈ្មោះភ្ញៀវ');
                document.getElementById('guestName')?.focus();
                return;
            }

            if (!phone?.trim()) {
                alert('សូមបញ្ចូលលេខទូរស័ព្ទភ្ញៀវ');
                document.getElementById('phone')?.focus();
                return;
            }
        }

        const submitButton = document.getElementById('submitButton');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'កំពុងរក្សាទុក...';
        submitButton.disabled = true;

        try {
            console.log('Sending fetch request to:', `/admin/rooms/${currentRoomId}/status`);

            const response = await fetch(`/admin/rooms/${currentRoomId}/status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    // DO NOT set Content-Type header for FormData
                    // Browser will set it automatically with boundary
                },
                body: formData
            });

            console.log('Response received. Status:', response.status);

            // Check if response is HTML (error page) instead of JSON
            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                const text = await response.text();
                console.error('Expected JSON but got:', text.substring(0, 500));

                // Check if this is a login redirect
                if (text.includes('login') || response.status === 401) {
                    throw new Error('សម័យប្រើប្រាស់បានផុតកំណត់។ សូមចូលឡើងវិញ។');
                }

                throw new Error('ម៉ាស៊ីនបម្រើបានតបមកជា HTML ជំនួសអោយ JSON');
            }

            const data = await response.json();
            console.log('Response JSON data:', data);

            if (data.success) {
                alert(data.message || 'ការផ្លាស់ប្តូរជោគជ័យ!');
                location.reload();
            } else {
                throw new Error(data.message || 'មានបញ្ហាកើតឡើង');
            }
        } catch (error) {
            console.error('Fetch Error:', error);
            alert('មិនអាចភ្ជាប់ទៅម៉ាស៊ីនបម្រើបានទេ: ' + error.message);
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    });

    // Action Functions
    function startStay() {
        if (!currentRoomId) return;

        if (!confirm('តើអ្នកពិតជាចង់ចាប់ផ្តើមស្នាក់នៅសម្រាប់ភ្ញៀវនេះមែនទេ?')) return;

        fetch(`/admin/rooms/${currentRoomId}/start`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'ចាប់ផ្តើមស្នាក់នៅដោយជោគជ័យ');
                    location.reload();
                } else {
                    alert(data.message || 'មានបញ្ហាកើតឡើង');
                }
            })
            .catch(console.error);
    }

    function cancelBooking() {
        if (!currentRoomId) return;

        if (!confirm('តើអ្នកពិតជាចង់លុបចោលការកក់នេះមែនទេ?')) return;

        fetch(`/admin/rooms/${currentRoomId}/cancel`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'ការកក់ត្រូវបានលុបចោល');
                    location.reload();
                } else {
                    alert(data.message || 'មានបញ្ហាកើតឡើង');
                }
            })
            .catch(console.error);
    }

    function checkoutRoom() {
        if (!currentRoomId) return;

        fetch(`/admin/rooms/${currentRoomId}/checkout`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'Check-out ដោយជោគជ័យ');
                    location.reload();
                } else {
                    alert(data.message || 'មានបញ្ហាកើតឡើង');
                }
            })
            .catch(console.error);
    }

    function finishCleaning() {
        if (!currentRoomId) return;

        fetch(`/admin/rooms/${currentRoomId}/finish-cleaning`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'បញ្ចប់ការសម្អាតដោយជោគជ័យ');
                    location.reload();
                } else {
                    alert(data.message || 'មានបញ្ហាកើតឡើង');
                }
            })
            .catch(console.error);
    }

    function extendStay() {
        if (!currentRoomId) return;

        const extendDays = parseInt(document.getElementById('extendDays').value) || 0;
        const extendHours = parseInt(document.getElementById('extendHours').value) || 0;

        if (extendDays === 0 && extendHours === 0) {
            alert('សូមបញ្ចូលចំនួនថ្ងៃ ឬម៉ោងដែលចង់ពន្យារ');
            return;
        }

        fetch(`/admin/rooms/${currentRoomId}/extend`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    extend_days: extendDays,
                    extend_hours: extendHours
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || 'ពន្យារពេលដោយជោគជ័យ');
                    hideExtendModal();
                    // Refresh room info
                    loadRoomInfo(currentRoomId);
                } else {
                    alert(data.message || 'មានបញ្ហាកើតឡើង');
                }
            })
            .catch(console.error);
    }

    // Event Listeners for extend modal
    document.getElementById('extendDays')?.addEventListener('input', calculateExtendPrice);
    document.getElementById('extendHours')?.addEventListener('input', calculateExtendPrice);

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('roomStatusModal');
        if (event.target === modal) {
            hideRoomStatusModal();
        }

        const extendModal = document.getElementById('extendStayModal');
        if (event.target === extendModal) {
            hideExtendModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (!document.getElementById('extendStayModal').classList.contains('hidden')) {
                hideExtendModal();
            } else if (!document.getElementById('roomStatusModal').classList.contains('hidden')) {
                hideRoomStatusModal();
            }
        }
    });

    // Auto-set dates and times
    document.getElementById('checkInDate')?.addEventListener('focus', function() {
        if (!this.value) {
            this.value = new Date().toISOString().split('T')[0];
        }
    });

    document.getElementById('checkInTime')?.addEventListener('focus', function() {
        if (!this.value) {
            const now = new Date();
            this.value = now.getHours().toString().padStart(2, '0') + ':' +
                now.getMinutes().toString().padStart(2, '0');
        }
    });

    document.getElementById('checkOutDate')?.addEventListener('focus', function() {
        if (!this.value) {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            this.value = tomorrow.toISOString().split('T')[0];
        }
    });

    document.getElementById('checkOutTime')?.addEventListener('focus', function() {
        if (!this.value) {
            this.value = '12:00';
        }
    });
    // ក្នុង room-status.blade.php script
    document.getElementById('roomStatusForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const status = document.getElementById('statusSelect')?.value;
        const form = this;
        const formData = new FormData(form);

        // Validate required fields for occupied/booked status
        if (status === 'occupied' || status === 'booked') {
            const guestName = document.getElementById('guestName')?.value;
            const phone = document.getElementById('phone')?.value;

            if (!guestName?.trim()) {
                alert('សូមបញ្ចូលឈ្មោះភ្ញៀវ');
                document.getElementById('guestName')?.focus();
                return;
            }

            if (!phone?.trim()) {
                alert('សូមបញ្ចូលលេខទូរស័ព្ទភ្ញៀវ');
                document.getElementById('phone')?.focus();
                return;
            }
        }

        const submitButton = document.getElementById('submitButton');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'កំពុងរក្សាទុក...';
        submitButton.disabled = true;

        try {
            const response = await fetch(`/admin/rooms/${currentRoomId}/status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    // DO NOT set Content-Type header for FormData
                    // Browser will set it automatically with boundary
                },
                body: formData
            });

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
            }

            const data = await response.json();

            if (data.success) {
                alert(data.message || 'ការផ្លាស់ប្តូរជោគជ័យ!');
                location.reload();
            } else {
                throw new Error(data.message || 'មានបញ្ហាកើតឡើង');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'មិនអាចភ្ជាប់ទៅម៉ាស៊ីនបម្រើបានទេ');
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    });
    document.getElementById('roomStatusForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        console.log('=== Form Submit Started ===');
        console.log('Current Room ID:', currentRoomId);
        console.log('Form element:', this);

        const status = document.getElementById('statusSelect')?.value;
        const form = this;
        const formData = new FormData(form);

        // Show what's in formData
        console.log('FormData contents:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ', pair[1]);
        }

        // Validate required fields for occupied/booked status
        if (status === 'occupied' || status === 'booked') {
            const guestName = document.getElementById('guestName')?.value;
            const phone = document.getElementById('phone')?.value;

            if (!guestName?.trim()) {
                alert('សូមបញ្ចូលឈ្មោះភ្ញៀវ');
                document.getElementById('guestName')?.focus();
                return;
            }

            if (!phone?.trim()) {
                alert('សូមបញ្ចូលលេខទូរស័ព្ទភ្ញៀវ');
                document.getElementById('phone')?.focus();
                return;
            }
        }

        const submitButton = document.getElementById('submitButton');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'កំពុងរក្សាទុក...';
        submitButton.disabled = true;

        try {
            console.log('Sending fetch request to:', `/admin/rooms/${currentRoomId}/status`);

            const response = await fetch(`/admin/rooms/${currentRoomId}/status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            });

            console.log('Response received. Status:', response.status);
            console.log('Response headers:', response.headers);

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Response error text:', errorText);
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Response JSON data:', data);

            if (data.success) {
                alert(data.message || 'ការផ្លាស់ប្តូរជោគជ័យ!');
                location.reload();
            } else {
                throw new Error(data.message || 'មានបញ្ហាកើតឡើង');
            }
        } catch (error) {
            console.error('Fetch Error:', error);
            console.error('Error details:', {
                name: error.name,
                message: error.message,
                stack: error.stack
            });
            alert('មិនអាចភ្ជាប់ទៅម៉ាស៊ីនបម្រើបានទេ: ' + error.message);
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    });

    function hideRoomStatusModal() {
        const modal = document.getElementById('roomStatusModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';

            // Reset form
            const form = document.getElementById('roomStatusForm');
            if (form) {
                form.reset();
            }

            // Reset photo preview
            const photoPreview = document.getElementById('photoPreview');
            if (photoPreview) {
                photoPreview.classList.add('hidden');
            }

            // Reset global variables
            currentRoomId = null;
            currentRoomStatus = null;
            basePrice = 0;
        }
    }
    // បន្ថែមព្រឹត្តិការណ៍ onchange សម្រាប់ input file
    document.getElementById('photo')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (file && file.size > maxSize) {
            alert('ទំហំរូបភាពធំពេក។ សូមជ្រើសរើសរូបភាពតូចជាង 5MB។');
            this.value = '';
            document.getElementById('photoPreview').classList.add('hidden');
            return false;
        }

        // ពិនិត្យប្រភេទឯកសារ
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (file && !allowedTypes.includes(file.type)) {
            alert('ប្រភេទឯកសារមិនត្រឹមត្រូវ។ សូមជ្រើសរើសរូបភាព JPG, PNG ឬ GIF។');
            this.value = '';
            document.getElementById('photoPreview').classList.add('hidden');
            return false;
        }

        previewImage(e);
    });

    // កែតម្រូវ previewImage function
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('photoPreview');
        const previewImage = document.getElementById('previewImage');

        if (input.files && input.files[0]) {
            // បង្ហាញការផ្ទុក
            previewImage.src = '';
            preview.classList.remove('hidden');
            previewImage.classList.add('opacity-50');

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('opacity-50');
            }
            reader.onerror = function() {
                alert('មិនអាចអានឯកសាររូបភាពបានទេ។');
                preview.classList.add('hidden');
                input.value = '';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>