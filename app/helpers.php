<?php

use App\Models\Cart;
use App\Models\User;
use App\Models\userImage;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

if(!function_exists('redirectToDashboard')){
    function redirectToDashboard($role){
        switch ($role) {
            case 'user':
                return route('user.dashboard');
                break;
            case 'client':
                return route('client.dashboard');
                break;
            case 'admin':
                return route('admin.dashboard');
                break;
            default:
                die('error role no found checking helpers.php');
                break;
        }
    }
}

if(!function_exists('countCart')){
    function countCart(){
        return Cart::where('user_id',Auth::user()->id)->count();
    }
}
if(!function_exists('countWishCart')){
    function countWishCart(){
        return Wishlist::where('user_id',Auth::user()->id)->count();
    }
}

if(!function_exists('userProfilePicture')){
    function userProfilePicture(){
        return $user = User::where('_id',Auth::user()->id)->with('image')->first();
    }
}

if(!function_exists('userProfileAuth')){
    function userProfileAuth($user){
        return $user = User::where('_id',$user)->with('image')->first();
    }
}
