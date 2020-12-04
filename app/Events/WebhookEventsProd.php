<?php

namespace warehouse\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class WebhookEventsProd implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $webhooks = array();

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($webhooks)
    {
        $this->webhooks = $webhooks;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['live-webhooks-production'];
    }

    public function broadcastAs()
    {
        return 'production-webhooks-event-live';
    }

}