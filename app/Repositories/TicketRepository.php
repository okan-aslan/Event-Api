<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Models\TicketType;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository extends EloquentModelRepository
{
    protected $ticketType;

    public function __construct(Ticket $model, TicketType $ticketType)
    {
        parent::__construct($model);
        $this->ticketType = $ticketType;
    }

    public function allTickets(): Collection
    {
        return $this->ticketType->all();
    }

    public function findTicket(string $id): TicketType
    {
        return $this->ticketType->findOrFail($id);
    }

    public function getUserTickets(string $userId): Collection
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function findUserTicket(string $id): Ticket
    {
        return $this->model->findOrFail($id);
    }

    public function descraseStock(int $id)
    {
        $ticketType = $this->findTicket($id);

        if($ticketType->stock <= 0)
        {
            return throw new Exception("Unfortunately, the type of ticket you want to purchase is out of stock.");
        }

        $ticketType->decrement('stock');
        
        return $ticketType->stock;  
    }

    public function increaseStock(int $id)
    {
        $ticketType = $this->findTicket($id);
        return $ticketType->increment('stock');
    }
}