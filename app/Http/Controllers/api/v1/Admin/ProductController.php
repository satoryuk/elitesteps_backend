<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Services\ProductSV;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Http\Controllers\api\v1\BaseAPI;
use Illuminate\Http\Request;

class ProductController extends BaseAPI
{
    /*     
        * Display a listing of the resource.
    */
    public $productService;
    public function __construct(ProductSV $productService)
    {
        $this->productService = $productService;
    }

    // Get all Products
    public function index(Request $request)
    {
        $params = [
            'filters' => [],
            'perPage' => $request->input('perPage', 10),
        ];
        if ($request->has('status')) {
            $params['filters']['status'] = $request->input('status');
        }
        $products = $this->productService->getAllProducts($params);
        return $this->successResponse($products, 'Products retrieved successfully', 200);
    }

    // Store Product
    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();
            $product = $this->productService->createProduct($data);
            return $this->successResponse($product, 'Product created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Get Product by ID
    public function getProductById($id)
    {
        try {
            $product = $this->productService->getProductById($id);
            if (!$product) {
                return $this->errorResponse('Product not found', 404);
            }
            return $this->successResponse($product, 'Product retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Update Product
    public function updateProduct(UpdateProductRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $product = $this->productService->updateProduct($data, $id);
            return $this->successResponse($product, 'Product updated successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Deactivate Product
    public function deactivateProduct($id)
    {
        try {
            $product = $this->productService->deactivateProduct($id);
            if (!$product) {
                return $this->errorResponse('Product not found', 404);
            }
            return $this->successResponse($product, 'Product deactivated successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Delete Product
    public function deleteProduct($id)
    {
        try {
            $this->productService->deleteProduct($id);
            return $this->successResponse(null, 'Product deleted successfully', 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
