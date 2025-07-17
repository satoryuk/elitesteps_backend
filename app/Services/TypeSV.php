<?php

namespace App\Services;

use App\Models\Type;
use Exception;
use App\Services\BaseService;

class TypeSV extends BaseService
{
    protected function getQuery()
    {
        return Type::query()->with('category');
    }

    // Get all types
    public function getAllTypes($params)
    {
        $query = $this->getQuery();
        return $this->getAll($query, $params);
    }

    // Store a new type
    public function createType($data)
    {
        try {
            $query = $this->getQuery();
            $type = $query->create([
                'type_name' => $data['type_name'],
                'category_id' => $data['category_id'],
            ]);
            return $type;
        } catch (Exception $e) {
            throw new Exception('Error creating type: ' . $e->getMessage(), 500);
        }
    }

    // Get a type by ID
    public function getTypeById($id)
    {
        $query = $this->getQuery();
        $type = $query->where('type_id', $id)->first();
        return $type;
    }

    // Update a type
    public function updateType($data, $id)
    {
        try {
            $query = $this->getQuery();
            $type = $query->where('type_id', $id)->first();
            if (!$type) {
                throw new Exception('Type not found', 404);
            }
            $type->update($data);
            return $type;
        } catch (Exception $e) {
            throw new Exception('Error updating type: ' . $e->getMessage(), 500);
        }
    }

    // Delete a type
    public function deleteType($id)
    {
        try {
            $query = $this->getQuery();
            $type = $query->where('type_id', $id)->first();
            if (!$type) {
                throw new Exception('Type not found', 404);
            }
            $type->delete();
            return true;
        } catch (Exception $e) {
            throw new Exception('Error deleting type: ' . $e->getMessage(), 500);
        }
    }
}