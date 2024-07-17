<?php

namespace App\Http\Controllers;

use App\Services\Product\ProductService;

/**
 * @OA\Info(
 *     title="API de Produtos",
 *     version="1.0.0",
 *     description="API para gerenciar produtos"
 * )
 */

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @OA\Get(
     *      path="/api/products",
     *      operationId="getProductsList",
     *      tags={"Products"},
     *      summary="Get list of products",
     *      description="Returns list of products",
     *      security={{"apiAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example="1"),
     *                  @OA\Property(property="name", type="string", example="Product Name"),
     *                  @OA\Property(property="description", type="string", example="Product Description"),
     *                  @OA\Property(property="price", type="number", format="float", example="19.99"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      )
     * )
     */
    public function index()
    {
        return response()->json($this->productService->getAll());
    }

    /**
     * @OA\Get(
     *      path="/api/products/{id}",
     *      operationId="getProductById",
     *      tags={"Products"},
     *      summary="Get product by ID",
     *      description="Returns a single product",
     *      security={{"apiAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the product to retrieve",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="Product Name"),
     *              @OA\Property(property="description", type="string", example="Product Description"),
     *              @OA\Property(property="price", type="number", format="float", example="19.99"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Product not found"
     *      )
     * )
     */
    public function show($id)
    {
        $product = $this->productService->getById($id);
        if ($product) {
            return response()->json($product);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }
}
