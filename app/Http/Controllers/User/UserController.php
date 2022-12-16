<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\orderStatus;
use App\Models\productRefund;
use App\Models\User;
use App\Models\violationReports;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{

    public function dashboard(){
        $user = Auth::user()->id;
        $order = Order::where('user_id',$user)->count();
        $wishlist = Wishlist::where('user_id',$user)->count();
        $cart = Cart::where('user_id',$user)->count();
        $history = orderStatus::where('user_id',$user)->count();
        $refund = productRefund::where('from_user_id',$user)->count();
        $violation = violationReports::where('to_user_id',$user)->count();
        return view('user.dashboard',[
            'order'=>$order,
            'wishlist'=>$wishlist,
            'cart'=>$cart,
            'history'=>$history,
            'refund'=>$refund,
            'violation'=>$violation
        ]);
    }
}
