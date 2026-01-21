<header class="bg-white border-b border-slate-200 flex-shrink-0">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4 md:justify-start md:space-x-10">
            <div class="flex justify-start lg:w-0 lg:flex-1">
                <div class="md:hidden">
                    <!-- Mobile menu button -->
                    <button type="button" onclick="toggleMobileMenu()"
                        class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <span class="sr-only">Open menu</span>
                        <!-- Menu icon -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <div class="hidden md:block">
                    <h2 class="text-xl font-black text-slate-800">
                        @yield('title', 'ផ្ទាំងគ្រប់គ្រង')
                    </h2>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span id="current-time" class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                            {{ now()->format('h:i:s A') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0 space-x-4">
                <!-- Notification Bell -->
                <div class="relative">
                    <button type="button" onclick="toggleNotifications()"
                        class="bg-gray-100 p-2 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="sr-only">View notifications</span>
                        <!-- Bell icon -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                    <!-- Notification badge -->
                    <span id="notification-badge"
                        <!-- class="hidden absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"> -->
                        3
                    </span>

                    <!-- Notification dropdown -->
                    <div id="notification-dropdown"
                        class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg py-1 z-10 border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-100">
                            <h3 class="text-sm font-bold text-slate-800">ការជូនដំណឹង</h3>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            <!-- Notification items -->
                            <a href="#" class="flex px-4 py-3 hover:bg-slate-50 border-b border-slate-100">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 text-sm">🏨</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-slate-900">ការកក់ទុកថ្មី</p>
                                    <p class="text-xs text-slate-500">បន្ទប់ #102 ត្រូវបានកក់</p>
                                    <p class="text-xs text-slate-400">មុន ៥ នាទី</p>
                                </div>
                            </a>
                            <a href="#" class="flex px-4 py-3 hover:bg-slate-50 border-b border-slate-100">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                        <span class="text-emerald-600 text-sm">✅</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-slate-900">បានចាកចេញ</p>
                                    <p class="text-xs text-slate-500">បន្ទប់ #201 បានចាកចេញ</p>
                                    <p class="text-xs text-slate-400">មុន ៣០ នាទី</p>
                                </div>
                            </a>
                        </div>
                        <div class="px-4 py-2 border-t border-slate-100">
                            <a href="#" class="block text-center text-sm font-medium text-blue-600 hover:text-blue-800">
                                មើលទាំងអស់
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User Profile Dropdown -->
                <div class="relative">
                    <button type="button" onclick="toggleProfileMenu()"
                        class="flex items-center gap-2 p-1 pr-3 rounded-full hover:bg-slate-50 transition-all border border-transparent hover:border-slate-200">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=3b82f6&color=fff"
                            class="w-8 h-8 rounded-full" alt="{{ auth()->user()->name }}">
                        <span class="text-[10px] font-black text-slate-600 hidden lg:block uppercase">
                            {{ auth()->user()->name }}
                        </span>
                        <svg class="ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Profile dropdown -->
                    <div id="profile-dropdown"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 z-10 border border-slate-200">
                        <div class="px-4 py-3 border-b border-slate-100">
                            <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('admin.profile') }}"
                            class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            <span class="mr-2">👤</span> ព័ត៌មានផ្ទាល់ខ្លួន
                        </a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            <span class="mr-2">⚙️</span> ការកំណត់
                        </a>
                        <div class="border-t border-slate-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <span class="mr-2">🚪</span> ចាកចេញ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                🔑 បន្ទប់ស្នាក់នៅ
            </a>
            <a href="{{ route('admin.guests') }}"
                class="{{ request()->routeIs('admin.guests') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                👥 បញ្ជីភ្ញៀវ
            </a>
            <a href="{{ route('admin.bookings.index') }}"
                class="{{ request()->routeIs('admin.bookings') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                📅 ការកក់ទុក
            </a>
            <a href="{{ route('admin.reports.index') }}"
                class="{{ request()->routeIs('admin.reports') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                📊 របាយការណ៍
            </a>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full"
                        src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=3b82f6&color=fff"
                        alt="{{ auth()->user()->name }}">
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('admin.profile') }}"
                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                    ព័ត៌មានផ្ទាល់ខ្លួន
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:text-red-800 hover:bg-red-50">
                        ចាកចេញ
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
    // Update current time
    function updateCurrentTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('km-KH', {
            hour12: true,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('current-time').textContent = timeString;
    }

    // Update time every second
    setInterval(updateCurrentTime, 1000);
    updateCurrentTime(); // Initial call

    // Toggle mobile menu
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }

    // Toggle notifications dropdown
    function toggleNotifications() {
        const dropdown = document.getElementById('notification-dropdown');
        dropdown.classList.toggle('hidden');

        // Close profile dropdown if open
        document.getElementById('profile-dropdown').classList.add('hidden');
    }

    // Toggle profile dropdown
    function toggleProfileMenu() {
        const dropdown = document.getElementById('profile-dropdown');
        dropdown.classList.toggle('hidden');

        // Close notifications dropdown if open
        document.getElementById('notification-dropdown').classList.add('hidden');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const notificationsDropdown = document.getElementById('notification-dropdown');
        const profileDropdown = document.getElementById('profile-dropdown');
        const notificationButton = event.target.closest('button[onclick*="toggleNotifications"]');
        const profileButton = event.target.closest('button[onclick*="toggleProfileMenu"]');

        if (!notificationButton && !notificationsDropdown.contains(event.target)) {
            notificationsDropdown.classList.add('hidden');
        }

        if (!profileButton && !profileDropdown.contains(event.target)) {
            profileDropdown.classList.add('hidden');
        }
    });

    // Fetch notifications
    function fetchNotifications() {
        fetch('/api/notifications')
            .then(response => response.json())
            .then(data => {
                updateNotificationBadge(data.unread_count);
                updateNotificationList(data.notifications);
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    function updateNotificationBadge(count) {
        const badge = document.getElementById('notification-badge');
        if (count > 0) {
            badge.textContent = count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    function updateNotificationList(notifications) {
        const container = document.querySelector('#notification-dropdown .max-h-96');
        if (!container) return;

        if (notifications.length === 0) {
            container.innerHTML = `
                <div class="px-4 py-8 text-center">
                    <p class="text-sm text-slate-500">គ្មានការជូនដំណឹងថ្មីទេ</p>
                </div>
            `;
            return;
        }

        let html = '';
        notifications.forEach(notification => {
            const icons = {
                'booking': '🏨',
                'checkin': '✅',
                'checkout': '🚪',
                'payment': '💰',
                'maintenance': '🔧'
            };

            const icon = icons[notification.type] || '🔔';
            const timeAgo = formatTimeAgo(notification.created_at);

            html += `
                <a href="${notification.url || '#'}" 
                   class="flex px-4 py-3 hover:bg-slate-50 border-b border-slate-100">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 text-sm">${icon}</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-slate-900">${notification.title}</p>
                        <p class="text-xs text-slate-500">${notification.message}</p>
                        <p class="text-xs text-slate-400">${timeAgo}</p>
                    </div>
                </a>
            `;
        });

        container.innerHTML = html;
    }

    function formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffMs = now - date;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMs / 3600000);
        const diffDays = Math.floor(diffMs / 86400000);

        if (diffMins < 1) return 'មុននេះបន្តិច';
        if (diffMins < 60) return `មុន ${diffMins} នាទី`;
        if (diffHours < 24) return `មុន ${diffHours} ម៉ោង`;
        if (diffDays === 1) return 'ម្សិលមិញ';
        if (diffDays < 7) return `មុន ${diffDays} ថ្ងៃ`;

        return date.toLocaleDateString('km-KH');
    }

    // Fetch notifications every 30 seconds
    setInterval(fetchNotifications, 30000);

    // Initial fetch
    document.addEventListener('DOMContentLoaded', fetchNotifications);
</script>
@endpush