<?php

namespace App\Services;

use Exception;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseService
{
    protected function getLimit(Builder $query, int $limit)
    {
        return isset($limit) && $limit != -1 ? $query->paginate($limit) : $query->get();
    }

    public function create(array $params = array())
    {
        $query = $this->getQuery();

        if (isset($query)) {
            $data = $query->create($params);
            return $data;
        } else {
            throw new Exception('Query not found');
        }
    }

    /**
     * Update a record by ID
     * 
     * @param array $params Array of fields to update
     * @param int $id The ID of the record to update
     * @return int The ID of the updated record
     * @throws Exception If record or query not found
     */
    public function update(array $params = [], int $id = null)
    {
        $query = $this->getQuery();

        if (!$query) {
            throw new Exception('Query not found');
        }

        $data = $query->find($id);

        if (!$data) {
            throw new Exception("Record with ID {$id} not found in model " . get_class($query->getModel()));
        }

        $data->update($params);
        return $data->id;
    }

    /**
     * Get a record by ID
     * 
     * @param int $id The ID of the record to find
     * @param \Illuminate\Database\Query\Builder|null $query Optional query builder
     * @return int The ID of the found record
     * @throws Exception If record or query not found
     */
    public function getById(int $id, $query = null)
    {
        $query = $query ?? $this->getQuery();

        if (!$query) {
            throw new Exception('Query not found');
        }

        $data = $query->find($id);

        if (!$data) {
            throw new Exception("Record with ID {$id} not found in " . get_class($query->getModel()));
        }

        return $data->id;
    }

    public function getAll($query, $params)
    {
        // Apply filters
        if (!empty($params['filterBy'])) {
            foreach ($params['filterBy'] as $column => $value) {
                $query->where($column, $value);
            }
        }

        // Handle pagination
        $perPage = $params['perPage'] ?? 10;
        return $query->paginate($perPage);
    }

    // Get id by global_id
    public function getIdByGlobalId($modelName, $global_id)
    {
        $model = new $modelName();
        $query = $model->getQuery();

        if (isset($query)) {
            $data = $query->where('global_id', $global_id)->first();

            $dataId = $data ? $data->id : null;
            return $dataId;
        } else {
            throw new Exception('Query not found');
        }
    }

    // Activate and Deactivate a record
    public function activate($global_id, $query)
    {

        if (isset($query)) {
            $data = $query->where('global_id', $global_id)->first();
            $data->update([
                'is_active' => !$data->is_active
            ]);
            return $data;
        } else {
            throw new Exception('Query not found.');
        }
    }

    protected function getQuery()
    {
        return null;
    }
}
