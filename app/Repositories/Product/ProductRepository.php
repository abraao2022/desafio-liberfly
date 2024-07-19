<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::with('productType')->get();
    }

    public function getById($id)
    {
        return Product::find($id);
    }

    public function create($data)
    {
        return Product::create($data);
    }

    public function update($data, $id)
    {
        return Product::find($id)->update($data);
    }
}
