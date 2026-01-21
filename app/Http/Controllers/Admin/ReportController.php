<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // <-- Add this line

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = $request->get('date_range', 'today');

        switch ($dateRange) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::today();
                break;
            case 'yesterday':
                $startDate = Carbon::yesterday();
                $endDate = Carbon::yesterday();
                break;
            case 'this_week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'last_week':
                $startDate = Carbon::now()->subWeek()->startOfWeek();
                $endDate = Carbon::now()->subWeek()->endOfWeek();
                break;
            case 'this_month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'last_month':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            default:
                $startDate = Carbon::parse($request->get('start_date', Carbon::today()));
                $endDate = Carbon::parse($request->get('end_date', Carbon::today()));
                break;
        }

        // Revenue Report
        $revenue = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $deposits = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->sum('deposit');

        // Occupancy Report
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $occupancyRate = $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0;

        // Guest Statistics
        $newGuests = Guest::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalGuests = Guest::count();

        // Top Rooms
        $topRooms = Booking::selectRaw('room_id, count(*) as booking_count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->groupBy('room_id')
            ->orderByDesc('booking_count')
            ->limit(5)
            ->with('room')
            ->get();

        // Booking Status Summary
        $bookingStatus = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        return view('admin.reports.index', compact(
            'revenue',
            'deposits',
            'totalRooms',
            'occupiedRooms',
            'occupancyRate',
            'newGuests',
            'totalGuests',
            'topRooms',
            'bookingStatus',
            'startDate',
            'endDate',
            'dateRange'
        ));
    }

    public function financial()
    {
        $transactions = Transaction::with(['booking', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $totalIncome = Transaction::where('type', 'payment')->sum('amount');
        $totalDeposits = Transaction::where('type', 'deposit')->sum('amount');
        $totalRefunds = Transaction::where('type', 'refund')->sum('amount');

        return view('admin.reports.financial', compact(
            'transactions',
            'totalIncome',
            'totalDeposits',
            'totalRefunds'
        ));
    }

    public function occupancy()
    {
        $rooms = Room::with(['currentBooking', 'bookings'])
            ->orderBy('floor')
            ->orderBy('number')
            ->get();

        $totalRooms = $rooms->count(); // define total rooms

        $monthlyOccupancy = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $occupiedDays = Booking::whereBetween('check_in_date', [$monthStart, $monthEnd])
                ->where('status', '!=', 'cancelled')
                ->sum(DB::raw('DATEDIFF(COALESCE(check_out_date, NOW()), check_in_date) + 1'));

            $totalDays = $totalRooms * $month->daysInMonth;
            $rate = $totalDays > 0 ? ($occupiedDays / $totalDays) * 100 : 0;

            $monthlyOccupancy[] = [
                'month' => $month->format('M Y'),
                'rate' => round($rate, 1)
            ];
        }

        return view('admin.reports.occupancy', compact('rooms', 'monthlyOccupancy'));
    }


    public function export(Request $request)
    {
        $type = $request->get('type', 'revenue');
        $format = $request->get('format', 'pdf');

        // Here you would implement export logic using libraries like:
        // - Maatwebsite/Laravel-Excel for Excel exports
        // - Barryvdh/laravel-dompdf for PDF exports

        return back()->with('success', 'របាយការណ៍ត្រូវបានបញ្ចេញដោយជោគជ័យ!');
    }
}
