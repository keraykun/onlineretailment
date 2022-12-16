<?php

namespace App\Http\Controllers\Client\History;

use App\Http\Controllers\Controller;
use App\Models\productSold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request){
        $user = Auth::user()->id;
        $min = productSold::where('user_id',$user)->min('price');
        $max = productSold::where('user_id',$user)->max('price');

       if($request->max && $request->min && $request->search){

           $search = $request->search;
           $products = productSold::whereHas('product',function($product) use($search){
               $product->where('name','like',"%$search%")
               ->orWhereHas('category',function($category) use($search){
                 $category->where('name','like',"%$search%");
               });
           })
           ->orWhere(function($where) use($search){
               $where->orWhere('status','like',"%$search%");
           })
           ->whereBetween('price', [(int)$request->min, (int)$request->max])
           ->where('user_id',$user)
           ->paginate(8);

       }else if($request->max && $request->min && $request->search==""){
           $search = $request->search;
           $products = productSold::whereHas('product')
           ->orWhere(function($where) use($search){
                $where->orWhere('status','like',"%$search%");
             })
           ->whereBetween('price', [(int)$request->min, (int)$request->max])
           ->where('user_id',$user)->paginate(8);

       }else{

         $products = productSold::with(['product.category','product.image'])
        ->where('user_id',$user)
        ->orderBy('_id','desc')
        ->paginate(8);

       }
         return view('client.history.index',[
         'products'=>$products,
         'min'=>$min,
         'max'=>$max]);
    }
}
