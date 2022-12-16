@extends('layouts.admin.sidenav')
@section('sidenav')
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
.cart-proceed div button{
    background: rgb(255 186 43);
    border-radius: 10px;
    color: white;
    padding: 10px 30px;
}
.cart-proceed div button:hover{
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
    width: 100%;

}
.td-image-size{
    display: flex;
    align-items: center;
    gap: 15px;
    width: 100%;
}
.td-image-size img{
    width: 100px;
    height: 80px;
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
table#customers tr td,table#customers tr th{
    text-align: center;
}
.modal-body div.form-group{
    display: flex;
    justify-content: space-between;
    margin: 10px;

}

.modal-body div.form-group label{

}
.modal-body div.form-group input{
    border:1px solid #b0b0b0;
    padding: 3px;
}
.modal-body div.form-group textarea{
    border:1px solid #b0b0b0;
    padding: 5px;
}
</style>
<section class="landing flex-shrink-1 flex  flex-col items-center justify-around w-full" style="padding-bottom: 25px;">
    <a class="btn btn-default" href="{{ redirect()->getUrlGenerator()->previous() }}">Back</a>
    <article class="report-title w-full p-4">
       <u style="margin-right: 10px;">{{ $orders->count() }}</u>  Product History List by  <u style="margin-left: 10px;"> {{ $data->name }}</u>
    </article>
    <table id="customers">
        <tr>
          <th></th>
          <th>Product</th>
          <th>Category</th>
          <th>Price</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
        @foreach ($orders as $order)
        <tr>
            <td class="td-image">
                <div class="td-image-size">
                    <img src="{{ asset('storage/product/'.$order->product->image->name) }}" alt="">
                </div>
            </td>
            <td>
                <p style="font-size: 1.1rem;">{{ $order->product->name }}</p>
            </td>
            <td>
                <p>{{ $order->product->category->name }}</p>
            </td>
            <td width="10%">{{ number_format($order->price,2) }}</td>
            <td>
                <p>{{ $order->status }}</p>
            </td>
            <td width="">
                    {{ date('M d , Y',strtotime($order->updated_at)) }}
            </td>
          </tr>
        @endforeach
      </table>
      {{ $orders->withQueryString()->links('pagination::bootstrap-4') }}
</section>

 @endsection
