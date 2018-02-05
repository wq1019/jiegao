<?php

namespace App\Repositories;

use App\Exceptions\ResourceException;
use App\Models\User;
use DB;
use Hash;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function create(array $data)
    {
        $this->filterData($data);
        $data['password'] = Hash::make($data['password']);
        $user = null;
        DB::transaction(function () use (&$data, &$user) {
            /** @var User $user */
            $user = $this->model->create($data);
            if (!empty($data['roles'])) {
                try {
                    $user->assignRole($data['roles']);
                } catch (RoleDoesNotExist $e) {
                    throw new ResourceException(null, ['roles' => '所选的角色不存在']);
                }
            }

            if (!empty($data['permissions'])) {
                try {
                    $user->givePermissionTo($data['permissions']);
                } catch (PermissionDoesNotExist $e) {
                    throw new ResourceException(null, ['roles' => '所选的权限不存在']);
                }
            }
        });

        return $user;
    }

    public function filterData(array &$data)
    {
        if (isset($data['nick_name'])) {
            $data['nick_name'] = e($data['nick_name']);
        }

        return $data;
    }

    public function preUpdate(array &$data)
    {
        $this->filterData($data);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }

    public function updated(array &$data, User $user)
    {
        if (!empty($data['roles'])) {
            try {
                $user->syncRoles($data['roles']);
            } catch (RoleDoesNotExist $e) {
                throw new ResourceException(null, ['roles' => '所选的角色不存在']);
            }
        }

        if (!empty($data['permissions'])) {
            try {
                $user->syncPermissions($data['permissions']);
            } catch (PermissionDoesNotExist $e) {
                throw new ResourceException(null, ['roles' => '所选的权限不存在']);
            }
        }
    }
}
