<?php

namespace App\Listeners\HistoryRecords\Contact;

use App\Events\Contact\ContactCreateAttemptInterface;

class CreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContactCreateAttemptInterface $event): void
    {
        $event->createHistoryRecord();
    }
}
