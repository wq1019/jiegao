<?php

namespace App\Models;

use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use Sortable;
}
