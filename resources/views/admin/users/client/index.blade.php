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

      <u style="margin-right: 10px;">{{ $products->count() }}</u> Products List by  <u style="margin-left: 10px;"> {{ $data->name }}</u>
    </article>
    <div class="search-box">
        {{-- <form class="w-full" action="{{ route('client.product.index') }}">
            <i class="fa fa-search"></i>
            <input placeholder="Search"  type="search" name="search">
            <fieldset style="margin: 0px 10px;">
                <div>
                    <label id="labelMin" for="">{{ $min }}</label>
                    <input name="min" type="range" min="{{ $min }}" value="{{ $min }}" max="{{ $max }}"
                    oninput="document.getElementById('labelMin').innerHTML = this.value;">
                </div>
                <div>
                    <label id="labelMax">{{ $max }}</label>
                    <input name="max"  min="{{ $min }}" type="range" max="{{ $max }}" value="{{ $max }}"
                    oninput="document.getElementById('labelMax').innerHTML = this.value;">
                </div>
            </fieldset>
            <button type="submit">Search</button>
        </form>
        </div>--}}
    </div>
    <article class="report-list">
        <div class="report-body" style="display: flex; color:white;">
            <p style="flex:2; text-align:center;"></p>
            <p style="flex:7; text-align:center;">Product</p>
            <p style="flex:7; text-align:center;">Category</p>
            <p style="flex:7; text-align:center;">Price</p>
        </div>
    </article>
    @foreach ($products as $product)
        <article class="report-list">
            <div class="report-image" >
                @if ($product->image!=null)
                <img src="{{ asset('storage/product/'.$product->image->name) }}" alt="">
                @else
                <img src="{{ asset('storage/test.jpg') }}" alt="">
                @endif
            </div>
            <div class="report-head">
                <p>{{ Str::ucfirst($product->name) }}</p>
            </div>
            <div class="report-head">
                <p>{{ Str::ucfirst($product->category->name) }}</p>
            </div>
            <div class="report-head">
                <p>{{number_format($product->price,2) }}</p>
            </div>
        </article>
    @endforeach
    {{ $products->withQueryString()->links('pagination::bootstrap-4') }}
</section>

@endsection


