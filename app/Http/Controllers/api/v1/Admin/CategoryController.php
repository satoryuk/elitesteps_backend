<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Services\CategorySV;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Http\Controllers\api\v1\BaseAPI;
use Faker\Provider\Base;
use Illuminate\Http\Request;

class CategoryController extends BaseAPI
{
    /*
     * Display a listing of the resource.
    */
    public $categoryService;
    public function __construct(CategorySV $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // Store Category
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $params = $this->categoryService->createCategory($data);
            return $this->successResponse($params, 'Category created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Get All Categories
    public function index(Request $request)
    {
        $params = [
            'filters' => [],
            'perPage' => $request->input('perPage', 10),
        ];
        if ($request->has('status')) {
            $params['filters']['status'] = $request->input('status');
        }
        $categories = $this->categoryService->getAllCategorys($params);
        return $this->successResponse($categories, 'Categories retrieved successfully', 200);
    }

    // Get Category by ID
    public function getCategoryById($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            if (!$category) {
                return $this->errorResponse('Category not found', 404);
            } 
            return $this->successResponse($category, 'Category retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        } 
    }

    // Update Category
    public function updateCategory(UpdateCategoryRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $category = $this->categoryService->updateCategory($data, $id);
            return $this->successResponse($category, 'Category updated successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Delete Category
    public function deleteCategory($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return $this->successResponse(null, 'Category deleted successfully', 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    } 
}
