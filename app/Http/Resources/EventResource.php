<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'dateTime' => $this->date_time,
            'ticketStock' => $this->ticket_stock,
            'venue' => new VenueResource($this->whenLoaded('venue')), 
        ];  
    }
}
