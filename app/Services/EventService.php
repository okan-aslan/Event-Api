<?php

namespace App\Services;

use App\Repositories\EventRepository;
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
        return $this->eventRepository->getAllEvents();
    }

    public function store(array $data)
    {
        return $this->eventRepository->store($data);
    }

    public function findOrFail(string $id)
    {
        return $this->eventRepository->findOrFail($id);
    }

    public function update(array $data, string $id): bool
    {
        $event = $this->eventRepository->findOrFail($id);
        if ($event->user_id != Auth::user()->id) {
            return false;
        }
        return $this->eventRepository->update($data, $id);
    }

    public function destroy(string $id): bool|null
    {
        $event = $this->eventRepository->findOrFail($id);
        if ($event->user_id != Auth::user()->id) {
            return false;
        }
        return $this->eventRepository->destroy($id);
    }
}
