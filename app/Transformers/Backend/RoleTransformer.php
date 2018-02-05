<?php

namespace App\Transformers\Backend;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Role;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id'           => $role->id,
            'name'         => $role->name,
            'display_name' => $role->display_name,
            'description'  => $role->description,
            'order'        => $role->order,
            'created_at'   => $role->created_at->toDateTimeString(),
            'updated_at'   => $role->updated_at->toDateTimeString(),
        ];
    }
}
