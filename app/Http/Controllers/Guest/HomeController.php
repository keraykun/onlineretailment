<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Role;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('hasAuth')->only(['register','login']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('guest.index');
    }

    public function login()
    {
        return view('guest.login');
    }

    public function register()
    {
        $roles = Role::whereIn('name',['client','user'])->get();
        return view('guest.register',['roles'=>$roles]);
    }

    public function show(Products $product)
    {
           $product = Products::where('_id',$product->id)
        ->with(['category','image','feedback.user'])->first();
        return view('guest.feedback',['product'=>$product]);
    }


    public function product(Request $request){
        $min = Products::min('price');
        $max = Products::max('price');
        $category = Categories::all(); //select option

       if($request->max && $request->min && $request->search){
           $search = $request->search;
           $products = Products::whereHas('category',function($category) use($search){
               $category->where('name','like',"%$search%");
           })->orWhere(function($where) use($search){
               $where->orWhere('name','like',"%$search%");
               $where->orWhere('price','like',"%$search%");
           })
           ->whereBetween('price', [(int)$request->min, (int)$request->max])
           ->with('image')
           ->paginate(8);
       }else if($request->max && $request->min && $request->search==""){
           $search = $request->search;
           $products = Products::where('category')
           ->whereBetween('price', [(int)$request->min, (int)$request->max])
           ->paginate(8);
       }else if($request->category){
            $search = $request->category;
            $products = Products::whereHas('category',function($category) use($search){
                $category->where('name','like',"%$search%");
            })
            ->with('image')
            ->paginate(8);
       }else{
            $products = Products::with(['category','image'])->paginate(8);
       }
         return view('guest.product',[

         'categories'=>$category,
         'products'=>$products,
         'min'=>$min,
         'max'=>$max]);
   }
}

