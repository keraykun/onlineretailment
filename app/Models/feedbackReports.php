<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class feedbackReports extends EloquentModel
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'from_user_id');
    }

    public function product(){
        return $this->belongsTo(Products::class);
    }
}
