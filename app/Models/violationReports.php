<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class violationReports extends EloquentModel
{
    use HasFactory;
    protected $guarded = [];

    public function fromuser(){
        return $this->belongsTo(User::class,'from_user_id');
    }

    public function touser(){
        return $this->belongsTo(User::class,'to_user_id');
    }

    public function reply(){
        return $this->hasMany(replyReports::class,'model_id');
    }
}
