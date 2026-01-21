<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Guest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $bookedRooms = Room::where('status', 'booked')->count();
        $cleaningRooms = Room::where('status', 'cleaning')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        $currentGuests = Room::whereIn('status', ['occupied', 'booked'])
            ->whereNotNull('guest_name')
            ->orderBy('check_in_date', 'desc')
            ->get();

        // ADD THIS LINE - Get all rooms for the grid
        $rooms = Room::orderBy('floor')->orderBy('number')->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'occupiedRooms',
            'availableRooms',
            'bookedRooms',
            'cleaningRooms',
            'maintenanceRooms',
            'currentGuests',
            'rooms' // ADD THIS - pass rooms to view
        ));
    }

    public function rooms()
    {
        $rooms = Room::orderBy('floor')->orderBy('number')->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function guests()
    {
        $guests = Guest::with(['bookings'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.guests.index', compact('guests'));
    }
}
