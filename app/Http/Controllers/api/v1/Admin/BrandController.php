<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Http\Controllers\api\v1\BaseAPI;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\BrandSV;
use Illuminate\Http\Request;

class BrandController extends BaseAPI
{
    /**
     * Display a listing of the resource.
     */
    public $brandService;
    public function __construct(BrandSV $brandService)
    {
        $this->brandService = $brandService;
    }

    // Store Brand
    public function store(StoreBrandRequest $request)
    {
        try {
            $data = $request->validated();
            $brand = $this->brandService->createbrand($data);
            return $this->successResponse($brand, 'Brand created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Get All Brands
    public function index(Request $request)
    {
        $params = [
            'filters' => [],
            'perPage' => $request->input('perPage', 10),
        ];

        if ($request->has('status')) {
            $params['filters']['status'] = $request->input('status');
        }

        $brands = $this->brandService->getAllBrands($params);
        return $this->successResponse($brands, 'Brands retrieved successfully', 200);
    }

    // Get Brand by ID
    public function getBrandById($id)
    {
        try {
            $brand = $this->brandService->getBrandById($id);
            if (!$brand) {
                return $this->errorResponse('Brand not found', 404);
            }
            return $this->successResponse($brand, 'Brand retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Update Brand
    public function updateBrand(UpdateBrandRequest $request, $id)
    {
        try {
            $params = $request->validated();
            $brand = $this->brandService->updateBrand($params, $id);
            return $this->successResponse($brand, 'Brand updated successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Delete Brand
    public function deleteBrand($id)
    {
        try {
            $this->brandService->deleteBrand($id);
            return $this->successResponse(null, 'Brand deleted successfully', 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
