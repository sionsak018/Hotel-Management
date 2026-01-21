<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hotel_name' => 'required|string|max:255',
            'hotel_address' => 'required|string',
            'hotel_phone' => 'required|string|max:20',
            'hotel_email' => 'required|email',
            'check_in_time' => 'required',
            'check_out_time' => 'required',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'currency' => 'required|string|size:3',
            'timezone' => 'required|timezone',
            'maintenance_mode' => 'boolean',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'ការកំណត់ត្រូវបានរក្សាទុកដោយជោគជ័យ!');
    }
}
