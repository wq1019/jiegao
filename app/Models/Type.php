<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Type extends BaseModel
{
    public static $modelMapWithType = [
        'link'    => Link::class,
        'banner'  => Banner::class,
        'setting' => Setting::class,
    ];
    protected $fillable = ['name', 'display_name', 'description', 'model_name', 'creator_id'];

    public function scopeByModel(Builder $query, $model)
    {
        if (isset(self::$modelMapWithType[$model])) {
            return $query->where('model_name', self::$modelMapWithType[$model]);
        } else {
            return $query->whereNull('model_name');
        }
    }

    public function __call($method, $args)
    {
        $mapKey = substr($method, 0, -1);
        if (isset(self::$modelMapWithType[$mapKey])) {
            return $this->hasMany(self::$modelMapWithType[$mapKey]);
        } else {
            return parent::__call($method, $args);
        }
    }
}
