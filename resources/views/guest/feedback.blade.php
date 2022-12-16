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
<style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat&family=Mukta:wght@300&display=swap');
    .product-content{
        width: 100%;
        padding: 2px 20px 0px 20px;
        flex-direction: row;
        display: flex;
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
        align-self: flex-start;
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
<section class="landing flex-shrink-1 flex gap-5 flex-col items-center justify-around" style="padding-bottom: 25px;">
    <section class="landing flex-shrink-1 flex gap-5 flex-col items-center justify-around w-full">
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
        </section>
    </section>
    <section class="product-content">

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
                {{-- <a href="{{ route('guest.feedback') }}" style="display:flex; justify-content:center; align-items:center; padding:2px; color:white; background:skyblue;"><i class="fa fa-comments" style="font-size: 1.1rem; margin-right:13px;"></i>  View feedback</a> --}}
            </div>
        </div>
    </div>

    <style>
    .card,.card-feedback{
        flex:1;
        overflow-y: scroll;
        height: 70vh;
        border: none;

    }
    .card-feedback-comment{
        box-shadow: -3px 1px 18px 1px rgba(24,36,4,0.09);
        -webkit-box-shadow: -3px 1px 18px 1px rgba(24,36,4,0.09);
        -moz-box-shadow: -3px 1px 18px 1px rgba(24,36,4,0.09);
        display: flex;
        width: 100%;
        border-top: 1px solid #FFC0CB;
        border-bottom: 1px solid #FFC0CB;
        flex-direction: column;
        margin: 5px 0px;
    }
        .card-feedback .card-feedback-comment .feedback-header{
            padding: 10px;
            display: flex;
            flex-direction: row;
            gap: 10px;
        }
        .card-feedback .card-feedback-comment .feedback-header img{
            width: 150px;
            height: 120px;
        }

        .card-feedback .card-feedback-comment .feedback-header div{
            padding: 5px;
        }

    </style>

    @if (!is_null($product->feedback))
    <div class="card-feedback">
    @foreach ($product->feedback as $feedback)
        <div class="card-feedback-comment">
            <div class="feedback-header">
                <img src="{{ asset('images/test.jpg') }}" alt="">
                <div class="feedback-detail">
                    <p><b>{{ $feedback->user->name }}</b></p>
                    <div class="feedback-comment">
                        {{ $feedback->title }}
                    </div>
                    <div class="feedback-comment">
                        {{ $feedback->description }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
    @endif


    </section>

</section>

@endsection
