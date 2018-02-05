<?php

namespace App\Repositories;

use App\Models\Link;

class LinkRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Link::class;
    }

    public function preCreate(array &$data)
    {
        $data = $this->filterData($data);
        $data['creator_id'] = auth()->id();

        return $data;
    }

    public function filterData(array &$data)
    {
        if (isset($data['name'])) {
            $data['name'] = e($data['name']);
        }
        if (isset($data['linkman'])) {
            $data['linkman'] = e($data['linkman']);
        }

        return $data;
    }

    public function preUpdate(array &$data)
    {
        return $this->filterData($data);
    }
}
