<?php

namespace App\Transformers\Backend;

use App\Models\Link;
use League\Fractal\TransformerAbstract;

class LinkTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['type'];

    public function transform(Link $link)
    {
        return [
            'id'         => $link->id,
            'name'       => $link->name,
            'url'        => $link->url,
            'logo'       => $link->logo,
            'logo_url'   => image_url($link->logo),
            'linkman'    => $link->linkman,
            'type_name'  => $link->type_name,
            'is_visible' => $link->is_visible,
            'created_at' => $link->created_at->toDateTimeString(),
            'updated_at' => $link->updated_at->toDateTimeString(),
        ];
    }

    public function includeType(Link $link)
    {
        $type = $link->type;

        return $this->item($type, new TypeTransformer());
    }
}
