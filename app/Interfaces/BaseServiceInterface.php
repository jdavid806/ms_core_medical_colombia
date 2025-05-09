<?php

namespace App\Interfaces;

interface BaseServiceInterface
{
    public function getAll();
    public function getById($id);
    public function getByColumn($column, $value);
    public function create(array $data);
    public function update($id, array $data);
    public function updateOrCreate(array $data);
    public function delete($id);
    public function active();
    public function activeCount();
}
