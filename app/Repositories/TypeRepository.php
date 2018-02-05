<?php

namespace App\Repositories;

use App\Models\Type;

class TypeRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Type::class;
    }

    public function preCreate(array &$data)
    {
        $data = $this->filterData($data);
        $data['creator_id'] = auth()->id();

        return $data;
    }

    public function filterData(array &$data)
    {
        if (isset($data['model_name'])) {
            $data['model_name'] = Type::$modelMapWithType[$data['model_name']];
        }

        if (isset($data['display_name'])) {
            $data['display_name'] = e($data['display_name']);
        }

        if (isset($data['description'])) {
            $data['description'] = e($data['description']);
        }

        return $data;
    }

    public function preUpdate(array &$data)
    {
        return $this->filterData($data);
    }
}
