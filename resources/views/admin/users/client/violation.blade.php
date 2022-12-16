@extends('layouts.admin.sidenav')
@section('sidenav')

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
        flex: 1;
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
</style>

<section class="report-box">
    <article class="report-title">
        Violation of <u style="margin-left: 10px;">{{ $data->name }}</u>
    </article>
    <article class="report-title" style="background: white; color:#0e86d4;">
        <a href="{{ route('admin.users.client.show',$data->id) }}" class="btn btn-navy">
            Create Message Violation <i style="margin-left: 10px;" class="fa fa-envelope"></i>
        </a>
    </article>
     @foreach ($reports as $report)
    <article class="report-list">
        <div class="report-image" >
            @if (userProfileAuth($report->from_user_id)->image!=null)
            <img src="{{ asset('storage/users/'.userProfileAuth($report->from_user_id)->image->name) }}" alt="">
             @else
            <img src="{{ asset('images/test.jpg') }}" alt="">
            @endif
       </div>
        <div class="report-head">
            <p>{{ $report->title }}</p>
        </div>
        <div class="report-body">
            <a href="{{ route('admin.users.client.message',$report) }}">View Report <i style="font-size: 1.1rem; margin-left:10px;" class="fa fa-eye"></i></a>
            @csrf
         @if ($report->notification!=0)
            <p style="color:white;">Active</p>
            @else
            <p style="color:white;">Closed</p>
            @endif
        </div>
    </article>
     @endforeach
</section>
@endsection
