<?php

namespace App\Events\Contact;

use App\Models\HistoryRecord;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateErrorEvent implements ContactCreateAttemptInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public string $error)
    {
        //
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

    public function createHistoryRecord(): void
    {
        HistoryRecord::create([
            'action' => 'contact.create',
            'success' => false,
            'result' => $this->error,
            'created_at' => now(),
        ]);
    }
}
