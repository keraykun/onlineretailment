<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
class WishlistController extends Controller
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
        $ordersUser = Wishlist::where('user_id',$auth)->get();
        $wishlists = Wishlist::where('user_id',$auth)->with('product.image')->get();
       return view('cart.wishlist',['wishlists'=>$wishlists,'ordersUser'=>$ordersUser]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Wishlist $wishlist)
    {
        abort_if(Auth::user()->id!==$wishlist->user_id,404);
        Cart::create([
            'user_id'=>Auth::user()->id,
            'product_id'=>$wishlist->product_id,
            'price'=>$wishlist->price
        ]);
        Wishlist::destroy($wishlist->id);
        return redirect()->back()->with('success','Product added!');;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $data)
    {
        $wishlist = Products::find($data)->first();

        Wishlist::create([
            'product_id'=>$wishlist->id,
            'user_id'=>Auth::user()->id,
            'price'=>$wishlist->price
        ]);
        return redirect()->back()->with('wishlist','Wishlist added!');
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
    public function destroy(Wishlist $wishlist)
    {
          abort_if(Auth::user()->id!==$wishlist->user_id,404);
          Wishlist::destroy($wishlist->id);
          return redirect()->back()->with('danger','Product Removed!');;
    }
}
