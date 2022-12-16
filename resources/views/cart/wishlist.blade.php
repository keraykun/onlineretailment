@extends('layouts.header.app')
@section('content')
<style>
.cart-content{
    display: flex;
}
.cart-content .row{

}

.cart-proceed{
    border: 1px solid #ddd;
    border-top: 0px;
    padding: 10px 0px;
    display: flex;
    padding-left: 700px;
    align-items: center;
    justify-content: space-between;
    font-size: 1.2rem;
}
.fa-add-cart{
    background: rgb(255 186 43);
    border-radius: 10px;
    color: white;
    padding: 10px;
    cursor: pointer;
}
.fa-add-cart:hover{
    background: rgb(211 145 10);
}
.cart-proceed div:nth-child(2){
    padding-right: 100px;
}
.cart-proceed span:nth-child(1){
    margin-right: 10px;
    font-weight: bold;
}
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: rgb(34 197 94);
  color: white;
}
.td-image{
    display: flex;
    align-items: center;
    gap: 20px;
}
.td-image-size{
    width: 100px;
    height: 100px;
    overflow: hidden;
}
.product-image{
  width: 90px;
  margin-right: 30px;
}
article.article-error{
    color:var(--fontClay);
    width: 100%;
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
}
</style>
<section class="landing flex-shrink-1 flex  flex-col items-center justify-around" style="padding-bottom: 25px;">
    @if ($message = Session::get('success'))
    <div class="alert-alert-message alert-success p-4" style="margin-bottom: 10px;" role="alert">
        <p>{{ $message }}<i class="fa fa-shopping-cart"></i></p>
      </div>
    @elseif($message = Session::get('danger'))
    <div class="alert-alert-message alert-danger p-4" style="margin-bottom: 10px;" role="alert">
        <p>{{ $message }} <i class="fa fa-frown-o"></i></p>
      </div>
    @endif
    <table id="customers">
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th></th>
          <th></th>
        </tr>
        @if($ordersUser->count()>0)
      @foreach ($wishlists as $wishlist)

        @can('view',$wishlist)
        <tr>
            <td class="td-image">
                 <div class="td-image-size">
                    @if ($wishlist->product!=null)
                    <img src="{{ asset('storage/product/'.$wishlist->product->image->name) }}" alt="">
                    @else
                    <img src="{{ asset('images/test.jpg') }}" alt="">
                    @endif
                </div>
                <p>{{$wishlist->product->name ?? '' }}</p>
            </td>
            <td width="15%">{{ number_format($wishlist->price,'2') }}</td>
            <td width="5%">
                @can('create',$wishlist)
                <form method="POST" action="{{ route('cart.wishlist.create',$wishlist->id); }}">
                    @csrf
                    <button type="sbumit"> <i style="font-size: 2rem;" class="fa-add-cart fa fa-shopping-cart" aria-hidden="true">
                    </i></button>
                </form>
                @endcan
            </td>
            <td width="5%">
                @can('delete',$wishlist)
                <form method="POST" action="{{ route('cart.wishlist.destroy',$wishlist->id); }}">
                @csrf
                {{method_field('delete')}}
                <button type="submit"> <i style="font-size: 2.5rem; color:red; cursor: pointer;" class="fa fa-times-circle-o" aria-hidden="true"></i></button>
            </form>
            @endcan
            </td>
          </tr>
        @endcan
      @endforeach
      @else
      <article class="article-error">No Data | Please add a Wishlist.</article>
      @endif
      </table>

</section>

 @endsection
