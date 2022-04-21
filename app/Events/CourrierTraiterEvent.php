<?php

namespace App\Events;

use App\Models\Courrier\CrCourrier;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourrierTraiterEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public CrCourrier $courrier;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CrCourrier $courrier)
    {
        $this->courrier = $courrier;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('courrier-' . $this->courrier->id . '-channel');
    }
}
