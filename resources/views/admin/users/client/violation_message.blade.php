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
        height: 80vh;
        display: flex;
        flex-direction: column;
        margin-bottom: 50px;
    }
    article.report-list .fa{
        color: var(--fontNavy);
        margin: 20px 0px 0px 10px;
        padding: 5px 20px;
    }
    article.report-list .report-head{
        flex: 1;
        display: flex;
        justify-content: flex-start;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        padding: 30px;
        letter-spacing: 1px;
    }

    article.report-list .report-head h1{
        font-size: 1.8rem;
        font-weight: bold;
    }
    article.report-list .report-head p{
        font-size: 1.05rem;
    }
    article.report-list .report-head small{
        font-size: 1rem;
    }
    article.report-list .report-head > span{
        font-size: 0.9rem;
        font-weight: 500;
    }
    article.report-list .report-head > *{
        font-size: 1rem;
        color:#305c81; !important;
        font-family: 'Arial' !important;
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
        padding: 20px 30px;
        letter-spacing: 1.1px;
        flex: 6;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        font-family: 'Arial';
        background:white;
        color: #305c81;
    }
    article.report-list .report-footer{
        padding: 20px 30px;
        letter-spacing: 1.1px;
        flex: 6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Arial';
        color: #305c81;
        flex-direction: column;
    }

 article.report-list .report-body a {
        font-size: 1.1rem;
        color: white;

    }
  .report-text-area{

    width: 100%;
    padding: 10px;
    }
  .report-text-area:focus {
    outline: none !important;
    border:1px solid var(--fontNav);
    box-shadow: 0 0 5px #719ECE;
  }

  article.report-list .report-header-reply{
       display: flex;
       padding-top: 10px;
       justify-content: space-between;
       width: 100%;
  }
  article.report-list .report-header-reply div:nth-child(1){
       display: flex;
       flex-direction: column;
  }

</style>

<style>
    div.report-body div.report-list{
        display: flex;
        flex-direction: row;
        gap: 30px;
    }
    div.report-body div.report-list img{
        width: 180px;
    }

</style>

<section class="report-box">
    <article class="report-title">
        User Report Message
    </article>
    <article class="report-list">
        <div style="display: flex;">
            <a href="javascript:history.back()"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>

            @if ($report->notification===1)
            <a href="#report-box-reply"><i class="fa fa-envelope" aria-hidden="true"></i></a>
             <form method="POST" action="{{ route('admin.users.client.solve',$report->id) }}">
                @csrf
                {{ method_field('PATCH') }}
                <button type="submit"><i class="fa fa-check-circle"> Solve</i></button>
             </form>
            @else
            <form method="POST" action="#">
                @csrf
                {{ method_field('PATCH') }}
                <button type="submit"><i style="color: red;" class="fa fa-minus-circle"> Closed</i></button>
             </form>
            @endif

        </div>
        <div class="report-head" >
            <h1>{{ $report->title }}</h1>
            <p><i>From</i> : {{ $report->fromuser->name }}</p>
            <small><i>Email</i> : {{ $report->fromuser->name }}</small>
            <span><i>Date</i> : {{ date('M d D h:i:s a',strtotime($report->created_at ))}}</span>
            <span><i>Role </i> : {{ $report->fromuser->role->name }}</span>
        </div>

        <div class="report-body" style=" flex-direction:column; align-items:flex-start; gap:30px;">
            <div class="reprt-title"> {{ $report->description }}</div>
        </div>
    </article>
</section>


@foreach ($report->reply as $reply)
<section class="report-box">
    <article class="report-list" style="height: 0%;">
        <div class="report-header-reply">
          <div class="report-info">
            <span style="padding:10px 0px 0px 30px; color:#305c81;"><i>{{ $reply->user->name }}</i></span>
            <span style="padding:10px 0px 0px 30px; color:#305c81;"><i>{{ $reply->user->email }}</i></span>
            <span style="padding:10px 0px 0px 30px; color:#305c81;"><i>{{ date('M d D h:i:s a ',strtotime($reply->created_at ))}}</i></span>
          </div>
          <div style="display: flex;">

            @can('delete',$reply)
            <form method="POST" action="{{ route('admin.users.client.destroy',$reply->id) }}">
                @csrf
                {{method_field('delete')}}
                <button type="submit"><i style="margin: 0px !important; font-size:1.1rem; cursor: pointer;" class="fa fa-remove"></i></button>
            </form>
            @endcan
          </div>
        </div>
        <div class="report-body">
             {{ $reply->description }}
        </div>
    </article>
</section>
@endforeach

@if ($report->notification==1)
<section class="report-box" id="report-box-reply">
    <article class="report-list">
        <div class="report-head">
            <h1>{{ $report->title }}</h1>
            <p><i>From</i> : {{ $report->fromuser->name }}</p>
            <small><i>Email</i> : {{ $report->fromuser->email }}</small>
            <span><i>Date</i> : {{ date('M d D h:i:s a',strtotime($report->created_at ))}}</span>
            <span><i>Role </i> :{{ ucfirst( $report->fromuser->role->name ) }}</span>
        </div>
        <div class="report-footer">
            @error('textarea')
               <span style="padding:4px; background:red; color:white;"> {{ $message }}</span>
            @enderror
             <form  style="width:100%;" method="POST" action="{{ route('admin.users.client.store') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $report->id }}">
                <textarea name="textarea" placeholder="Enter your reply" class="report-text-area"cols="100%" rows="15"></textarea>
                <button class="ray-button-blue" style="margin-top: 20px;" type="submit">Reply</button>
            </form>
        </div>
    </article>
</section>

@endif
@endsection
