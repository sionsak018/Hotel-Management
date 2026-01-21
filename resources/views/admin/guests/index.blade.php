@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <main class="md:pl-64">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">ភ្ញៀវទាំងអស់</h1>
                <button onclick="showAddGuestModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2">
                    <span>+</span>
                    បន្ថែមភ្ញៀវថ្មី
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">សរុបភ្ញៀវ</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $guests->count() }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-xl">
                            <span class="text-2xl">👥</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">សកម្ម</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $guests->where('status', 'active')->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-xl">
                            <span class="text-2xl">✅</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">អត់វិក្កយបត្រ</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $guests->where('has_invoice', false)->count() }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-xl">
                            <span class="text-2xl">📄</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">មានវិក្កយបត្រ</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $guests->where('has_invoice', true)->count() }}</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-xl">
                            <span class="text-2xl">💰</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guests Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ឈ្មោះ
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    លេខទូរស័ព្ទ
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    អត្តសញ្ញាណប័ណ្ណ
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ប្រភេទ
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ការកក់
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
                            @foreach($guests as $guest)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <span class="font-bold text-blue-600">{{ substr($guest->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $guest->name }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $guest->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $guest->phone }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $guest->id_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                                        {{ $guest->type === 'ជនជាតិ' ? 'bg-green-100 text-green-800' : 
                                           ($guest->type === 'ជនបរទេស' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $guest->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($guest->bookings->count() > 0)
                                    {{ $guest->bookings->count() }} ការកក់
                                    @else
                                    <span class="text-gray-400">គ្មាន</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                                        {{ $guest->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $guest->status === 'active' ? 'សកម្ម' : 'អសកម្ម' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="showEditGuestModal('{{ $guest->id }}')"
                                            class="text-green-600 hover:text-green-900">
                                            កែប្រែ
                                        </button>
                                        <form action="{{ route('admin.guests.destroy', $guest) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('តើអ្នកពិតជាចង់លុបភ្ញៀវនេះមែនទេ?')"
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

                <!-- Pagination - Only show if using paginate() -->
                @if(method_exists($guests, 'links'))
                <div class="p-8 border-t border-slate-100">
                    {{ $guests->links() }}
                </div>
                @endif
            </div>
        </div>
    </main>
</div>

<!-- Add Guest Modal -->
<div id="addGuestModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold mb-6">បន្ថែមភ្ញៀវថ្មី</h3>

        <form action="{{ route('admin.guests.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ឈ្មោះពេញ *</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="ឈ្មោះភ្ញៀវ">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">អ៊ីមែល</label>
                    <input type="email" name="email"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="អ៊ីមែល">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">លេខទូរស័ព្ទ *</label>
                    <input type="text" name="phone" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="លេខទូរស័ព្ទ">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">លេខអត្តសញ្ញាណប័ណ្ណ</label>
                    <input type="text" name="id_number"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="លេខអត្តសញ្ញាណប័ណ្ណ">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ប្រភេទភ្ញៀវ</label>
                    <select name="type"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="ជនជាតិ">ជនជាតិ</option>
                        <option value="ជនបរទេស">ជនបរទេស</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">អាស័យដ្ឋាន</label>
                    <textarea name="address" rows="2"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="អាស័យដ្ឋាន"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ក្រុមហ៊ុន/ស្ថាប័ន</label>
                    <input type="text" name="company"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="ក្រុមហ៊ុន ឬ ស្ថាប័ន">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ស្ថានភាព</label>
                    <select name="status"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active">សកម្ម</option>
                        <option value="inactive">អសកម្ម</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="hideAddGuestModal()"
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

<!-- Edit Guest Modal -->
<div id="editGuestModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold mb-6">កែប្រែភ្ញៀវ</h3>

        <form id="editGuestForm" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ឈ្មោះពេញ *</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">អ៊ីមែល</label>
                    <input type="email" name="email"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">លេខទូរស័ព្ទ *</label>
                    <input type="text" name="phone" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">លេខអត្តសញ្ញាណប័ណ្ណ</label>
                    <input type="text" name="id_number"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ប្រភេទភ្ញៀវ</label>
                    <select name="type"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="ជនជាតិ">ជនជាតិ</option>
                        <option value="ជនបរទេស">ជនបរទេស</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">អាស័យដ្ឋាន</label>
                    <textarea name="address" rows="2"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ក្រុមហ៊ុន/ស្ថាប័ន</label>
                    <input type="text" name="company"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ស្ថានភាព</label>
                    <select name="status"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active">សកម្ម</option>
                        <option value="inactive">អសកម្ម</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="hideEditGuestModal()"
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

@endsection

@push('scripts')
<script>
    // Modal functions
    function showAddGuestModal() {
        document.getElementById('addGuestModal').classList.remove('hidden');
    }

    function hideAddGuestModal() {
        document.getElementById('addGuestModal').classList.add('hidden');
    }

    function showEditGuestModal(guestId) {
        // Load guest data via AJAX
        fetch(`/admin/guests/${guestId}/edit`)
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('editGuestForm');
                form.action = `/admin/guests/${guestId}`;

                // Fill form fields
                form.querySelector('[name="name"]').value = data.name || '';
                form.querySelector('[name="email"]').value = data.email || '';
                form.querySelector('[name="phone"]').value = data.phone || '';
                form.querySelector('[name="id_number"]').value = data.id_number || '';
                form.querySelector('[name="type"]').value = data.type || '';
                form.querySelector('[name="address"]').value = data.address || '';
                form.querySelector('[name="company"]').value = data.company || '';
                form.querySelector('[name="status"]').value = data.status || 'active';

                document.getElementById('editGuestModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('មិនអាចទាញយកទិន្នន័យភ្ញៀវបានទេ');
            });
    }

    function hideEditGuestModal() {
        document.getElementById('editGuestModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    document.addEventListener('click', function(event) {
        const modals = ['addGuestModal', 'editGuestModal'];
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
            hideAddGuestModal();
            hideEditGuestModal();
        }
    });

    // Debug function
    function checkGuestModalFunctionality() {
        console.log('Guest modal elements exist:');
        console.log('- addGuestModal:', document.getElementById('addGuestModal') !== null);
        console.log('- editGuestModal:', document.getElementById('editGuestModal') !== null);
    }

    // Run check when page loads
    document.addEventListener('DOMContentLoaded', checkGuestModalFunctionality);
</script>
@endpush