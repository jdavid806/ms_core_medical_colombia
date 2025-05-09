<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VaccineSyncEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vaccineData;

    /**
     * Create a new event instance.
     */
    public function __construct(array $vaccineData)
    {
        Log::info('Trying syncing', ['vaccineData' => $vaccineData]);
        $this->vaccineData = [$vaccineData];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
