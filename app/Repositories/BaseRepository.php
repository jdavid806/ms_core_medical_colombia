<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findByColumn($column, $value)
    {
        return $this->model->whereRaw("lower({$column}) like ?", ['%' . strtolower($value) . '%'])->firstOrFail();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    public function updateOrCreate(array $data)
    {
        return $this->model->updateOrCreate(
            ['id' => $data['id']],
            $data
        );
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    public function active()
    {
        return $this->model->where('is_active', true)->get();
    }

    public function activeCount()
    {
        return $this->model->where('is_active', true)->count();
    }

    public function updateModel(Model $model, array $data)
    {
        $model->fill($data);
        $model->save();
        return $model;
    }


    public function deleteModel(Model $model)
    {
        return $model->delete();
    }
}
