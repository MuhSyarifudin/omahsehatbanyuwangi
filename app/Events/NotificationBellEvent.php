<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Queue\SerializesModels;

class NotificationBellEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $count;
    /**
     * Create a new event instance.
     */
    public function __construct($user)
    {

        $this->user = $user->unreadNotifications;
        $this->count = $user->unreadNotifications->count();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('notification-count'),
        ];
    }

     /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'notification-count-update';
    }

}
