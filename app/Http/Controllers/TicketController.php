<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Services\TicketService;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
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
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $tickets = $this->ticketService->allUserTickets($userId);

        $tickets->load(['user', 'ticketType.event']);

        return $this->success(TicketResource::collection($tickets));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticket_type_id' => ['required', 'exists:ticket_types,id'],
        ]);

        $validated['user_id'] = $request->user()->id;

        $ticket = $this->ticketService->store($validated);

        $ticket->load(['user', 'ticketType.event']);

        return $this->success(new TicketResource($ticket), "The ticket has been purchased successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = $this->ticketService->showUserTicket($id);

        $ticket->load(['user', 'ticketType.event']);

        return $this->success(new TicketResource($ticket));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->ticketService->destroy($id);

        if (!$result) {
            return $this->error(null, "Something went wrong while deleting ticket", 500);
        }

        return $this->success(null, "The ticket removed successfully");
    }
}
