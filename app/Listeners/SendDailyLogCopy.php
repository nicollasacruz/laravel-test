<?php

namespace App\Listeners;

use App\Mail\DailyLogCopy;
use App\Events\DailyLogCreated;
use Illuminate\Support\Facades\Mail;

class SendDailyLogCopy
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DailyLogCreated $event): void
    {
        Mail::to($event->dailyLog->user->email)->send(new DailyLogCopy($event->dailyLog));
    }
}
