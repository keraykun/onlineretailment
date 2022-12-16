@extends('layouts.header.app')
@section('content')
<style>
    section.container{
        display: flex;
        flex-direction: row;
        align-items: stretch;
          overflow-y: scroll;
    }
    aside.aside-content{
        /* border-right: 1px solid var(--fontNavy); */
        box-shadow: rgba(99, 99, 99, 0.2) 0px -10px 2px 0px,
         rgba(99, 99, 99, 0.2) 0px -50px 8px 0px;
        width: 15%;
    }
    aside.aside-content div.aside-profile{
        width: 100%;
        padding: 5px;
        border-bottom: 1px solid var(--fontNavy);
        border-left: none;
        border-top: none;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    aside.aside-content div div.aside-img{
        background: white;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
        overflow: hidden;
    }
    aside.aside-content div div.aside-img img{

    }

    aside.aside-content div div.aside-tagname{

        margin-top: 5px;
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 5px;
        font-weight: bold;
        color: #658397;
        margin-bottom: 10px;
    }
    section aside ul.aside-ul{
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin: 5px 10x 10px 10px;
    }
    section aside ul.aside-ul li{
        display: flex;
        justify-content: flex-start;
        align-items: center;
        color: var(--fontText);
        padding: 10px 0px 10px 10px;
        border:none;
        border-bottom: 1px solid var(--fontNavy);
        cursor: pointer;
    }

    section aside ul.aside-ul li.active{
        background: var(--fontNavy);
        color: white;
    }

    section aside ul.aside-ul li i, section aside ul.aside-ul li a{
        font-size: 1rem;
    }
    section aside ul.aside-ul li:hover{
        background: var(--fontNavy);
        color: white;
    }
    section aside ul.aside-ul li a{
        margin-top: 5px;
        margin-left: 10px;
    }

    main.main-content{
        /* background: red; */
        width: 100%;
        height: 90vh;
        padding: 20px;
    }

</style>
<style>
        section.report-box{
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 20px;
    }
    article.report-title{
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        flex: 1 1 100%; /*grow | shrink | basis */
        height: 50px;
        display: flex;
        flex-direction: row;
        font-size: 1.2rem;
        color: white;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        letter-spacing: 1px;
        background: var(--fontNavy);
    }
    article.report-list{
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        flex: 1 1 100%; /*grow | shrink | basis */
        height: 50px;
        display: flex;
        flex-direction: row;
    }
    article.report-list .report-head{
        flex: 7;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
    article.report-list .report-head > *{
        font-size: 1rem;
        color:var(--fontNavy) !important; */

    }
    article.report-list .report-image{
        width: 100px;
        overflow: hidden;
        position: relative;
    }
    article.report-list .report-image img{
        left: 0%;
        top: -50%;
        position: absolute;
        padding: 2px;
        background: var(--fontNavy);
    }

    article.report-list .report-body{
        background: purple;
        flex: 2;
        display: flex;
        align-items: center;
        justify-content: space-around;
    }
    article.report-list .report-body a {
        font-size: 1.1rem;
        color: white;
    }

    .search-box{
        width: 100%;
        display: flex;
        justify-content: center;
    }
    .search-box form{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .search-box form input[type="search"]{
        border: 0.5px solid skyblue;
        outline: 0;
        padding: 5px 10px;
        margin: 0px 20px;
    }
    .search-box form input[type="search"]:focus{
        border: 1px solid var(--fontNavy);

    }
    .search-box form button[type="submit"]{
        background: var(--fontNavy);
        padding: 5px 10px;
        border: 5px;
        color: azure;
    }
    .carretClass{
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
        padding: 5px 10px;
        cursor: pointer;
        display: none;
    }
    #carret-ul{
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .ul-carret{
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: start;
        width: 100%;
    }
    .ul-carret-none{
        display: none;
    }
    .ul-carret .li-carret{
        text-decoration: none !important;
        border: none;
        color: black;
        padding: 0px !important;
    }

</style>

<section class="container w-full flex flex-col justify-center items-center flex-shrink-1">
   <aside class="aside-content">
        <div class="aside-profile">
            <div class="aside-img">
                 @if (userProfilePicture()->image!=null)
                 <img src="{{ asset('storage/users/'.userProfilePicture()->image->name) }}" alt="">
                @else
                <img src="{{ asset('images/test.jpg') }}" alt="">
                 @endif
            </div>
            <div class="aside-tagname">
                <i class="fa fa-user-circle-o"></i> <span style="margin-top: 5px;">{{ Str::ucfirst(Auth::user()->role->name) }}</span></div>
            </div>
        <ul class="aside-ul">
            <li class="aside-list {{ Route::is('client.dashboard*')?'active':'' }}"><i class="fa fa-bar-chart"></i><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
            <li class="aside-list  {{ Route::is('client.order*')?'active':''}}"><i class="fa  fa-cart-arrow-down"></i><a href="{{ route('client.order.user.index') }}">Order</a></li>
            <li class="aside-list {{ Route::is('client.product*')?'active':''}}" ><i class="fa fa-list"></i><a href="{{ route('client.product.index') }}">Products</a></li>
            <li class="aside-list {{ Route::is('client.history*')?'active':''}}" ><i class="fa fa-dashboard"></i><a href="{{ route('client.history.index') }}">Products History</a></li>
            {{-- <li class="aside-list {{ Route::is('client.productsold*')?'active':''}}" ><i class="fa fa-list-alt"></i><a href="{{ route('client.product.index') }}">Products Sold</a></li> --}}
            {{-- <li class="aside-list {{ Route::is('client.order*')?'active':''}}" id="carret-ul">
                <span><i class="fa fa-cart-arrow-down" aria-hidden="true"></i><a href="#">Order</a> <i class="fa fa-caret-down"></i></span>
                <ul class="ul-carret ul-carret-none">
                    <li class="li-carret {{ Route::is('client.*')?'active':''}}"><a href="{{ route('client.order.client.index') }}"><i class="fa fa-minus"> </i> <span style="margin-left:10px;">My Order</span></a></li>
                    <li class="li-carret {{ Route::is('client.*')?'active':''}}"><a href="{{ route('client.order.user.index') }}"><i class="fa fa-minus"> </i>  <span style="margin-left:10px;">User Order</span></a></li>
                </ul>
            </li> --}}
            <li class="aside-list  {{ Route::is('client.printer*')?'active':''}}"><i class="fa fa-print"></i><a href="{{ route('client.printer.index') }}">Printer</a></li>
            <li class="aside-list {{ Route::is('client.report*')?'active':''}}"><i class="fa fa-file"></i><a href="{{ route('client.report.list.index') }}">Reports</a></li>
            <li class="aside-list {{ Route::is('client.setting*')?'active':''}}"><i class="fa fa-cog"></i><a href="{{ route('client.setting.index') }}">Settings</a></li>
            <li class="aside-list"><i class="fa fa-power-off"></i><a href="{{ route('guest.logout') }}">Sign Out</a></li>
        </ul>
   </aside>
   <main class="main-content">
        @yield('sidenav')
   </main>
</section>
<script>
    document.querySelector('#carret-ul').addEventListener('click',function(){
        let ulCarret = document.querySelector('.ul-carret')
        if(ulCarret.classList.contains('ul-carret-none')){
            ulCarret.classList.remove('ul-carret-none')
        }else{
            ulCarret.classList.add('ul-carret-none')
        }
    })
</script>
@endsection
