<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVenueRequest;
use App\Http\Requests\UpdateVenueRequest;
use App\Http\Resources\VenueResource;
use App\Services\VenueService;
use App\Traits\ApiResponses;
use Exception;
use Illuminate\Http\JsonResponse;


class VenueController extends Controller
{
    use ApiResponses;

    protected VenueService $venueService;

    public function __construct(VenueService $venueService)
    {
        $this->venueService = $venueService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $venues = $this->venueService->all();

        return $this->success(VenueResource::collection($venues));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVenueRequest $request): JsonResponse
    {
        $data = $request->validated();

        $venue = $this->venueService->store($data);

        return $this->success(new VenueResource($venue), "Venue Created Successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $venue = $this->venueService->find($id);

        return $this->success(new VenueResource($venue));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVenueRequest $request, string $id): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->venueService->update($data, $id);
            return $this->success(null, "Venue updated successfully.");
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->venueService->destroy($id);
            return $this->success(null, "Venue removed successfully.");
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }
}
