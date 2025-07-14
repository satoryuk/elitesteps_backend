<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Http\Controllers\api\v1\BaseAPI;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Services\BrandSV;
use Faker\Provider\Base;
use Illuminate\Http\Request;

class BrandController extends BaseAPI
{
    /**
     * Display a listing of the resource.
     */
    public $brandService;
    public function __construct()
    {
        $this->brandService = new BrandSV();
    }

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();
        $brand = $this->brandService->createbrand($data);   
        return $this->successResponse($brand, 'Brand created successfully', 201);
    }
}
