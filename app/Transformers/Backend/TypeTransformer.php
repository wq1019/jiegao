<?php

namespace App\Transformers\Backend;

use App\Models\Type;
use League\Fractal\TransformerAbstract;

class TypeTransformer extends TransformerAbstract
{
    public function transform(Type $type)
    {
        return [
            'id'           => $type->id,
            'name'         => $type->name,
            'display_name' => $type->display_name,
            'description'  => $type->description,
        ];
    }
}
