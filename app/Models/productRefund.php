<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class productRefund extends EloquentModel
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'from_user_id');
    }

    public function owner(){
        return $this->belongsTo(User::class,'to_user_id');
    }

    public function product(){
        return $this->belongsTo(Products::class);
    }

    public function reply(){
        return $this->hasMany(replyReports::class,'model_id');
    }

    public function productsold(){
        return $this->belongsTo(productSold::class,'order_id','order_id');
    }
}
