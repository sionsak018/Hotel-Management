<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiController extends Controller
{
    // ------------------------
    // Room APIs
    // ------------------------
    public function getRoom(Room $room)
    {
        return response()->json([
            'success' => true,
            'data' => $room->load('currentBooking')
        ]);
    }

    public function updateRoomStatus(Request $request, Room $room)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,booked,cleaning,maintenance',
            'guest_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'deposit' => 'nullable|numeric|min:0',
            'stay_type' => 'nullable|in:ម៉ោង,យប់,ខែ',
        ]);

        $room->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'ស្ថានភាពបន្ទប់ត្រូវបានធ្វើបច្ចុប្បន្នភាព',
            'data' => $room
        ]);
    }

    public function getAvailableRooms()
    {
        $rooms = Room::where('status', 'available')
            ->orderBy('floor')
            ->orderBy('number')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $rooms
        ]);
    }

    // ------------------------
    // Guest APIs
    // ------------------------
    public function getGuest(Guest $guest)
    {
        return response()->json([
            'success' => true,
            'data' => $guest->load(['bookings' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(5);
            }])
        ]);
    }

    public function searchGuests(Request $request)
    {
        $query = $request->get('q');

        $guests = Guest::where('name', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->orWhere('id_card_number', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $guests
        ]);
    }

    // ------------------------
    // Booking APIs
    // ------------------------
    public function checkIn(Booking $booking)
    {
        if ($booking->status !== 'confirmed') {
            return response()->json([
                'success' => false,
                'message' => 'ការកក់ទុកនេះមិនអាចចូលស្នាក់នៅបានទេ'
            ], 400);
        }

        $booking->update([
            'status' => 'checked_in',
            'check_in_date' => now(),
            'check_in_time' => now()->format('H:i'),
        ]);

        $booking->room->update(['status' => 'occupied']);

        return response()->json([
            'success' => true,
            'message' => 'ភ្ញៀវបានចូលស្នាក់នៅដោយជោគជ័យ'
        ]);
    }

    public function checkOut(Booking $booking)
    {
        if ($booking->status !== 'checked_in') {
            return response()->json([
                'success' => false,
                'message' => 'ការកក់ទុកនេះមិនអាចចាកចេញបានទេ'
            ], 400);
        }

        $booking->update([
            'status' => 'checked_out',
            'check_out_date' => now(),
            'check_out_time' => now()->format('H:i'),
        ]);

        $booking->room->update(['status' => 'cleaning']);

        return response()->json([
            'success' => true,
            'message' => 'ភ្ញៀវបានចាកចេញដោយជោគជ័យ'
        ]);
    }

    // ------------------------
    // Dashboard APIs
    // ------------------------
    public function getDashboardStats()
    {
        $stats = [
            'total_rooms' => Room::count(),
            'occupied_rooms' => Room::where('status', 'occupied')->count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'booked_rooms' => Room::where('status', 'booked')->count(),
            'today_revenue' => Booking::whereDate('created_at', today())
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount'),
            'month_revenue' => Booking::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount'),
            'total_guests' => Guest::count(),
            'today_checkins' => Booking::whereDate('check_in_date', today())
                ->where('status', 'checked_in')
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    public function getRecentActivities()
    {
        $activities = Booking::with(['room', 'guest'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $activities
        ]);
    }

    // ------------------------
    // Notification APIs
    // ------------------------
    public function getNotifications()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $notifications = $user->notifications()->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $notifications,
        ]);
    }

    public function getUnreadNotificationCount()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $count = $user->unreadNotifications()->count();

        return response()->json([
            'success' => true,
            'data' => ['unread_count' => $count],
        ]);
    }

    public function markNotificationAsRead($notificationId)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $notification = $user->notifications()->where('id', $notificationId)->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found',
            ], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
        ]);
    }

    public function markAllNotificationsAsRead()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $user->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
        ]);
    }
}
