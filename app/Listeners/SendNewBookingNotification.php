<?php

namespace App\Listeners;

use App\Events\NewBookingCreated;
use App\Notifications\NewBookingNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewBookingNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(NewBookingCreated $event)
    {
        // Notify all admins and receptionists
        $users = \App\Models\User::whereIn('role', ['admin', 'receptionist'])->get();

        foreach ($users as $user) {
            $user->notify(new NewBookingNotification($event->booking));
        }
    }
}
