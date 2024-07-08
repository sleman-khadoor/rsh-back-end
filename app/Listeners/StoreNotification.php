<?php

namespace App\Listeners;

use App\Events\NewRequestStored;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreNotification
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
    public function handle(NewRequestStored $event): void
    {
        Notification::firstOrCreate(['type' => $event->requestType], ['count' => 0])->increment('count');
    }
}
