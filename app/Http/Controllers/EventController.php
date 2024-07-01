<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Services\EventService;
use App\Traits\ApiResponses;
use Exception;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    use ApiResponses;

    protected EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = $this->eventService->getAllEvents();

        $events->load('venue');

        return $this->success(EventResource::collection($events));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        $event = $this->eventService->store($data);

        return $this->success(new EventResource($event), "Event Created Successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = $this->eventService->find($id);

        $event->load('venue');

        return $this->success(new EventResource($event));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, string $id): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->eventService->update($data, $id);
            return $this->success(null, "Event updated successfully.");
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->eventService->destroy($id);
            return $this->success(null, "Event deleted successfully.");
        } catch (Exception $e) {
            return $this->error(null, $e->getMessage(), 401);
        }
    }
}
