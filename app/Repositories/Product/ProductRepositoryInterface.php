<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function create($data);
    public function update($data, $id);
}
