<?php

namespace App\Repositories;

use App\Models\Banner;

class BannerRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Banner::class;
    }

    public function preCreate(array &$data)
    {
        $this->filterData($data);
        $data['creator_id'] = auth()->id();

        return $data;
    }

    public function filterData(array &$data)
    {
        if (isset($data['title'])) {
            $data['title'] = e($data['title']);
        }

        return $data;
    }

    public function preUpdate(array &$data)
    {
        return $this->filterData($data);
    }
}
