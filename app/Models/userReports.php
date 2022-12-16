<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class userReports extends EloquentModel
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reply(){
        return $this->hasMany(replyReports::class,'model_id');
    }

    public function replyCount() {
         return $this->reply();
    }
}
