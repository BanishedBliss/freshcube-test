<?php

namespace App\Events\Contact;

use App\Models\HistoryRecord;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreatedEvent implements ContactCreateAttemptInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int      $leadID,
        public string   $name,
        public string   $phone,
        public string   $comment)
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
        $contactFormat = "{
            lead_id:    $this->leadID,
            name:       $this->name,
            phone:      $this->phone,
            comment:    $this->comment
        }";

        HistoryRecord::create([
            'action' => 'contact.create',
            'success' => true,
            'result' => $contactFormat,
            'created_at' => now(),
        ]);
    }
}
