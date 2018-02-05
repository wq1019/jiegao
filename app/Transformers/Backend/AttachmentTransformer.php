<?php

namespace App\Transformers\Backend;

use App\Models\Attachment;
use League\Fractal\TransformerAbstract;

class AttachmentTransformer extends TransformerAbstract
{
    public function transform(Attachment $attachment)
    {
        return [
            'id'               => $attachment->id,
            'post_id'          => $attachment->post_id,
            'title'            => $attachment->title,
            'uploader_id'      => $attachment->uploader_id,
            'mime'             => $attachment->mime,
            'file_size'        => $attachment->file_size,
            'humans_file_size' => file_size_for_humans($attachment->file_size),
            'created_at'       => $attachment->created_at->toDateTimeString(),
            'updated_at'       => $attachment->updated_at->toDateTimeString(),
        ];
    }
}
