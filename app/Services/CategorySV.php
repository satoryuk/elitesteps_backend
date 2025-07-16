<?php

namespace App\Services;

use App\Models\Category;
use Exception;
use App\Services\BaseService;
class CategorySV extends BaseService
{
    public function getQuery()
    {
        return Category::query();
    }

    // Get all categories
    public function getAllCategorys($params)
    {
        $query = $this->getQuery();

        return $this->getAll($query, $params);
    }

    // Create a new category
    public function createCategory($data){
       try {
            $query = $this->getQuery(); 
            $category = $query->create([
                'category_name'     => $data['category_name'],
                'description'   => $data['description'],
            ]);
            return $category;
        } catch (\Exception $e) {
            throw new \Exception('Error creating category: ' . $e->getMessage());
        }
    }

    // Get category by ID
    public function getCategoryById($id)
    {
        $query =  $this->getQuery();
        $category = $query->where('category_id', $id)->first();
        return $category;
    }

    // Update category
    public function updateCategory($data, $id){
       try {
            $query = $this->getQuery();
            $category = $query ->where('category_id', $id)->first();
            if (!$category) {
                throw new \Exception('Category', 404);
            }
           $category->update($data);
            return $category;
        } catch (\Exception $e) {
            throw new \Exception('Error updating Category: ' . $e->getMessage(), 500);
        }
    }

    // Delete category
    public function deleteCategory($id){
        try {
            $query = $this->getQuery();
            $category = $query->where('category_id', $id)->first();
            if (!$category) {
                throw new \Exception('Category not found', 404);
            }
            $category->delete();
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Error deleting category: ' . $e->getMessage(), 500);
        }
    }
}