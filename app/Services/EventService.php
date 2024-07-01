<?php

namespace App\Services;

use App\Repositories\EventRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class EventService
{
    protected EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getAllEvents(): Collection
    {
        return $this->eventRepository->all();
    }

    public function store(array $data)
    {
        return $this->eventRepository->store($data);
    }

    public function find(string $id)
    {
        return $this->eventRepository->find($id);
    }

    public function update(array $data, string $id): bool
    {
        $event = $this->eventRepository->find($id);
        
        if ($event->user_id != Auth::id()) {
            throw new Exception("The event you're trying to update does not belong to you.");
        }
        
        return $this->eventRepository->update($data, $id);
    }

    public function destroy(string $id): bool
    {
        $event = $this->eventRepository->find($id);
        
        if ($event->user_id != Auth::id()) {
            throw new Exception("The event you're trying to delete does not belong to you.");
        }
        
        return $this->eventRepository->destroy($id);
    }
}
