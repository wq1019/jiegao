<?php

namespace App\Repositories;

use App\Exceptions\ResourceException;
use App\Models\Role;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

class RoleRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    public function preCreate(array &$data)
    {
        return $this->filterData($data);
    }

    public function filterData(array &$data)
    {
        if (isset($data['display_name'])) {
            $data['display_name'] = e($data['display_name']);
        }
        if (isset($data['description'])) {
            $data['description'] = e($data['description']);
        }

        return $data;
    }

    public function created(&$data, Role $role)
    {
        if (!empty($data['permissions'])) {
            try {
                $role->givePermissionTo($data['permissions']);
            } catch (PermissionDoesNotExist $e) {
                throw new ResourceException(null, ['roles' => '所选的权限不存在']);
            }
        }
    }

    public function preUpdate(array &$data)
    {
        return $this->filterData($data);
    }

    public function updated(&$data, Role $role)
    {
        if (!empty($data['permissions'])) {
            try {
                $role->syncPermissions($data['permissions']);
            } catch (PermissionDoesNotExist $e) {
                throw new ResourceException(null, ['roles' => '所选的权限不存在']);
            }
        }
    }
}
