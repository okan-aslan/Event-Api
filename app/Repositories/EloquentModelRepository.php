<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class EloquentModelRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function find(string $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function update(array $data, string $id): bool
    {
        $model = $this->find($id);

        return $model->update($data);
    }

    public function destroy(string $id): bool|null
    {
        $model = $this->find($id);

        return $model->delete($id);
    }
}