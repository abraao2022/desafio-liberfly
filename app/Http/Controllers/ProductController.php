<?php

namespace App\Http\Controllers;

use App\Services\Product\ProductService;
use App\Validators\ProductValidator;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API de Produtos",
 *     version="1.0.0",
 *     description="API para gerenciar produtos"
 * )
 */

class ProductController extends Controller
{
    protected $productService, $productValidator;

    public function __construct(ProductService $productService, ProductValidator $productValidator)
    {
        $this->productService = $productService;
        $this->productValidator = $productValidator;
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

    /**
     * @OA\Post(
     *      path="/api/products",
     *      operationId="createProduct",
     *      tags={"Products"},
     *      summary="Create a new product",
     *      description="Creates a new product",
     *      security={{"apiAuth": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Product Name"),
     *              @OA\Property(property="description", type="string", example="Product Description"),
     *              @OA\Property(property="price", type="number", format="float", example="19.99"),
     *              @OA\Property(property="product_type_id", type="number", format="integer", example="1"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="name", type="string", example="Product Name"),
     *              @OA\Property(property="description", type="string", example="Product Description"),
     *              @OA\Property(property="price", type="number", format="float", example="19.99"),
     *              @OA\Property(property="product_type_id", type="number", format="integer", example="1"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     */
    public function store(Request $request)
    {
        // Valida os dados
        $validation = $this->productValidator->validateCreate($request->all());

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        // Cria o produto
        $product = $this->productService->create($request->all());

        return response()->json($product, 201);
    }

    /**
     * @OA\Put(
     *      path="/api/products/{id}",
     *      operationId="updateProduct",
     *      tags={"Products"},
     *      summary="Update an existing product",
     *      description="Updates an existing product",
     *      security={{"apiAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the product to update",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Product Name"),
     *              @OA\Property(property="description", type="string", example="Product Description"),
     *              @OA\Property(property="price", type="number", format="float", example="19.99"),
     *              @OA\Property(property="product_type_id", type="number", format="integer", example="1"),
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
     *              @OA\Property(property="product_type_id", type="number", format="integer", example="1"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Product not found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        // Valida os dados
        $validation = $this->productValidator->validateUpdate($request->all());

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        // Atualiza o produto
        $product = $this->productService->update($request->all(), $id);

        // Retorna o produto atualizado
        return response()->json($product, 200); // Certifique-se de que $product inclui todos os campos esperados
    }
}
