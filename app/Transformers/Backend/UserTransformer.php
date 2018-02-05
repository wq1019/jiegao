<?php

namespace App\Transformers\Backend;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['roles', 'permissions'];

    public function transform(User $user)
    {
        return [
            'id'         => $user->id,
            'user_name'  => $user->user_name,
            'nick_name'  => $user->nick_name,
            'email'      => $user->email,
            'locked_at'  => is_null($user->locked_at) ? null : $user->locked_at->toDateTimeString(),
            'avatar'     => $user->avatar,
            'avatar_url' => image_url($user->avatar, null, cdn('images/default_avatar.jpg')),
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
    }

    public function includeRoles(User $user)
    {
        $roles = $user->roles;

        return $this->collection($roles, new RoleTransformer());
    }

    public function includePermissions(User $user)
    {
        $permissions = $user->permissions;

        return $this->collection($permissions, new PermissionTransformer());
    }
}
