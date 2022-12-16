@extends('layouts.header.app')
@section('content')

<div class="bubble-4"></div>
<div class="bubble-5"></div>
<div class="bubble-6"></div>
<div class="bubble-7"></div>
<section class="shoes overflow-hidden bg-yellow-600 flex flex-col justify-center items-center flex-shrink-1">
    <img src="{{ asset('images/sneaker.png') }}" class="shoes-img"  alt="">
    <p class="shoes-title">Sneakers </p>
    <small>the best shoes in the world</small>
</section>
<section class="landing flex-shrink-1 flex flex-col p-5 items-center justify-around ">
    <div class="w-full py-auto mx-auto px-auto">
        <div class="card"  style="font-size: 1.2rem;">
            <div class="card-header">{{ __('Verify Your Email Address') }}</div>
            <div class="card-body">
                @if (session('resent'))
                    <div style="padding:2px 5px;" class="alert alert-success bg-success p-" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif
               <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
               <p> {{ __('If you did not receive the email') }},</p>
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button class="bg-navy p-2 rounded-lg" type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Click here to request another') }}</button>.
                </form>
            </div>
        </div>
    </div>
<section>

 @endsection
