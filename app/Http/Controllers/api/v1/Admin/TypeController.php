<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Services\TypeSV;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Type;
use App\Http\Controllers\api\v1\BaseAPI;
use Illuminate\Http\Request;

class TypeController extends BaseAPI
{
    /*     
        * Display a listing of the resource.
     */
    public $typeService;
    public function __construct(TypeSV $typeService)
    {
        $this->typeService = $typeService;
    }

    // Get all Types
    public function index(Request $request)
    {
        $params = [
            'filters' => [],
            'perPage' => $request->input('perPage', 10),
        ];
        if ($request->has('status')) {
            $params['filters']['status'] = $request->input('status');
        }
        $types = $this->typeService->getAllTypes($params);
        return $this->successResponse($types, 'Types retrieved successfully', 200);
    }

    // Store Type
    public function store(StoreTypeRequest $request)
    {
        try {
            $data = $request->validated();
            $type = $this->typeService->createType($data);
            return $this->successResponse($type, 'Type created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Get Type by ID
    public function getTypeById($id)
    {
        try {
            $type = $this->typeService->getTypeById($id);
            if (!$type) {
                return $this->errorResponse('Type not found', 404);
            }
            return $this->successResponse($type, 'Type retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Update Type
    public function updateType(UpdateTypeRequest $request, $id)
    {
        try {
            $params= $request->validated();
            $type = $this->typeService->updateType($params, $id);
            if (!$type) {
                return $this->errorResponse('Type not found', 404);
            }
            return $this->successResponse($type, 'Type updated successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    // Detele Type
    public function deleteType($id)
    {
        try {
            $type = $this->typeService->deleteType($id);
            if (!$type) {
                return $this->errorResponse('Type not found', 404);
            }
            return $this->successResponse(null, 'Type deleted successfully', 204);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
