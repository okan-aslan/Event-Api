<?php

namespace App\Repositories;

use App\Models\Venue;

class VenueRepository extends EloquentModelRepository
{
    public function __construct(Venue $model)
    {
        parent::__construct($model);
    }
}
