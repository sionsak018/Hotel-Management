<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|unique:rooms',
            'type' => 'required|in:Single,Double,Suite,King,Twin,Appartment',
            'floor' => 'required|integer',
            'base_price' => 'required|numeric|min:0',
        ]);

        Room::create($validated);

        return redirect()->route('admin.rooms')
            ->with('success', 'បន្ទប់ត្រូវបានបន្ថែមដោយជោគជ័យ!');
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'number' => 'required|unique:rooms,number,' . $room->id,
            'type' => 'required|in:Single,Double,Suite,King,Twin,Appartment',
            'floor' => 'required|integer',
            'base_price' => 'required|numeric|min:0',
        ]);

        $room->update($validated);

        return redirect()->route('admin.rooms')
            ->with('success', 'បន្ទប់ត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    public function destroy(Room $room)
    {
        if ($room->status === 'occupied' || $room->status === 'booked') {
            return redirect()->route('admin.rooms')
                ->with('error', 'មិនអាចលុបបន្ទប់ដែលមានភ្ញៀវស្នាក់នៅបានទេ!');
        }

        $room->delete();

        return redirect()->route('admin.rooms')
            ->with('success', 'បន្ទប់ត្រូវបានលុបដោយជោគជ័យ!');
    }

    public function updateStatus(Request $request, Room $room)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,booked,cleaning,maintenance',
            'guest_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'deposit' => 'nullable|numeric|min:0',
            'stay_type' => 'nullable|in:ម៉ោង,យប់,ខែ',
        ]);

        $room->update($request->only([
            'status',
            'guest_name',
            'phone',
            'deposit',
            'stay_type'
        ]));

        return response()->json(['success' => true]);
    }
}
