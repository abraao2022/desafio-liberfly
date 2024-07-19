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
}
