<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class Order extends EloquentModel
{
    use HasFactory;

    protected $guarded = [];

    public function info(){
        return $this->belongsTo(orderInfos::class,'id','order_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function product(){
        return $this->belongsTo(Products::class,'product_id');
    }

}
