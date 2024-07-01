<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketType;
use App\Repositories\TicketRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TicketService
{
    protected TicketRepository $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function allTickets(): Collection
    {
        return $this->ticketRepository->allTickets();
    }

    public function showTicket(string $id): TicketType
    {
        return $this->ticketRepository->findTicket($id);
    }

    public function allUserTickets(string $userId): Collection
    {
        try {
            $tickets = $this->ticketRepository->getUserTickets($userId);
            return $tickets;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function showUserTicket(string $id): Ticket
    {
        $ticket = $this->ticketRepository->findUserTicket($id);

        if (!$ticket) {
            throw new \Exception("Ticket not found", 404);
        }

        if ($ticket->user_id !=  Auth::id()) {
            throw new \Exception("Unauthorized access to ticket", 403);
        }

        return $ticket;
    }

    public function store(array $data): Ticket
    {
        try {
            $ticket = $this->ticketRepository->store($data);

            $this->ticketRepository->descraseStock($data['ticket_type_id']);

            return $ticket;
        } catch (\Exception) {
            return throw new Exception("Error occured while buying ticket");
        }
    }

    public function destroy(string $id): bool
    {
        try {
            $ticket = $this->ticketRepository->findUserTicket($id);
            $ticketTypeId = $ticket->ticket_type_id;

            if ($ticket->user_id != auth()->id()) {
                throw new Exception("The ticket you're trying to delete does not belong to you.");
            }

            $this->ticketRepository->destroy($id);

            if ($ticketTypeId) {
                $this->ticketRepository->increaseStock($ticketTypeId);
            }

            return true;
        } catch (Exception) {
            return false;
        }
    }
}
