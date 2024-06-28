<?php

namespace App\Repositories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Collection;

class VenueRepository
{
    protected $model;

    public function __construct(Venue $model)
    {
        $this->model = $model;
    }

    public function getAllVenues(): Collection
    {
        return $this->model->all();
    }

    public function store(array $data): Venue
    {
        return $this->model->create($data);
    }

    public function findOrFail(string $id): Venue
    {
        return $this->model->findOrFail($id);
    }

    public function update(array $data, string $id): bool
    {
        $model = $this->findOrFail($id);

        return $model->update($data);
    }

    public function destroy(string $id)
    {
        $model = $this->findOrFail($id);

        return $model->delete($id);
    }
}
