<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
         $user = Auth::user()->id;
         $orders = Order::where('user_id',$user)->with(['info','product.image','product.category'])->paginate(10);
        return view('user.order.index',['orders'=>$orders]);
    }
}
