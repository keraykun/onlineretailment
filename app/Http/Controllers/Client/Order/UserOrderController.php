<?php

namespace App\Http\Controllers\Client\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\orderInfos;
use App\Models\orderStatus;
use App\Models\Products;
use App\Models\productSold;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index(Request $request){

        $user = Auth::user()->id;
        if($request->search){

            $orders = Order::whereNotIn('status',['delivered'])
            ->where('status',$request->search)
            ->with(['product.category','product.image','info','product.report'])
            ->where('seller_id',$user)->paginate(8);
        }else{
            $orders = Order::whereNotIn('status',['delivered'])
            ->with(['product.category','product.image','info','product.report'])
            ->where('seller_id',$user)->paginate(8);
        }

        return view('client.order.userorder.index',['orders'=>$orders]);
    }

    public function create(Request $request){
         Order::where('user_id',$request->user_id)
        ->where('product_id',$request->product_id)
        ->where('_id',$request->id)
        ->update([
            'status'=>'approved',
            'updated_at'=>$request->date_arrive
        ]);
        return redirect()->back();
    }

    public function remove(Request $request){
        $user = Auth::user()->id;
        productSold::create([
            'user_id'=>$user,
            'product_id'=>$request->product_id,
            'order_id'=>$request->id,
            'price'=>$request->price,
            'quantity'=>1,
            'status'=>'cancelled',
        ]);
        Order::where('_id',$request->id)
        ->where('product_id',$request->product_id)
        ->where('user_id',$request->user_id)
        ->delete();

        orderInfos::where('order_id',$request->id)
        ->where('user_id',$request->user_id)
        ->delete();

        return redirect()->back();
    }

    public function update(Request $request){
        $user = Auth::user()->id;
        $search = Order::where('_id',$request->id)
        ->with([
            'product.image',
            'product.category'
        ])->first();

        orderStatus::create([
            'user_id'=>$search->user_id,
            'order_id'=>$search->id,
            'product_id'=>$search->product->id,
            'product_name'=>$search->product->name,
            'product_image'=>$search->product->image->name,
            'category_name'=>$search->product->category->name,
            'price'=> $search->product->price,
            'status'=>'delivered'
        ]);

        productSold::create([
            'user_id'=>$user,
            'product_id'=>$request->product_id,
            'order_id'=>$request->id,
            'price'=>$search->product->price,
            'quantity'=>1,
            'status'=>'delivered',
        ]);

        if(file_exists($path = public_path('storage/product/'.$search->product->image->name))){
            copy(
                'storage/product/'.$search->product->image->name,
                'storage/order/'.$search->product->image->name
            );
        }
        Order::where('user_id',$request->user_id)
        ->where('product_id',$request->product_id)
        ->where('_id',$request->id)
        ->update([
            'status'=>'delivered',
        ]);


        return redirect()->back();
    }
}
