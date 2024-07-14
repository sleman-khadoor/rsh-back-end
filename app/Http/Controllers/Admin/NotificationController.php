<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;

#[Group('Admin Endpoints')]
#[Subgroup('Notifications', 'APIs for Notifications.')]
class NotificationController extends Controller
{

    public function __construct()
    {
        $this->setResource(NotificationResource::class);
    }



    #[Endpoint('Get all Notifications.')]
    public function index()
    {
        $notifications = Notification::all();

        return $this->collection($notifications);
    }

    #[Endpoint('Get Notifications by service type.')]
    #[UrlParam('type', 'string', 'The type of the service.', true)]
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
