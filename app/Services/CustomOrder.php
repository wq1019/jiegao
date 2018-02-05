<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\InterfaceTypeable;
use App\Models\Link;
use Illuminate\Support\Collection;

class CustomOrder
{
    public static $modelMapping = [
        'banner' => Banner::class,
        'link'   => Link::class,
    ];

    public function order(Collection $collection)
    {
        $indexOrder = setting($this->getSettingKey($collection->first()));
        if (empty($indexOrder)) {
            return $collection;
        }
        $indexOrder = json_decode($indexOrder, true);
        $count = count($indexOrder);

        return $collection->sortBy(function ($item) use ($indexOrder, $count) {
            $id = $item->getKey();
            if (array_key_exists($id, $indexOrder)) {
                return $indexOrder[$id];
            } else {
                return $count;
            }
        });
    }

    protected function getSettingKey($modelInstance)
    {
        $result = 'custom_order:';
        if ($modelInstance instanceof InterfaceTypeable) {
            $result .= get_class($modelInstance).':type_name:'.$modelInstance->type_name;
        } elseif ($modelInstance != null) {
            $result .= get_class($modelInstance);
        }

        return $result;
    }

    public function setOrder(array $indexOrder, $model)
    {
        if (count($indexOrder) <= 0) {
            return;
        }

        $modelInstance = app(static::$modelMapping[$model])->findOrFail($indexOrder[0]);

        $indexOrder = array_flip(array_values(array_map(function ($id) {
            return intval($id);
        }, $indexOrder)));

        $key = $this->getSettingKey($modelInstance);

        setting([
            $key => [
                'value'     => json_encode($indexOrder),
                'is_system' => true,
                'type_name' => 'system',
            ],
        ]);
    }
}
