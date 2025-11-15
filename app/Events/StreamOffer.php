<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\OfferedStream;

class StreamOffer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // stream offer can broadcast on a private channel
        return  new PrivateChannel('stream-signal-channel.' . $this->data['receiver']['id']);
    }
    
    public function broadcastWith()
    {
        $offered_stream_id = $this->saveOfferedStream();
        return ['id' => $offered_stream_id];
    }
    
    public function saveOfferedStream()
    {
        $stream = new OfferedStream();
        $stream->offer_data = $this->data;
        $stream->save();
        
        return $stream->id;
    }
}
