<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\orderInfos;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','user-access:user','verified']);
    }

    public function index()
    {
        $auth = Auth::user()->id;
        $ordersUser = Cart::where('user_id',$auth)->get();
         $orders =
        User::where('_id',$auth)
       ->with('carts:_id,user_id,product_id,price','carts.product:image,name,description')
       ->with('carts.product.image')
       ->first();
        $total = Cart::where('user_id',$auth)->sum('price');
        return view('cart.index',['orders'=>$orders,'total'=>$total,'ordersUser'=>$ordersUser]);
    }

    public function proceed(Request $data)
    {
        $auth = Auth::user()->id;
        abort_if(!Cart::where('user_id',$auth)->count()>0,404);
        $orders =
           User::where('_id',$auth)
          ->with([
           'carts:_id,user_id,product_id,price','carts.product:image,name,description,user_id',
           'carts.product.image',
           'carts.product.owner'
           ])
          ->first();
           return view('cart.proceed',['orders'=>$orders]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'contact'=>'required|digits:11',
            'province'=>'required',
            'city'=>'required',
            'address'=>'required',
            'street'=>'required',
            'describe'=>'required',
        ]);

        $user = Auth::user()->id;
        $carts = Cart::where('user_id',$user)
        ->with([
            'product.image',
            'product.owner',
            'product.category'
        ])->get();
        foreach($carts as $cart){
             if(file_exists($path = public_path('storage/product/'.$cart->product->image->name))){
                $order = Order::create([
                    'user_id'=>$user,
                    'seller_id'=>$cart->product->user_id,
                    'product_id'=>$cart->product->id,
                    'price'=> $cart->product->price,
                    'status'=>'pending'
                ]);
                orderInfos::create([
                    'user_id'=>$user,
                    'order_id'=>$order->_id,
                    'name'=>$request->name,
                    'contact'=>$request->contact,
                    'province'=>$request->province,
                    'city'=>$request->city,
                    'address'=>$request->address,
                    'street'=>$request->street,
                    'describe'=>$request->describe,
                ]);
                copy(
                    'storage/product/'.$cart->product->image->name,
                    'storage/order/'.$cart->product->image->name
                );
           }
        }

        Cart::where('user_id',$user)->delete();
        return redirect()->route('user.orders.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $data)
    {
        $product = Products::find($data)->first();
        Cart::create([
            'user_id'=>Auth::user()->id,
            'product_id'=>$product->id,
            'price'=>$product->price
        ]);
        return redirect()->back()->with('success','Product added!');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
          abort_if(Auth::user()->id!==$cart->user_id,404);
          Cart::destroy($cart->id);
          return redirect()->back()->with('danger','Product Removed!');;
    }
}
