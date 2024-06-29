<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Event;

class EventRepository
{
    protected Event $model;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function getAllEvents(): Collection
    {
        return $this->model->all();
    }

    public function store(array $data): Event
    {
        return $this->model->create($data);
    }

    public function findOrFail(string $id): Event
    {
        return $this->model->findOrFail($id);
    }

    public function update(array $data, string $id): bool
    {
        $model = $this->findOrFail($id);

        return $model->update($data);
    }

    public function destroy(string $id): bool|null
    {
        $model = $this->findOrFail($id);

        return $model->delete($id);
    }
}