<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\productRefund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundReportController extends Controller
{
    public function refund(Request $request){

        $user = Auth::user()->id;
        productRefund::create([
            'from_user_id'=> $user,
            'to_user_id'=>$request->user_id,
            'product_id'=>$request->product_id,
            'order_id'=>$request->id,
            'title'=>$request->title,
            'description'=>$request->description,
            'notification'=>1
        ]);

        Order::where('user_id',$user)
        ->where('_id',$request->id)
        ->where('product_id',$request->product_id)
        ->delete();
        return redirect()->back();

    }
}
