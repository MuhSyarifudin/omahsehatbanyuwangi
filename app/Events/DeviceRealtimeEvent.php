<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeviceRealtimeEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $action,
        public array $device = []
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('device-gateway'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'device-gateway-update';
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'device' => $this->device,
            'time' => now()->toDateTimeString(),
        ];
    }
}
