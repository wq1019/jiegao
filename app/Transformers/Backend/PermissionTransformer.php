<?php

namespace App\Transformers\Backend;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission)
    {
        return [
            'id'           => $permission->id,
            'name'         => $permission->name,
            'display_name' => $permission->display_name,
            'description'  => $permission->description,
            'parent_id'    => $permission->parent_id,
            'is_menu'      => $permission->is_menu,
            'order'        => $permission->order,
            'created_at'   => $permission->created_at->toDateTimeString(),
            'updated_at'   => $permission->updated_at->toDateTimeString(),
        ];
    }
}
