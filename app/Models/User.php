<?php

namespace App\Models;

use App\Models\Traits\Listable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Notifiable, HasRoles, Listable;
    use Authenticatable, Authorizable, CanResetPassword;

    protected static $allowSortFields = ['user_name', 'nick_name', 'created_at', 'locked_at'];
    protected static $allowSearchFields = ['user_name', 'nick_name', 'email'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'nick_name', 'email', 'password', 'avatar', 'locked_at',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $dates = ['locked_at'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isLocked()
    {
        return $this->locked_at != null;
    }
}
