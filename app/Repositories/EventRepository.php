<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Event;

class EventRepository extends EloquentModelRepository
{
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }
}