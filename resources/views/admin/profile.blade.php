@extends('layouts.app')

@section('title', 'ព័ត៌មានផ្ទាល់ខ្លួន')

@section('content')
<div class="min-h-screen bg-gray-50">

    <main class="md:pl-64">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 md:px-8 py-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">ព័ត៌មានផ្ទាល់ខ្លួន</h1>
                <p class="text-gray-600 mt-2">គ្រប់គ្រងព័ត៌មានគណនី និងសុវត្ថិភាពរបស់អ្នក</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Profile Info -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Profile Information Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">ព័ត៌មានគណនី</h2>

                        <div class="flex items-start space-x-6 mb-8">
                            <div class="relative">
                                <img class="w-24 h-24 rounded-2xl border-4 border-blue-100"
                                    src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=3b82f6&color=fff&size=128"
                                    alt="{{ auth()->user()->name }}">
                                <button class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                                <p class="text-gray-600">{{ auth()->user()->email }}</p>
                                <div class="flex items-center space-x-2 mt-3">
                                    <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                        អ្នកគ្រប់គ្រង
                                    </span>
                                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                        សកម្ម
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Form -->
                        <form action="#" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ឈ្មោះ</label>
                                    <input type="text" name="name" value="{{ auth()->user()->name }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">អ៊ីមែល</label>
                                    <input type="email" name="email" value="{{ auth()->user()->email }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">តួនាទី</label>
                                <input type="text" value="អ្នកគ្រប់គ្រង (Admin)" readonly
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 text-gray-500">
                            </div>

                            <div class="flex justify-end space-x-3 mt-8">
                                <button type="button"
                                    class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
                                    បោះបង់
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700">
                                    រក្សាទុក
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">ផ្លាស់ប្តូរពាក្យសម្ងាត់</h2>

                        <form action="#" method="POST">
                            @csrf

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ពាក្យសម្ងាត់បច្ចុប្បន្ន</label>
                                    <input type="password" name="current_password"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">ពាក្យសម្ងាត់ថ្មី</label>
                                    <input type="password" name="new_password"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">បញ្ជាក់ពាក្យសម្ងាត់ថ្មី</label>
                                    <input type="password" name="new_password_confirmation"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 mt-8">
                                <button type="submit"
                                    class="px-6 py-3 rounded-xl bg-green-600 text-white hover:bg-green-700">
                                    ផ្លាស់ប្តូរពាក្យសម្ងាត់
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column - Stats & Info -->
                <div class="space-y-8">
                    <!-- Account Stats -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">ស្ថិតិគណនី</h3>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">សមាជិកចូលចាប់ពី</span>
                                <span class="font-medium text-gray-900">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">ចូលប្រើចុងក្រោយ</span>
                                <span class="font-medium text-gray-900">{{ auth()->user()->updated_at->diffForHumans() }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">ស្ថានភាពគណនី</span>
                                <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    សកម្ម
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">សកម្មភាពរហ័ស</h3>

                        <div class="space-y-3">
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center p-3 rounded-xl border border-slate-200 hover:bg-blue-50 hover:border-blue-200 transition">
                                <span class="mr-3 text-blue-600">🏠</span>
                                <span class="font-medium text-gray-900">ទៅផ្ទាំងគ្រប់គ្រង</span>
                            </a>

                            <a href="{{ route('admin.settings.index') }}"
                                class="flex items-center p-3 rounded-xl border border-slate-200 hover:bg-gray-50 transition">
                                <span class="mr-3 text-gray-600">⚙️</span>
                                <span class="font-medium text-gray-900">ការកំណត់ប្រព័ន្ធ</span>
                            </a>

                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="flex items-center p-3 rounded-xl border border-slate-200 hover:bg-red-50 hover:border-red-200 transition">
                                <span class="mr-3 text-red-600">🚪</span>
                                <span class="font-medium text-gray-900">ចាកចេញ</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>

                    <!-- Security Tips -->
                    <div class="bg-blue-50 rounded-2xl border border-blue-100 p-6">
                        <h3 class="text-lg font-bold text-blue-900 mb-4">គន្លឹះសុវត្ថិភាព</h3>

                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <span class="text-sm text-blue-800">ប្រើពាក្យសម្ងាត់ខ្លាំងមានអក្សរធំ តូច លេខ និងសញ្ញា</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <span class="text-sm text-blue-800">ផ្លាស់ប្តូរពាក្យសម្ងាត់រៀងរាល់ ៣ ខែ</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <span class="text-sm text-blue-800">មិនចែករំលែកពាក្យសម្ងាត់ជាមួយនរណាម្នាក់</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection