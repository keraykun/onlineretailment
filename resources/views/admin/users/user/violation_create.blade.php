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
        padding: 20px 30px 0px 30px;
        margin-top: 20px;
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
        padding: 0px 30px;
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
    .report-head .form-group{
        font-size: 1.2rem !important;
    }
    .report-head .form-group .form-control{
        outline: 0;
        border: none;
        border-bottom: 1px solid var(--fontClay);
    }
</style>

@if(Session::has('success'))
    <p style="color:green;">{{ Session::get('success') }}</p>
@endif
<section class="report-box">
    <article class="report-title">
        Create Message Violation <i style="margin-left: 10px;" class="fa fa-envelope"></i>
    </article>
</section>
<section class="report-box" id="report-box-reply">
    <form  style="width:100%;" method="POST" action="{{ route('admin.users.user.create') }}">
        @csrf
    <article class="report-list">
        <div class="report-head">
            <div class="form-group" >
                <label for="">Title</label>
                <input name="title" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="">To</label>
                <select class="form-control" name="user_id" id="">
                    <option value="{{ $data->id }}">{{ $data->name }} ( {{ Str::ucfirst( $data->role->name) }} )</option>
                </select>
            </div>
        </div>
        <div class="report-footer">
            <textarea name="description" placeholder="Enter your reply" class="report-text-area"cols="100%" rows="15"></textarea>
            <button class="ray-button-blue" style="margin-top: 20px;" type="submit">Report</button>
        </div>
    </article>
    </form>
</section>

@endsection
