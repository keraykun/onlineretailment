@extends('layouts.admin.sidenav')
@section('sidenav')
<style>
    section.section-list-user{
        height: 80vh;
        display: flex;
        flex-direction: column;
    }
    section .section-list-profile{
        align-self: flex-start;
        flex: 1;
        display: flex;
        padding: 10px;
        margin: 10px;
        width: 100%;
    }
    section .section-list-detail{
        flex: 2;
    }
    section article div.section-list-img{
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 20px;
        width: 100%
    }
    section article div.section-list-img img{
        width: 200px;
        height: 200px;
        border-radius: 50%;
    }
    section article div.section-list-div{
        font-size: 1rem;
        color: #5896bf;
        letter-spacing: 1px;
        width: 100%;
    }
    section article div.section-list-div p u{
        width: 100% !important;
    }
</style>
<style>

    .doughnut .section-list{
        display: flex;
        gap: 20px;
        flex-direction: column;
    }
    .doughnut .section-list section{
        background: red;
        background: var(--fontNavy);
        padding: 5px;
        font-size: 1.5rem;
        display: flex;
        border-radius: 10px;
        align-items: center;
        color: white;
    }
    i.section-list.fa{
        color: white;
        font-size: 2rem;
        border: 1px solid white;
        border-radius: 50%;
        padding: 10px;
        margin: 5px;
    }
</style>
<a class="btn btn-default" href="{{ route('admin.users.index') }}">Back</a>
<section class="section-list-user">
    <article class="section-list-profile">
       <div class="section-list-img">
        @if (userProfileAuth($user->id)->image!=null)
        <img src="{{ asset('storage/users/'. userProfileAuth($user->id)->image->name) }}" alt="">
        @else
        <img src="{{ asset('images/test.jpg') }}" alt="">
        @endif

        @if($user->role->name=='client')
        <div class="section-list-div">
            <p><span><b>Name</b> : </span> <u>{{ $user->name }}</u></p>
            <p><span><b>Email</b> : </span> <u>{{ $user->email }}</u></p>
            <p><span><b>Role</b> : </span> <u>{{ucfirst($user->role->name) }}</u></p>
            <p><span><b>Total Products</b> : </span> <u>{{ $user->products->count() }}</u></p>
            <p><span><b>Total Sold</b> : </span><u> {{ $user->productsold->where('status','delivered')->count() }}</u></p>
            <p><span><b>Total Revenue</b> : </span> <u>+ {{ number_format($user->productsold->sum('price'),2) }}</u></p>
            <p><span><b>Member sinced </b>: </span> <u>{{ date('M d Y', strtotime($user->created_at)) }}</u></p>
        </div>
        @elseif($user->role->name=='user')
        <div class="section-list-div">
            <p><span><b>Name</b> : </span> <u>{{ $user->name }}</u></p>
            <p><span><b>Email</b> : </span> <u>{{ $user->email }}</u></p>
            <p><span><b>Role</b> : </span> <u>{{ucfirst($user->role->name) }}</u></p>
            <p><span><b>Delivered</b> : </span> <u>{{ $user->orderstatus->where('status','delivered')->count() }}</u></p>
            <p><span><b>Cancelled</b> : </span><u> {{ $user->orderstatus->where('status','cancelled')->count() }}</u></p>
            <p><span><b>Refund</b> : </span><u> {{ $user->orderstatus->where('status','refund')->count() }}</u></p>
            <p><span><b>Total Spent</b> : </span> <u>+ {{ number_format($user->orderstatus->where('status','delivered')->sum('price'),2) }} ( Except "Refund" and "Cancelled" )</u></p>
            <p><span><b>Member sinced </b>: </span> <u>{{ date('M d Y', strtotime($user->created_at)) }}</u></p>
        </div>
        @endif
       </div>
    </article>
    <article class="section-list-detail">
        @if($user->role->name=='client')
        <article class="doughnut">
            <div class="section-list">
              <section>
                    <i class="section-list fa fa-shopping-basket"></i>
                    <span style="margin-right:20px;">Products : </span>
                     <div style="width: 50%; display:flex; justify-content:space-between;"><span>{{ $user->products->count() }}</span> <a href="{{ route('admin.users.client.show',$user->id) }}">Show <i class="fa fa-eye"></i></a></div>
              </section>
              <section>
                   <i class="section-list fa fa-history"></i>
                   <span style="margin-right:20px;">Products History : </span>
                   <div style="width: 50%; display:flex; justify-content:space-between;"><span>{{ $user->productsold->count()}} </span> <a href="{{ route('admin.users.client.history',$user->id) }}">Show <i class="fa fa-eye"></i></a></div>
              </section>
              <section>
                <i class="section-list fa fa-warning"></i>
                <span style="margin-right:20px;">Violation : </span>
                 <div style="width: 50%; display:flex; justify-content:space-between;"><span>{{ $user->violations->count() }}</span> <a href="{{ route('admin.users.client.violation',$user->id) }}">Show <i class="fa fa-eye"></i></a></div>
              </section>
           </div>
       </article>
       @elseif($user->role->name=='user')
       <article class="doughnut">
        <div class="section-list">
          <section>
                <i class="section-list fa fa-shopping-basket"></i>
                <span style="margin-right:20px;">Ordered : </span>
                 <div style="width: 50%; display:flex; justify-content:space-between;"><span>{{ $user->orders->count() }}</span> <a href="{{ route('admin.users.user.show',$user->id) }}">Show <i class="fa fa-eye"></i></a></div>
          </section>
          <section>
            <i class="section-list fa fa-heart"></i>
            <span style="margin-right:20px;">Wishlist : </span>
             <div style="width: 50%; display:flex; justify-content:space-between;"><span>{{ $user->wishlist->count() }}</span> <a href="{{ route('admin.users.user.wishlist',$user->id) }}">Show <i class="fa fa-eye"></i></a></div>
      </section>
          <section>
               <i class="section-list fa fa-history"></i>
               <span style="margin-right:20px;">Ordered History : </span>
               <div style="width: 50%; display:flex; justify-content:space-between;"><span>{{ $user->orderstatus->count()}} </span> <a href="{{ route('admin.users.user.history',$user->id) }}">Show <i class="fa fa-eye"></i></a></div>
          </section>
          <section>
            <i class="section-list fa fa-warning"></i>
            <span style="margin-right:20px;">Violation : </span>
             <div style="width: 50%; display:flex; justify-content:space-between;"><span>{{ $user->violations->count() }}</span> <a href="{{ route('admin.users.user.violation',$user->id) }}">Show <i class="fa fa-eye"></i></a></div>
          </section>
       </div>
   </article>
       @endif
    </article>

</section>
@endsection
