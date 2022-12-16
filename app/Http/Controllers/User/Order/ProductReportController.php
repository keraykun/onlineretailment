<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\orderStatus;
use App\Models\productReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReportController extends Controller
{
    public function create(Request $request){


         $user = Auth::user()->id;
         $search = Order::with(['product.category','product.image'])->findOrFail($request->id);

        productReports::create([
            'from_user_id'=> $user,
            'to_user_id'=>$search->product->user_id,
            'product_id'=>$search->product->id,
            'title'=>$request->title,
            'description'=>$request->description,
            'notification'=>1
        ]);
        orderStatus::create([
            'user_id'=>$user,
            'order_id'=>$search->id,
            'product_id'=>$search->product->id,
            'product_name'=>$search->product->name,
            'product_image'=>$search->product->image->name,
            'category_name'=>$search->product->category->name,
            'price'=> $search->product->price,
            'status'=>'cancelled'
        ]);
        Order::where('user_id',$user)
        ->where('_id',$search->id)
        ->where('product_id',$search->product->id)
        ->update(['status'=>'cancelled']);

        if(file_exists($path = public_path('storage/product/'.$search->product->image->name))){
            copy(
                'storage/product/'.$search->product->image->name,
                'storage/order/'.$search->product->image->name
            );
        }
        return redirect()->back();
    }
}
