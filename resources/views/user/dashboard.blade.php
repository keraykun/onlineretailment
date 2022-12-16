@extends('layouts.user.sidenav')
@section('sidenav')


<style>
    section.report-box{
        display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 20px;
    }
    article.report-list{
        box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
        flex: 1 1 40%; /*grow | shrink | basis */
        height: 250px;
        display: flex;
        flex-direction: column;
    }
    article.report-list .report-head{
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
    article.report-list .report-head > *{
        font-size: 2rem;
        color:var(--fontNavy) !important; */
    }
    article.report-list div.report-head.report-user{
        /* background:var(--fontOrange) !important; */
    }
    article.report-list div.report-head.report-product{
        /* background:var(--fontOrange) !important; */
    }
    article.report-list div.report-head.report-violation{
        /* background:var(--fontOrange) !important; */
    }
    article.report-list div.report-head.report-feedback{
        /* background:var(--fontOrange) !important; */
    }

    article.report-list .report-body{
        background: purple;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    article.report-list .report-body a{
        font-size: 2.5rem;
        color: white;
        transition: font-size 100ms linear;
    }
    article.report-list .report-body a:hover{
        font-size: 2.6rem;
    }
</style>

<section class="report-box">
    <article class="report-list">
        <div class="report-head report-user">
            <i class="fa fa-shopping-basket"></i>
            <p>Order</p>
        </div>
        <div class="report-body">
            <a href="{{ route('user.orders.index') }}">{{ $order }}</a>
        </div>
    </article>
    <article class="report-list">
        <div class="report-head report-user">
            <i class="fa fa-shopping-cart"></i>
            <p>Cart</p>
        </div>
        <div class="report-body">
            <a href="{{ route('cart.index') }}">{{ $cart }}</a>
        </div>
    </article>
    <article class="report-list">
        <div class="report-head report-user">
            <i class="fa fa-heart"></i>
            <p>Wishlist</p>
        </div>
        <div class="report-body">
            <a href="{{ route('cart.wishlist.index') }}">{{ $wishlist }}</a>
        </div>
    </article>
    <article class="report-list">
        <div class="report-head report-violation">
            <i class="fa fa-exclamation-triangle"></i>
            <p>Violation Reports</p>
        </div>
        <div class="report-body">
            <a href="{{ route('user.violation.index') }}">{{ $violation }}</a>
        </div>
    </article>
    <article class="report-list">
        <div class="report-head">
            <i class="fa fa-comments-o report-feedback"></i>
            <p>Refund Reports </p>
        </div>
        <div class="report-body">
            <a href="{{ route('user.report.refund.index') }}">{{ $refund }}</a>
        </div>
    </article>
    <article class="report-list">
        <div class="report-head report-product">
            <i class="fa fa-history"></i>
            <p>Ordered History</p>
        </div>
        <div class="report-body">
            <a href="{{ route('user.history.index') }}">{{ $history }}</a>
        </div>
    </article>
</section>
@endsection
