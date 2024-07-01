<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketTypeResource;
use App\Models\TicketType;
use App\Repositories\TicketRepository;
use App\Services\TicketService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class TicketTypeContoller extends Controller
{
    use ApiResponses;

    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = $this->ticketService->allTickets();

        $tickets->load('event');

        return $this->success(TicketTypeResource::collection($tickets));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = $this->ticketService->showTicket($id);

        $ticket->load('event');

        return $this->success(new TicketTypeResource($ticket));
    }
}
