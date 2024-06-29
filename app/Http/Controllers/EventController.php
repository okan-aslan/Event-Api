<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Services\EventService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

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

        return $this->success($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        $event = $this->eventService->store($data);

        return $this->success($event, "Event Created Successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = $this->eventService->findOrFail($id);

        return $this->success($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, string $id)
    {
        $data = $request->validated();

        $statement = $this->eventService->update($data, $id);

        if (!$statement) {
            return $this->error(null, "The Event You're Trying To Update is Not Belongs To You !", 401);
        }

        return $this->success(null, "Event Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $statement = $this->eventService->destroy($id);
        if (!$statement) {
            return $this->error(null, "The Event You're Trying To Delete is Not Belongs To You !", 401);
        }
        return $this->success(null, "Event Deleted Successfully");
    }
}
