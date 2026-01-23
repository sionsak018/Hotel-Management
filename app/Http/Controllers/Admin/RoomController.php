<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class RoomController extends Controller
{
    /**
     * Display a list of all rooms.
     */
    public function index()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form to create a new room.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a new room in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|string|unique:rooms,number',
            'floor' => 'required|string',
            'type' => 'required|string',
            'base_price' => 'required|numeric|min:0',
        ]);

        Room::create([
            'number' => $request->number,
            'floor' => $request->floor,
            'type' => $request->type,
            'base_price' => $request->base_price,
            'status' => 'available',
        ]);

        return redirect()->route('admin.rooms')->with('success', 'បន្ទប់ត្រូវបានបង្កើតដោយជោគជ័យ');
    }

    /**
     * Show the form to edit an existing room.
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update an existing room.
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'number' => 'required|string|unique:rooms,number,' . $room->id,
            'floor' => 'required|string',
            'type' => 'required|string',
            'base_price' => 'required|numeric|min:0',
        ]);

        $room->update([
            'number' => $request->number,
            'floor' => $request->floor,
            'type' => $request->type,
            'base_price' => $request->base_price,
        ]);

        return redirect()->route('admin.rooms')->with('success', 'បន្ទប់ត្រូវបានកែប្រែដោយជោគជ័យ');
    }

    /**
     * Delete a room.
     */
    public function destroy(Room $room)
    {
        if ($room->photo) {
            Storage::disk('public')->delete($room->photo);
        }

        $room->delete();

        return redirect()->route('admin.rooms')->with('success', 'បន្ទប់ត្រូវបានលុបដោយជោគជ័យ');
    }

    /**
     * Get room info as JSON.
     */
    public function getRoomInfo(Room $room)
    {
        return response()->json([
            'success' => true,
            'room' => $room->toArray()
        ]);
    }

    /**
     * Update room status and guest info.
     */
    public function updateStatus(Request $request, Room $room)
    {
        try {
            $request->validate([
                'status' => 'required|in:available,occupied,booked,cleaning,maintenance',
                'guest_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'cart_id' => 'nullable|string|max:50',
                'number_of_guests' => 'nullable|integer|min:1',
                'children_count' => 'nullable|integer|min:0',
                'deposit' => 'nullable|numeric|min:0',
                'stay_type' => 'required_if:status,occupied,booked|in:ម៉ោង,យប់,សប្តាហ៍,ខែ,ឆ្នាំ',
                'check_in_date' => 'nullable|date',
                'check_in_time' => 'nullable',
                'check_out_date' => 'nullable|date|after_or_equal:check_in_date',
                'check_out_time' => 'nullable',
                'notes' => 'nullable|string',
                'photo' => 'nullable|image|max:10240',
                'gender' => 'nullable|in:male,female,other',
                'age' => 'nullable|integer|min:1|max:120',
                'address' => 'nullable|string|max:500',
                'guest_type' => 'nullable|in:tourist,business,family,group,student,local',
                'id_type' => 'nullable|in:passport,national_id,driver_license,other',
                'country' => 'nullable|string|max:100',
                'payment_method' => 'nullable|in:cash,credit_card,bank_transfer,mobile_payment,other',
            ]);

            $data = $request->only([
                'status',
                'guest_name',
                'email',
                'phone',
                'cart_id',
                'number_of_guests',
                'children_count',
                'deposit',
                'stay_type',
                'check_in_date',
                'check_in_time',
                'check_out_date',
                'check_out_time',
                'notes',
                'gender',
                'age',
                'address',
                'guest_type',
                'id_type',
                'country',
                'payment_method'
            ]);

            // Auto-fill check-in date/time if occupied/booked
            if (in_array($request->status, ['occupied', 'booked'])) {
                $data['check_in_date'] = $data['check_in_date'] ?? Carbon::now()->toDateString();
                $data['check_in_time'] = $data['check_in_time'] ?? Carbon::now()->format('H:i');
            }

            // Handle booking
            if ($request->status === 'booked') {
                $data['original_status'] = $room->status;
                $data['booking_expiry'] = Carbon::now()->addHours(24);
            }
            

            // Handle photo
            if ($request->hasFile('photo')) {
                if ($room->photo) Storage::disk('public')->delete($room->photo);
                $data['photo'] = $request->file('photo')->store('guest-photos', 'public');
            }

            // Clear guest info if status is no longer occupied/booked
            if (in_array($room->status, ['occupied', 'booked']) && !in_array($request->status, ['occupied', 'booked'])) {
                $clear = [
                    'guest_name',
                    'email',
                    'phone',
                    'cart_id',
                    'number_of_guests',
                    'children_count',
                    'deposit',
                    'stay_type',
                    'check_in_date',
                    'check_in_time',
                    'check_out_date',
                    'check_out_time',
                    'gender',
                    'age',
                    'address',
                    'guest_type',
                    'id_type',
                    'country',
                    'payment_method'
                ];
                foreach ($clear as $field) $data[$field] = null;
                if ($room->photo) {
                    Storage::disk('public')->delete($room->photo);
                    $data['photo'] = null;
                }
            }

            $room->update($data);

            return response()->json([
                'success' => true,
                'message' => 'ស្ថានភាពត្រូវបានធ្វើបច្ចុប្បន្នភាព',
                'room' => $room->fresh()
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'កំហុសក្នុងការផ្ទៀងផ្ទាត់ទិន្នន័យ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'មានបញ្ហាកើតឡើង: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Start a booked stay.
     */
    public function startStay(Room $room)
    {
        if ($room->status !== 'booked') {
            return response()->json(['success' => false, 'message' => 'បន្ទប់នេះមិនមែនកក់ទុកទេ'], 400);
        }

        $room->update([
            'status' => 'occupied',
            'check_in_date' => Carbon::now()->toDateString(),
            'check_in_time' => Carbon::now()->format('H:i'),
            'booking_expiry' => null
        ]);

        return response()->json(['success' => true, 'message' => 'ចាប់ផ្តើមស្នាក់នៅដោយជោគជ័យ']);
    }

    /**
     * Cancel a booking.
     */
    public function cancelBooking(Room $room)
    {
        if ($room->status !== 'booked') {
            return response()->json(['success' => false, 'message' => 'បន្ទប់នេះមិនមែនកក់ទុកទេ'], 400);
        }

        $room->update([
            'status' => $room->original_status ?? 'available',
            'guest_name' => null,
            'email' => null,
            'phone' => null,
            'cart_id' => null,
            'deposit' => 0,
            'booking_expiry' => null,
            'original_status' => null,
            'stay_type' => null,
            'check_in_date' => null,
            'check_in_time' => null,
            'check_out_date' => null,
            'check_out_time' => null,
            'number_of_guests' => null,
            'children_count' => null
        ]);

        return response()->json(['success' => true, 'message' => 'ការកក់ត្រូវបានលុបចោល']);
    }

    /**
     * Checkout an occupied room.
     */
    public function checkout(Room $room)
    {
        if ($room->status !== 'occupied') {
            return response()->json(['success' => false, 'message' => 'បន្ទប់នេះមិនមានភ្ញៀវស្នាក់នៅទេ'], 400);
        }

        $overtimeHours = 0;
        if ($room->check_out_time) {
            $checkOut = Carbon::parse($room->check_out_time);
            $now = Carbon::now();
            if ($now->greaterThan($checkOut)) $overtimeHours = $checkOut->diffInHours($now);
        }

        $room->update([
            'status' => 'cleaning',
            'overtime' => $overtimeHours ? 'ម៉ោងលើស: ' . $overtimeHours . ' ម៉ោង' : '0',
            'overtime_hours' => $overtimeHours,
            'guest_name' => null,
            'email' => null,
            'phone' => null,
            'cart_id' => null,
            'deposit' => 0,
            'stay_type' => null,
            'check_in_date' => null,
            'check_in_time' => null,
            'check_out_date' => null,
            'check_out_time' => null,
            'number_of_guests' => null,
            'children_count' => null,
            'gender' => null,
            'age' => null,
            'address' => null,
            'guest_type' => null,
            'id_type' => null,
            'country' => null,
            'payment_method' => null,
            'notes' => null
        ]);

        if ($room->photo) {
            Storage::disk('public')->delete($room->photo);
            $room->photo = null;
            $room->save();
        }

        return response()->json(['success' => true, 'message' => 'Check-out ដោយជោគជ័យ' . ($overtimeHours ? ' (ម៉ោងលើស: ' . $overtimeHours . ' ម៉ោង)' : '')]);
    }

    /**
     * Finish cleaning and mark room as available.
     */
    public function finishCleaning(Room $room)
    {
        if ($room->status !== 'cleaning') return response()->json(['success' => false, 'message' => 'បន្ទប់នេះមិនកំពុងសម្អាតទេ'], 400);

        $room->update(['status' => 'available', 'overtime' => '0', 'overtime_hours' => 0]);

        return response()->json(['success' => true, 'message' => 'បញ្ចប់ការសម្អាតដោយជោគជ័យ']);
    }

    /**
     * Extend an occupied stay.
     */
    public function extendStay(Request $request, Room $room)
    {
        if ($room->status !== 'occupied') return response()->json(['success' => false, 'message' => 'មានតែបន្ទប់ដែលមានភ្ញៀវទេដែលអាចពន្យារពេលបាន'], 400);

        $request->validate([
            'extend_hours' => 'required|integer|min:1|max:24',
            'extend_days' => 'integer|min:0'
        ]);

        $extendHours = $request->extend_hours + ($request->extend_days ?? 0) * 24;

        if ($room->check_out_time) {
            $room->check_out_time = Carbon::parse($room->check_out_time)->addHours($extendHours)->format('H:i');
            if ($request->extend_days) {
                $room->check_out_date = Carbon::parse($room->check_out_date)->addDays($request->extend_days)->toDateString();
            }
        }

        $room->save();

        return response()->json([
            'success' => true,
            'message' => 'ពន្យារពេលស្នាក់នៅ ' . $extendHours . ' ម៉ោង',
            'new_check_out_time' => $room->check_out_time,
            'new_check_out_date' => $room->check_out_date
        ]);
    }
}
