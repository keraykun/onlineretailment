@extends('layouts.user.sidenav')
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
tr td{
    font-size: 0.8rem;
}
</style>
<section class="landing flex-shrink-1 flex  flex-col items-center justify-around" style="padding-bottom: 25px;">
    {{-- @if ($message = Session::get('danger'))
    <div class="alert-alert-message alert-danger p-4" style="margin-bottom: 10px;" role="alert">
        <p>{{ $message }} <i class="fa fa-frown-o"></i></p>
      </div>
    @endif --}}
    <table id="customers">
        <tr>
         <th></th>
          <th>Product</th>
          <th>Contact</th>
          <th>Delivery Address</th>
          <th>Price</th>
          <th>Date Arrive</th>
          <th>Payment Method</th>
          <th>Status</th>
          <th></th>
        </tr>
        @foreach ($orders as $order)
        <tr>
            <td class="td-image">
                <div class="td-image-size">
                    <img src="{{ asset('storage/product/'.$order->product->image->name) }}" alt="">
                </div>
            </td>
            <td>
                <div class="td-image-detail">
                    <p style="font-size: 0.8rem;">{{ $order->product->name }}</p>
                    <p>{{ $order->product->category->name }}</p>
                </div>
            </td>
            <td width="">{{ $order->info->contact }}</td>
            <td>{{ $order->info->street.' '.$order->info->address.' ,'.$order->info->city.' '.$order->info->province. ' ( '.$order->info->describe. ')' }}</td>
            <td width="5%">{{ number_format($order->price,2) }}</td>
            <td width="">
                @if ($order->status==='approved')
                    {{ date('M d , Y',strtotime($order->info->updated_at)) }}
                @elseif ($order->status==='delivered')
                  {{ date('M d , Y',strtotime($order->info->updated_at)) }}
                @endif
            </td>
            <td width="">Cash on Delivery</td>
            <td width="8%">
                @switch($order->status)
                    @case('approved')
                       <span style="color:green;">{{ ucfirst($order->status) }}</span>
                          @break
                    @case('pending')
                        <span style="color:orange;">{{ ucfirst($order->status) }}</span>
                        @break
                    @case('cancelled')
                        <span style="color:red;">{{ ucfirst($order->status) }}</span>
                        @break
                    @case('delivered')
                        <span style="color:green;">{{ ucfirst($order->status) }}</span>
                        @break
                    @default

                @endswitch
            </td>
            <td style="height:100%; display: flex; flex-direction:column; ">
                @if ($order->status==='pending')

                <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#pending-{{ $order->id }}" href="#">Cancel</a>
                <!--modal pending-->
                <div class="modal fade" id="pending-{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <form method="POST" action="{{ route('user.report.create') }}">
                      @csrf
                  <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header bg-danger">
                      <h5 class="modal-title" id="exampleModalLabel">Are you sure want to Cancel?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="">What is reason?</label>
                              <input name="title" type="text" class="form-control">
                          </div>
                          <div class="form-group">
                              <label for="">Describe reason?</label>
                              <textarea name="description" id="" cols="30" rows="10"></textarea>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <input type="hidden" value="{{ $order->id }}" name="id">
                          <button type="submit" class="btn btn-danger">Cancel</button>
                      </div>
                  </div>
                  </div>
                   </form>
              </div>
              <!--end modal-->
                @elseif ($order->status==='delivered')
                <a class="btn btn-navy" data-bs-toggle="modal" data-bs-target="#delivered-{{ $order->id }}" href="#">Feedback</a>
                <a class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#refund-{{ $order->id }}" href="#">Refund</a>

                <!--modal refund-->
                <div class="modal fade" id="refund-{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <form method="POST" action="{{ route('user.report.refund') }}">
                      @csrf
                  <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header bg-purple">
                      <h5 class="modal-title" id="exampleModalLabel">Reason for refund?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="">Title </label>
                              <input name="title" type="text" class="form-control">
                          </div>
                          <div class="form-group">
                              <label for="">Reason</label>
                              <textarea name="description" id="" cols="30" rows="10"></textarea>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" value="{{ $order->product->user_id }}" name="user_id">
                          <input type="hidden" value="{{ $order->id }}" name="id">
                          <input type="hidden" value="{{ $order->product->id }}" name="product_id">
                          <button type="submit" class="btn btn-purple">Send</button>
                      </div>
                  </div>
                  </div>
                   </form>
              </div>
              <!--end modal-->

              <!--modal delivered-->
              <div class="modal fade" id="delivered-{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <form method="POST" action="{{ route('user.report.store') }}">
                    @csrf
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-navy">
                    <h5 class="modal-title" id="exampleModalLabel">Feedback for Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Title feedback?</label>
                            <input name="title" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Describe feedback?</label>
                            <textarea name="description" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="{{ $order->id }}" name="id">
                        <input type="hidden" value="{{ $order->product->user_id }}" name="user_id">
                        <input type="hidden" value="{{ $order->product->id }}" name="product_id">
                        <button type="submit" class="btn btn-navy">Send</button>
                    </div>
                </div>
                </div>
                 </form>
            </div>
            <!--end modal-->


                @endif
            </td>
          </tr>
        @endforeach
      </table>

      {{ $orders->withQueryString()->links('pagination::bootstrap-4') }}
</section>

 @endsection
