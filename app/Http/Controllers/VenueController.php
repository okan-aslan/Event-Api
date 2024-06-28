<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVenueRequest;
use App\Http\Requests\UpdateVenueRequest;
use App\Services\VenueService;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;


class VenueController extends Controller
{
    use ApiResponses;

    protected $venueService;

    public function __construct(VenueService $venueService)
    {
        $this->venueService = $venueService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $venues = $this->venueService->getAllVenues();

        return $this->success($venues);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVenueRequest $request): JsonResponse
    {
        $data = $request->validated();

        $venue = $this->venueService->store($data);

        return $this->success($venue, "Venue Created Successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $venue = $this->venueService->findOrFail($id);

        return $this->success($venue);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVenueRequest $request, string $id): JsonResponse
    {
        $data = $request->validated();

        $this->venueService->update($data, $id);

        return $this->success(null, "Venue Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->venueService->destroy($id);
            return $this->success(null, "Venue deleted successfully");
        } catch (\Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }
}
