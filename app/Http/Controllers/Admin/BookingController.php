<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['room', 'guest'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        $guests = Guest::orderBy('name')->get();

        return view('admin.bookings.create', compact('rooms', 'guests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_id' => 'required|exists:guests,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'nullable|date|after:check_in_date',
            'check_in_time' => 'required',
            'check_out_time' => 'nullable',
            'stay_type' => 'required|in:ម៉ោង,យប់,ខែ',
            'total_amount' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,bank_transfer',
            'id_card_image' => 'nullable|image|max:2048',
            'special_requests' => 'nullable|string',
        ]);

        if ($request->hasFile('id_card_image')) {
            $validated['id_card_image'] = $request->file('id_card_image')->store('id_cards', 'public');
        }

        $booking = Booking::create($validated);

        // Update room status
        $room = Room::find($validated['room_id']);
        $room->update([
            'status' => 'booked',
            'guest_name' => $booking->guest->name,
            'phone' => $booking->guest->phone,
            'deposit' => $validated['deposit'],
            'stay_type' => $validated['stay_type'],
            'check_in_date' => $validated['check_in_date'],
            'check_in_time' => $validated['check_in_time'],
        ]);

        return redirect()->route('admin.bookings')
            ->with('success', 'ការកក់ទុកត្រូវបានបង្កើតដោយជោគជ័យ!');
    }

    public function show(Booking $booking)
    {
        $booking->load(['room', 'guest', 'transactions']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date',
            'check_out_date' => 'nullable|date|after:check_in_date',
            'check_in_time' => 'required',
            'check_out_time' => 'nullable',
            'stay_type' => 'required|in:ម៉ោង,យប់,ខែ',
            'total_amount' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,bank_transfer',
            'status' => 'required|in:confirmed,checked_in,checked_out,cancelled',
            'special_requests' => 'nullable|string',
        ]);

        $booking->update($validated);

        // Update room if needed
        if ($booking->room) {
            $booking->room->update([
                'stay_type' => $validated['stay_type'],
                'check_in_date' => $validated['check_in_date'],
                'check_in_time' => $validated['check_in_time'],
                'deposit' => $validated['deposit'],
            ]);
        }

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'ការកក់ទុកត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->status === 'checked_in') {
            return redirect()->route('admin.bookings')
                ->with('error', 'មិនអាចលុបការកក់ដែលកំពុងស្នាក់នៅបានទេ!');
        }

        // Update room status back to available
        if ($booking->room) {
            $booking->room->update([
                'status' => 'available',
                'guest_name' => null,
                'phone' => null,
                'deposit' => 0,
                'stay_type' => null,
                'check_in_date' => null,
                'check_in_time' => null,
            ]);
        }

        $booking->delete();

        return redirect()->route('admin.bookings')
            ->with('success', 'ការកក់ទុកត្រូវបានលុបដោយជោគជ័យ!');
    }

    public function checkIn(Booking $booking)
    {
        $booking->update(['status' => 'checked_in']);

        $booking->room->update(['status' => 'occupied']);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'ភ្ញៀវបានចូលស្នាក់នៅដោយជោគជ័យ!');
    }

    public function checkOut(Booking $booking)
    {
        $booking->update([
            'status' => 'checked_out',
            'check_out_date' => now(),
            'check_out_time' => now()->format('H:i'),
        ]);

        $booking->room->update([
            'status' => 'cleaning',
            'guest_name' => null,
            'phone' => null,
            'deposit' => 0,
            'stay_type' => null,
            'check_in_date' => null,
            'check_in_time' => null,
        ]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'ភ្ញៀវបានចាកចេញដោយជោគជ័យ!');
    }
}
