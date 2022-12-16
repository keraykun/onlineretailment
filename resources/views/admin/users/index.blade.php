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
        Users List
    </article>
    <div class="search-box">
        <form class="w-full" action="{{ route('admin.users.index') }}">
            <i class="fa fa-search"></i>
            <input placeholder="Search"  type="search" name="search">
            <button type="submit">Search</button>
        </form>
    </div>

    <style>
        .carretClass{
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
            padding: 5px 10px;
            cursor: pointer;
            display: none;
        }
    </style>

    @foreach ($users as $user)
    <article class="report-list">
       <div class="report-image" >
        @if (userProfileAuth($user->id)->image!=null)
            <img src="{{ asset('storage/users/'. userProfileAuth($user->id)->image->name) }}" alt="">
            @else
            <img src="{{ asset('images/test.jpg') }}" alt="">
            @endif
       </div>
        <div class="report-head">
            <p>{{ $user->name }}</p>
        </div>
        <div class="report-head">
            <p>{{ Str::ucfirst($user->role->name) }}</p>
        </div>
         <div class="report-head">

            @switch($user->state->status)
                @case('ban')
                <form style="display: flex;" method="POST" action="{{ route('admin.users.status') }}">
                    @csrf
                    {{ method_field('PATCH') }}
                    <input name="id" type="hidden" value="{{ $user->id }}">
                    <input name="estate" type="hidden" value="active">
                    <p style="color:red !important; margin-right:10px;">{{ Str::ucfirst($user->state->status) }}</p>
                    <i onclick="document.getElementById('carret-{{ $user->id }}').style.display = 'inline';" class="fa fa-caret-down"></i>
                    <button type="submit" class="carretClass" id="carret-{{ $user->id }}">Active</button>
                </form>
                @break

                @case('active')
                <form style="display: flex;" method="POST" action="{{ route('admin.users.status') }}">
                    @csrf
                    {{ method_field('PATCH') }}
                    <input name="id" type="hidden" value="{{ $user->id }}">
                    <input name="estate" type="hidden" value="ban">
                   <p  style="color:green !important; margin-right:10px;">{{ Str::ucfirst($user->state->status) }}</p>
                   <i onclick="document.getElementById('carret-{{ $user->id }}').style.display = 'inline';"  class="fa fa-caret-down"></i>
                   <button type="submit" class="carretClass" id="carret-{{ $user->id }}">Ban</button>
                </form>
                   @break
                @default
            @endswitch

        </div>
        <div class="report-body">
            <a href="{{ route('admin.users.show',$user->id) }}"><i style="font-size: 1.1rem;" class="fa fa-eye"></i></a>
        </div>
    </article>
    @endforeach
    {{ $users->withQueryString()->links('pagination::bootstrap-4') }}
</section>
@endsection
