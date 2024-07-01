<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Models\TicketType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateTicketTypes
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
    public function handle(EventCreated $event): void
    {
        $eventModel = $event->event;
        $ticketStock = $eventModel->ticket_stock;

        TicketType::create([
            'name' => 'General Admission',
            'description' => 'General ticket for the event',
            'price' => 50.00,
            'stock' => (int) ($ticketStock * 0.8), // %80'i
            'event_id' => $eventModel->id,
        ]);

        TicketType::create([
            'name' => 'VIP Admission',
            'description' => 'VIP ticket for the event',
            'price' => 100.00,
            'stock' => (int) ($ticketStock * 0.2), // %20'si
            'event_id' => $eventModel->id,
        ]);
    }
}
