<?php

namespace App\Events;

use App\Models\Courrier\CrCourrier;
use App\Models\Courrier\CrReaffectation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourrierTranfererEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public CrReaffectation $reaffectation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CrReaffectation $reaffectation)
    {
        $this->reaffectation = $reaffectation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('courrier-' . $this->reaffectation->cr_courrier->id . '-channel');
    }
}
