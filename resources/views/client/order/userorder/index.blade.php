@extends('layouts.client.sidenav')
@section('sidenav')
<style>
#display-image-add, .display-image{
  width: 100x;
  height: 200px;
  border: 1px solid #b0b0b0;
  background-position: center;
  background-size: cover;
  margin-bottom: 20px;
}

.report-list .report-image{
    display: flex;
    justify-items: center;
    align-items: center;
    height: 100%;
}
.report-list .report-image img{
    position: absolute;
    top: 0% !important;
    height: 100%;
    width: 100%;
    background: #d9e4eb !important;
}
article.report-list .report-body {
    background: white;
    padding: 5px;
    flex: 2;
    display: flex;
    align-items: center;
    justify-content: space-around;
}
</style>

<section class="report-box">
    <article class="report-title">
      User Orders
    </article>
    <div class="search-box">
        <form class="w-full" action="{{ route('client.order.user.index') }}">
            <fieldset style="margin: 0px 10px;">
                <div>
                    <select style="border:1px solid #b0b0b0; padding:7px 20px;" name="search" id="">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </fieldset>
            <button type="submit">Search</button>
        </form>
    </div>

    <article class="report-list">
        <div class="report-body" style="display: flex; color:black;">
            <p style="flex:2; text-align:center;"></p>
            <p style="flex:7; text-align:center;">Product</p>
            <p style="flex:7; text-align:center;">Category</p>
            <p style="flex:7; text-align:center;">Price</p>
            <p style="flex:7; text-align:center;">Status</p>
            <p style="flex:7; text-align:center;">Date Ordered</p>
            <p style="flex:2; text-align:center;">Options</p>
        </div>
    </article>

    @foreach ($orders as $order)
        <article class="report-list">
            <div class="report-image" >
                <img src="{{ asset('storage/product/'.$order->product->image->name) }}" alt="">
            </div>
            <div class="report-head">
               {{ $order->product->name }}
            </div>
            <div class="report-head">
                {{ $order->product->category->name }}
            </div>
            <div class="report-head">
                {{ number_format($order->product->price,2) }}
             </div>
             <div class="report-head">
            @switch($order->status)
                @case('pending')
                    <span style="color:orange !important;">{{ ucfirst($order->status) }}</span>
                    @break
                @case('cancelled')
                    <span style="color:red !important;">{{ ucfirst($order->status) }}</span>
                    @break
                @case('approved')
                    <span style="color:green !important;">{{ ucfirst($order->status) }}</span>
                    @break

                @case('delivered')
                    <span style="color:green !important;">{{ ucfirst($order->status) }}</span>
                    @break
                @default
            @endswitch
              </div>
            <div class="report-head">
             {{ date('M d ,Y h:i a',strtotime($order->created_at)) }}
            </div>
            <div class="report-body">
                @switch($order->status)
                @case('approved')

                <a data-bs-toggle="modal" data-bs-target="#approve-{{ $order->id }}" href="#" style="padding:5px;" class="bg-navy">Process</a>
                <!--modal approve-->
               <div class="modal fade" id="approve-{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <form method="post" action="{{ route('client.order.user.update') }}">
                    @csrf
                   <div class="modal-dialog">
                   <div class="modal-content">
                       <div class="modal-header bg-navy">
                       <h5 class="modal-title">Order Details</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                       </div>
                       <div class="modal-body" style="display: flex; flex-direction:column; gap:5;">
                           <p><span><b>Name : </b></span> {{  $order->user->name }}</p>
                           <p><span><b>Contact : </b></span> {{ $order->info->contact }}</p>
                           <p><span><b>Address : </b></span>
                             {{ $order->info->address.' '.
                                $order->info->street.' '.
                                $order->info->city.' '.
                                $order->info->province. ' ( '.
                                $order->info->describe.' ) '
                             }}
                           <p><span><b>Date Arrive : </b></span>  {{ date('M d ,Y',strtotime($order->updated_at)) }}</p>
                       </div>
                       <div class="modal-footer">
                        <input type="hidden" name="id" value="{{ $order->id }}">
                        <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                        <input type="hidden" name="product_id" value="{{ $order->product_id }}">
                        <button type="submit" class="btn btn-navy">Delivered</button>
                    </div>
                   </div>
               </form>
               </div>
               </div>
               <!--end approve-->


                 @break

                 @case('delivered')
                 <a style="padding:5px;" href="#">Process</a>
                  @break

                @case('cancelled')
                <a data-bs-toggle="modal" data-bs-target="#delete-{{ $order->id }}" href="#" class="bg-danger" style="padding:5px;">Reason</a>
                 <!--modal delete-->
                <div class="modal fade" id="delete-{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form method="post" action="{{ route('client.order.user.remove') }}">
                        {{ csrf_field() }}
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                        <h5 class="modal-title">Reason</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="display: flex; flex-direction:column; gap:5;">
                           <p><span><b>Name : </b></span> {{  $order->user->name }}</p>
                           <p><span><b>Contact : </b></span> {{ $order->info->contact }}</p>
                           <p><span><b>Address : </b></span>
                             {{ $order->info->address.' '.
                                $order->info->street.' '.
                                $order->info->city.' '.
                                $order->info->province. ' ( '.
                                $order->info->describe.' ) '
                             }}
                            </p>
                            <hr style="margin: 10px 0px;">
                           <p><span><b>Reason  : </b></span> {{ $order->product->report->title }}</p>
                           <p><span><b>Describe : </b></span> {{ $order->product->report->description }}</p>
                           <small>{{ date('M d ,Y h:i a',strtotime($order->product->created_at)) }}</small>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="price" value="{{ $order->price }}">
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                            <input type="hidden" name="product_id" value="{{ $order->product_id }}">
                        <button type="submit" class="btn btn-default">Remove</button>
                        </div>
                    </div>
                </form>
                </div>
                </div>
                <!--end delete-->

                    @break

                @case('pending')

                <a data-bs-toggle="modal" data-bs-target="#edit-{{ $order->id }}" href="#" style="padding:5px;" class="bg-success">Approve</a>
                 <!--modal edit-->
                <div class="modal fade" id="edit-{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form method="post" action="{{ route('client.order.user.create') }}">
                      @csrf
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                        <h5 class="modal-title">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="display: flex; flex-direction:column; gap:5;">
                            <p><span><b>Name : </b></span> {{  $order->user->name }}</p>
                            <p><span><b>Contact : </b></span> {{ $order->info->contact }}</p>
                            <p><span><b>Address : </b></span>
                              {{ $order->info->address.' '.
                                 $order->info->street.' '.
                                 $order->info->city.' '.
                                 $order->info->province. ' ( '.
                                 $order->info->describe.' ) '
                              }}
                             <small>{{ date('M d ,y h:i a',strtotime($order->created_at)) }}</small>
                        </div>
                        <div class="modal-footer" style="justify-content: space-between; width:100%;">
                        <p><span><b>Date Arrive : </b><input required name="date_arrive" type="date"></span></p>
                        <input type="hidden" name="id" value="{{ $order->id }}">
                        <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                        <input type="hidden" name="product_id" value="{{ $order->product_id }}">
                        <button type="submit" class="btn btn-success">Approve</button>
                        </div>
                    </div>
                </form>
                </div>
                </div>
                <!--end edit-->

                    @break

                @default
            @endswitch

            </div>
        </article>
    @endforeach

    {{ $orders->withQueryString()->links('pagination::bootstrap-4') }}
</section>
@endsection


