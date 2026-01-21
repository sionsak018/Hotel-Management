<?php

use App\Models\Setting;

if (!function_exists('hotel_setting')) {
    function hotel_setting($key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}

if (!function_exists('format_currency')) {
    function format_currency($amount)
    {
        $currency = hotel_setting('currency', 'USD');
        $symbols = [
            'USD' => '$',
            'KHR' => '៛',
            'THB' => '฿',
        ];

        $symbol = $symbols[$currency] ?? '$';

        if ($currency === 'KHR') {
            return number_format($amount) . '៛';
        }

        return $symbol . number_format($amount, 2);
    }
}

if (!function_exists('get_room_status_badge')) {
    function get_room_status_badge($status)
    {
        $badges = [
            'available' => 'bg-emerald-100 text-emerald-800',
            'occupied' => 'bg-blue-100 text-blue-800',
            'booked' => 'bg-purple-100 text-purple-800',
            'cleaning' => 'bg-orange-100 text-orange-800',
            'maintenance' => 'bg-red-100 text-red-800',
        ];

        return $badges[$status] ?? 'bg-gray-100 text-gray-800';
    }
}

if (!function_exists('get_stay_type_badge')) {
    function get_stay_type_badge($type)
    {
        $badges = [
            'ម៉ោង' => 'bg-orange-100 text-orange-800',
            'យប់' => 'bg-blue-100 text-blue-800',
            'ខែ' => 'bg-indigo-100 text-indigo-800',
        ];

        return $badges[$type] ?? 'bg-gray-100 text-gray-800';
    }
}

if (!function_exists('calculate_overtime')) {
    function calculate_overtime($checkIn, $checkOut = null)
    {
        if (!$checkIn) return '0h';

        $checkOut = $checkOut ?? now();
        $checkInTime = \Carbon\Carbon::parse($checkIn);
        $checkOutTime = \Carbon\Carbon::parse($checkOut);

        $hours = $checkOutTime->diffInHours($checkInTime);

        if ($hours < 1) {
            return $checkOutTime->diffInMinutes($checkInTime) . 'm';
        }

        return $hours . 'h';
    }
}
