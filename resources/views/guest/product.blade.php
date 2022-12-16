@extends('layouts.header.app')
@section('content')
<style>

    .list-product:hover{
       color:black;
    }

    .search-product  {
        outline: none !important;
        border:1px solid rgb(202 138 4);
    }
    .search-button{
        background: rgb(34 197 94);
        font-weight: bold;
        color: azure;
        height: 50px;
        padding: 0px 10px 0px 10px;
        border-radius: 10%;
    }
</style>
<section class="landing flex-shrink-1 flex gap-5 flex-col items-center justify-around" style="padding-bottom: 25px;">
    <section class="landing flex-shrink-1 flex gap-5 flex-col items-center justify-around w-full">
        <ul class="bg-green-500 w-full flex justify-center gap-5 py-4">
            @foreach ($categories as $category)
                <li class="border-b">
                    <form action="{{ route('guest.product') }}">
                        <input type="hidden" name="category" value="{{ $category->name }}">
                        <button type="submit" class="list-product text-white">{{ $category->name }}</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <section class="w-full flex" style="justify-content: center; align-items:center;">
        @if ($message = Session::get('success'))
        <div class="alert-alert-message alert-success p-4" role="alert">
            <p>{{ $message }}<i class="fa fa-shopping-cart"></i></p>
          </div>
        @elseif($message = Session::get('wishlist'))
        <div class="alert-alert-message alert-added p-4" role="alert">
            <p>{{ $message }}<i class="fa fa-heart"></i></p>
          </div>
        @endif
        <div class="search-area">
            <form class="w-full" action="" style="display: flex; align-items:center; gap:15px;">
                <i class="fa fa-search"></i>
                <input placeholder="Search" class="search-product border px-4 rounded-lg h-12"  type="search" name="search">
                <fieldset style="margin: 0px 10px;">
                    <div>
                        <label id="labelMin" for="">{{ $min }}</label>
                        <input name="min" type="range" min="{{ $min }}" value="{{ $min }}" max="{{ $max }}"
                        oninput="document.getElementById('labelMin').innerHTML = this.value;">
                    </div>
                    <div>
                        <label id="labelMax">{{ $max }}</label>
                        <input name="max" type="range" min="{{ $min }}" max="{{ $max }}" value="{{ $max }}"
                        oninput="document.getElementById('labelMax').innerHTML = this.value;">
                    </div>
                </fieldset>
                <button style="background: #0e86d4; padding:10px 15px; color:white;" type="submit">Search</button>
            </form>
            {{-- <form action="">
                <input type="search"  placeholder="Search Product" class="search-product border px-4 rounded-lg h-12">
                <button class="search-button" type="button">Search</button>
            </form> --}}
        </div>
        </section>
    </section>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Caveat&family=Mukta:wght@300&display=swap');
        .product-content{
            width: 100%;
            padding: 2px 20px 0px 20px;
            flex-direction: row;
            display: flex;
            flex-wrap: wrap;

        }
        .card{
            box-shadow: -3px 1px 18px 1px rgba(24,36,4,0.09);
        -webkit-box-shadow: -3px 1px 18px 1px rgba(24,36,4,0.09);
        -moz-box-shadow: -3px 1px 18px 1px rgba(24,36,4,0.09);
            display: flex;
            width: 31%;
            height: 250px;
            margin: 10px;
            padding: 10px;
            border-radius: 10px;
        }
        .card .card-picture{
            flex: 1;
            display: flex;
            padding: 5px;
        }
        .card .card-content{
            padding: 3px;
            display: flex;
            flex-direction: column;
            height: 100%;
            flex: 1;
        }
        .card .card-title{
            padding: 5px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .card .card-body{
            display: flex;
            flex: 3;
            padding: 5px;
        }
        .card .card-price{
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Caveat', cursive;
            font-family: 'Mukta', sans-serif;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .card .card-cart{
            padding: 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            gap: 3px;
        }
        .card .card-cart li a{
            display: flex;
            padding: 3px;
            border-radius: 5px;
            color: azure;
            cursor: pointer;
            align-items: center;
        }
        section.list-cart button{
            background: rgb(255 178 18) !important;
            width: 100%;
            color: white;

        }
        section.list-wish button{
            background: #FFC0CB;
            width: 100%;
            color: white;
        }
        button i.fa{
            margin-right: 20px;
            font-size: 1.2rem;
        }

        section.list-cart button:hover{
            background: rgb(205 144 17) !important;
        }
         section.list-wish button:hover{
            background: #d9a5ae;
        }
        article.article-error{
            color:var(--fontClay);
            width: 100%;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
        }
    </style>
    <section class="product-content">

    @if($products->count()>0)
    @foreach ($products as $product)


    <div class="card">
        <div class="card-picture" style="overflow: hidden;">
            @if ($product->image!=null)
            <img src="{{ asset('storage/product/'.$product->image->name) }}" alt="">
            @else
            <img src="{{ asset('images/test.jpg') }}" alt="">
            @endif
        </div>
        <div class="card-content">
            <div class="card-title">
               {{ $product->name }}

            </div>
            <div class="card-body">
                {{ $product->description }}
            </div>
            <div class="card-price">
                {{ number_format($product->price,2); }}
            </div>
            <div class="card-cart">
                <form method="POST" action="{{ route('cart.store') }}">
                    @csrf
                <section class="list-cart">
                    <input name="product_id" type="hidden" value="{{ $product->id }}">
                    <button type="submit"><i class="fa fa-shopping-cart"></i> <span>Add to cart</span></button>
                </section>
                </form>
                <form method="POST" action="{{ route('cart.wishlist.store') }}">
                    @csrf
                <section class="list-wish">
                    <input name="product_id" type="hidden" value="{{ $product->id }}">
                    <button type="submit"><i class="fa fa-heart"></i> <span>Add to Wishlist</span></button>
                </section>
                </form>
                <form action="{{ route('guest.feedback',$product->id) }}" style="width: 100%;">
                    <button type="submit" style="width:100%; display:flex; justify-content:center; align-items:center; padding:2px; color:white; background:skyblue;"><i class="fa fa-comments" style="font-size: 1.1rem; margin-right:13px;"></i>  View feedback</button>
                </form>
            </div>
        </div>
    </div>

    @endforeach

    @else

    <article class="article-error">No Data | Please upload some Data.</article>

    @endif

    </section>
    {{ $products->withQueryString()->links('pagination::bootstrap-4') }}
</section>

@endsection
