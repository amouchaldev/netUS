<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Reaction implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $type; // posts or comments
    public $contentId;
    // public $likedBy;
    public $likes_count;
    public function __construct($type, $contentId, $likes_count)
    {
        $this->type = $type;
        // $this->likedContentId = $likedContentId;
        $this->contentId = $contentId;
        // $this->likedBy = $likedBy;
        $this->likes_count = $likes_count;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('public-channel');
    }
    
    public function broadcastAs()
    {
        return 'action';
    }
}
