<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Notification;

class IzinEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $name;
    public $description;
    public $admin;
    public function __construct($name, $description,$admin)
    {
        $this->name = $name;
        $this->description = $description;
        $this->admin = $admin;

        $notif              = new Notification;
        $notif->name        = $this->name;
        $notif->description = $this->description;
        $notif->user_id     = $this->admin;
        $notif->save();

    }

    public function broadcastOn()
    {
       
        return new Channel('notif-channel');
    }

    public function broadcastAs()
    {
        return 'notif-event';
    }
}
