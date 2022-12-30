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

class SlipGajiEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;
    public $description;
    public $read_at;
    public $employee_id;
  
    public function __construct($name, $description,$read_at, $employee_id)
    {
        $this->name         = $name;
        $this->description  = $description;
        $this->read_at      = $read_at;
        $this->employee_id  = $employee_id;

        $notif              = new Notification;
        $notif->name        = $this->name;
        $notif->description = $this->description;
        $notif->read_at     = $this->read_at;
        $notif->employee_id = $this->employee_id;
        $notif->save();

    }

    public function broadcastOn()
    {
       
        return new Channel('notif-karyawan-channel',);
    }

    public function broadcastAs()
    {
        return 'notif-karyawan-event';
    }
}
