@extends('layouts.admin.sidenav')
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
    <a class="btn btn-default" href="{{ redirect()->getUrlGenerator()->previous() }}">Back</a>
    <article class="report-title">
       <u style="margin-right: 10px;"> {{ $products->count() }}</u>  Product History List by  <u style="margin-left: 10px;"> {{ $data->name }}</u>
    </article>

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
                @if ($sold->product->image!=null)
                <img src="{{ asset('storage/product/'.$sold->product->image->name) }}" alt="">
                @else
                <img src="{{ asset('storage/test.jpg') }}" alt="">
                @endif
            </div>
            <div class="report-head">
                <p>{{ Str::ucfirst($sold->product->name) }}</p>
            </div>
            <div class="report-head">
                <p>{{ Str::ucfirst($sold->product->category->name) }}</p>
            </div>
            <div class="report-head">
                <p>{{number_format($sold->price,2) }}</p>
            </div>
            <div class="report-head">
                <p>{{ date('M d, Y',strtotime($sold->created_at)) }}</p>
            </div>
            <div class="report-head">
                @switch($sold->status)
                    @case('refund')
                        <span style="color:orange !important;">{{ ucfirst($sold->status) }}</span>
                        @break
                    @case('cancelled')
                        <span style="color:red !important;">{{ ucfirst($sold->status) }}</span>
                        @break
                    @case('delivered')
                        <span style="color:green !important;">{{ ucfirst($sold->status) }}</span>
                        @break
                    @default
                @endswitch
            </div>
        </article>
    @endforeach
    {{ $products->withQueryString()->links('pagination::bootstrap-4') }}
</section>
@endsection


