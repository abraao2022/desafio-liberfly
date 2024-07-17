<?php

namespace App\Services\Product;

use App\Repositories\Product\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll()
    {
        return $this->productRepository->getAll();
    }

    public function getById($id)
    {
        return $this->productRepository->getById($id);
    }
}
