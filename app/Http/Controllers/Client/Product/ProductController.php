<?php

namespace App\Http\Controllers\Client\Product;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use App\Models\productsImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request){
         $user = Auth::user()->id;
         $min = Products::where('user_id',$user)->min('price');
         $max = Products::where('user_id',$user)->max('price');
         $category = Categories::all();

        if($request->max && $request->min && $request->search){

            $search = $request->search;
            $products = Products::whereHas('category',function($category) use($search){
                $category->where('name','like',"%$search%");
            })->orWhere(function($where) use($search){
                $where->orWhere('name','like',"%$search%");
                $where->orWhere('price','like',"%$search%");
            })
            ->whereBetween('price', [(int)$request->min, (int)$request->max])
            ->where('user_id',$user)
            ->with('image')
            ->paginate(8);

        }else if($request->max && $request->min && $request->search==""){

            $search = $request->search;
            $products = Products::with('category')
            ->whereBetween('price', [(int)$request->min, (int)$request->max])
            ->where('user_id',$user)->paginate(8);

        }else{

             $products = Products::with(['category','image'])->where('user_id',$user)->paginate(8);

        }
          return view('client.product.index',[
          'categories'=>$category,
          'products'=>$products,
          'min'=>$min,
          'max'=>$max]);
    }


    public function create(Request $request){

        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);
        $imageName = time().'.'.$request->image->extension();

        $product = Products::create([
            'category_id'=>$request->category,
            'user_id'=>Auth::user()->id,
            'name'=>$request->product,
            'price'=>(int)$request->price,
        ]);

        productsImage::create(['product_id'=>$product->_id,'name'=>$imageName]);
        $request->image->move(public_path('storage/product'), $imageName);
        return redirect()->back()->with('success','Successfully Added');
    }

    public function update(Request $request){
        $request->validate([
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $user = Auth::user()->id;

        if($request->image!=null){
        $imageName = time().'.'.$request->image->extension();
        if($request->imageDelete!==null && file_exists($path = public_path('storage/product/'.$request->imageDelete))){
            unlink($path);
            productsImage::where('product_id',$request->id)->update(['name'=>$imageName]);
            $request->image->move(public_path('storage/product'), $imageName);
        }else{
            productsImage::create(['product_id'=>$request->id,'name'=>$imageName]);
            $request->image->move(public_path('storage/product'), $imageName);
        }
        }

        Products::where('_id',$request->id)->where('user_id',$user)->update([
            'category_id'=>$request->category,
            'user_id'=>Auth::user()->id,
            'name'=>$request->product,
            'price'=>(int)$request->price,
        ]);
        return redirect()->back()->with('info','Successfully Updated');
    }


    public function destroy(Products $product){
        $search = Products::with('image')->findOrFail($product->_id);
        $user = Auth::user()->id;
        if(file_exists($path = public_path('storage/product/'.$search->image->name))){
            unlink($path);
        }
        Products::where('_id',$product->id)->where('user_id',$user)->delete();
        productsImage::where('product_id',$product->id)->delete();
        return redirect()->back()->with('danger','Successfully Deleted');
        abort(404);
    }
}
