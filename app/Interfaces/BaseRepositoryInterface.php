<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function all();
    public function find($id);
    public function findByColumn($column, $value);
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function updateOrCreate(array $attributes);
    public function delete($id);
    public function active();
    public function activeCount();
    public function updateModel(Model $model, array $data);
    public function deleteModel(Model $model);
}
