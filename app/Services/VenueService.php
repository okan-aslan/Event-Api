<?php

namespace App\Services;

use App\Repositories\VenueRepository;
use Illuminate\Database\Eloquent\Collection;

class VenueService
{
    protected $venueRepository;

    public function __construct(VenueRepository $venueRepository)
    {
        $this->venueRepository = $venueRepository;
    }

    public function getAllVenues(): Collection
    {
        return $this->venueRepository->getAllVenues();
    }

    public function store(array $data)
    {
        return $this->venueRepository->store($data);
    }

    public function findOrFail(string $id)
    {
        return $this->venueRepository->findOrFail($id);
    }

    public function update(array $data, string $id): bool
    {
        return $this->venueRepository->update($data, $id);
    }

    public function destroy(string $id)
    {
        return $this->venueRepository->destroy($id);
    }
}