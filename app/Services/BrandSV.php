<?php

namespace App\Services;

use App\Models\Brand;
use Exception;
use App\Services\BaseService;
class BrandSV extends BaseService
{
    public function getQuery()
    {
        return Brand::query();
    }

    // Get all brands
    public function getAllBrands($params)
    {
        $query = $this->getQuery();

        return $this->getAll($query, $params);
    }

    // Create a new brand
    public function createbrand($data){
       try {
            $query = $this->getQuery();

            $brand = $query->create([
                'brand_name'     => $data['brand_name'],
                'description'   => $data['description'],
                'logo'          => $data['logo'],
            ]);
            return $brand;
        } catch (\Exception $e) {
            throw new \Exception('Error creating brand: ' . $e->getMessage());
        }
    }

    // Get brand by ID
    public function getBrandById($id)
    {
        $query =  $this->getQuery();
        $brand = $query->where('brand_id', $id)->first();
        return $brand;
    }

    // Update brand
    public function updateBrand($data, $id){
       try {
            $query = $this->getQuery();
            $brand = $query->where('brand_id', $id)->first();
            if (!$brand) {
                throw new \Exception('Brand not found', 404);
            }
           $brand->update($data);
            return $brand;
        } catch (\Exception $e) {
            throw new \Exception('Error updating brand: ' . $e->getMessage(), 500);
        }
    }

    // Delete brand
    public function deleteBrand($id)
    {
        try {
            $query = $this->getQuery();
            $brand = $query->where('brand_id', $id)->first();
            if (!$brand) {
                throw new \Exception('Brand not found', 404);
            }
            $brand->delete();
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Error deleting brand: ' . $e->getMessage(), 500);
        }
    }
}