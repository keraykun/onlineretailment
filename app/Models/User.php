<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\HasMedia;




class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public static $isAdmin = 'admin';
    public static $isClient ='client';
    public static $isUser ='userss';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'role_id',
    //     'password',
    // ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function image(){
        return $this->belongsTo(userImage::class,'_id','user_id');
    }

    public function state(){
        return $this->belongsTo(usersState::class,'id','user_id');
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class);
    }

    public function products(){
        return $this->hasMany(Products::class,'user_id');
    }

    public function productsold(){
        return $this->hasMany(productSold::class,'user_id');
    }

    public function orderstatus(){
        return $this->hasMany(orderStatus::class,'user_id');
    }

    public function orders(){
        return $this->hasMany(Order::class,'user_id');
    }

    public function violations(){
        return $this->hasMany(violationReports::class,'to_user_id');
    }

}
