<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class orderInfos extends EloquentModel
{
    use HasFactory;

    protected $guarded = [];
}
