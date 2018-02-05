<?php

namespace App\Models;

class Attachment extends BaseModel
{
    protected $fillable = ['uploader_id', 'title', 'mime', 'file_size', 'path'];
}
