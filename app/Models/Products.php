<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

// use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Categories::class);
    }

    public function image(){
        return $this->belongsTo(productsImage::class,'id','product_id');
    }

    public function owner(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function order(){
        return $this->belongsTo(Order::class,'id','product_id');
    }


    public function report(){
        return $this->belongsTo(productReports::class,'id','product_id');
    }

    public function feedback(){
        return $this->hasMany(feedbackReports::class,'product_id');
    }

    public function totalSold(){
        return $this->hasMany(productSold::class,'product_id');
    }

}
