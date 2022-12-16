<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class Cart extends EloquentModel
{
    use HasFactory;

    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Products::class);
    }
}
