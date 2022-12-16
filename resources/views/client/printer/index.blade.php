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
</style>

<section class="report-box">
    <article class="report-title">
       Print Product - {{ date('Y'); }} - 2023
    </article>
    <div class="search-box">
        <form class="w-full" action="{{ route('client.printer.index') }}">
            {{-- <select name="status" id="" style="padding: 7px 10px; border:1px solid #b0b0b0; outline:0; margin:0px 10px;">
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
                <option value="refund">Refund</option>
            </select> --}}
            <select name="month" id="" style="padding: 7px 10px; border:1px solid #b0b0b0; outline:0; margin:0px 10px;">
                @if (app('request')->input('month'))
                <option selected value="{{ app('request')->input('month') }}">  {{ date('M',strtotime(app('request')->input('month'))) }}</option>
                @endif
                <option value="All">All</option>
                <option value="2022-12">Dec</option>
                <option value="2023-01">Jan</option>
                <option value="2023-02">Feb</option>
                <option value="2023-03">Mar</option>
                <option value="2023-04">Apr</option>
                <option value="2023-05">May</option>
                <option value="2023-06">Jun</option>
                <option value="2023-07">Jul</option>
                <option value="2023-08">Aug</option>
                <option value="2023-09">Sep</option>
                <option value="2023-10">Oct</option>
                <option value="2023-11">Nov</option>
                <option value="2023-12">Dec</option>
            </select>
            <button type="submit">Search</button>
        </form>
    </div>

    <article class="report-list">
        <div class="report-body" style="display: flex; color:white;">
            <p style="flex:2; text-align:center;"></p>
            <p style="flex:7; text-align:center;">Product</p>
            <p style="flex:7; text-align:center;">Category</p>
            <p style="flex:7; text-align:center;">Price</p>
            <p style="flex:7; text-align:center;">Date</p>
            <p style="flex:7; text-align:center;">Status</p>
        </div>
    </article>

    @foreach ($products as $sold)
        <article class="report-list">
            <div class="report-image" >
                @if ($sold['product_image']!=null)
                <img src="{{ asset('storage/product/'.$sold['product_image']) }}" alt="">
                @else
                <img src="{{ asset('storage/test.jpg') }}" alt="">
                @endif
            </div>
            <div class="report-head">
                <p>{{ Str::ucfirst($sold['product_name']) }}</p>
            </div>
            <div class="report-head">
                <p>{{ Str::ucfirst($sold['category_name']) }}</p>
            </div>
            <div class="report-head">
                <p>{{number_format($sold['price'],2) }}</p>
            </div>
            <div class="report-head">
                <p>{{ date('M d, Y',strtotime($sold['created_at'])) }}</p>
            </div>
            <div class="report-head">
                @switch($sold['status'])
                    @case('refund')
                        <span style="color:orange !important;">{{ ucfirst($sold['status']) }}</span>
                        @break
                    @case('cancelled')
                        <span style="color:red !important;">{{ ucfirst($sold['status']) }}</span>
                        @break
                    @case('delivered')
                        <span style="color:green !important;">{{ ucfirst($sold['status']) }}</span>
                        @break
                    @default
                @endswitch
            </div>
        </article>
    @endforeach

    <div>
     @if (app('request')->input('month')!='All')
     <form action="{{ route('client.printer.print') }}" method="POST">
        @csrf
        <input type="hidden" name="month" value="{{ app('request')->input('month') }}">
        <button type="submit" class="btn btn-navy" style="float:left; letter-spacing:1px;"><i class="fa fa-print"></i> Print</button>
      </form>
    @elseif(app('request')->input('all')=='All')
    <form action="{{ route('client.printer.print') }}" method="POST">
        @csrf
        <input type="hidden" name="month" value="{{ app('request')->input('all') }}">
        <button type="submit" class="btn btn-navy" style="float:left; letter-spacing:1px;"><i class="fa fa-print"></i> Print</button>
      </form>
     @else
     <form action="{{ route('client.printer.print') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-navy" style="float:left; letter-spacing:1px;"><i class="fa fa-print"></i> Print</button>
      </form>
     @endif
    </div>
    {{-- {{ $products->withQueryString()->links('pagination::bootstrap-4') }} --}}
</section>
@endsection


