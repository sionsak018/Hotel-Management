<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewBookingNotification extends Notification
{
    use Queueable;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'ការកក់ទុកថ្មី',
            'message' => 'មានការកក់ទុកថ្មីសម្រាប់បន្ទប់ #' . $this->booking->room->number,
            'type' => 'booking',
            'booking_id' => $this->booking->id,
            'room_number' => $this->booking->room->number,
            'guest_name' => $this->booking->guest->name,
            'time' => now()->toDateTimeString(),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'ការកក់ទុកថ្មី',
            'message' => 'មានការកក់ទុកថ្មីសម្រាប់បន្ទប់ #' . $this->booking->room->number,
            'type' => 'booking',
        ]);
    }
}
