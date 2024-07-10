<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->setResource(NotificationResource::class);
    }


    public function index()
    {
        $notifications = Notification::all();

        return $this->collection($notifications);
    }

    public function getByType(string $type) {

        $notification = Notification::where('type', $type)->firstOrFail();

        $notification->count = 0;

        /*
            Hold an instance of the notification object
            that has the real count value before setting it to 0.
        */
        $cleanNotification = $notification->fresh();

        $notification->save();

        return $this->resource($cleanNotification);
    }
}
