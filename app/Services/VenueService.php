<?php

namespace App\Services;

use App\Models\Venue;
use App\Repositories\EloquentModelRepository;
use App\Repositories\VenueRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class VenueService
{
    protected VenueRepository $venueRepository;

    public function __construct(VenueRepository $venueRepository)
    {
        $this->venueRepository = $venueRepository;
    }

    public function all(): Collection
    {
        return $this->venueRepository->all();
    }

    public function store(array $data): Venue
    {
        return $this->venueRepository->store($data);
    }

    public function find(string $id): Venue
    {
        return $this->venueRepository->find($id);
    }

    public function update(array $data, string $id): void
    {
        $result = $this->venueRepository->update($data, $id);

        if (!$result) {
            throw new Exception("Error occurred while updating venue.");
        }
    }

    public function destroy(string $id): void
    {
        try {
            $this->venueRepository->destroy($id);
        } catch (Exception $e) {
            throw new Exception("Error occurred while deleting venue");
        }
    }
}
