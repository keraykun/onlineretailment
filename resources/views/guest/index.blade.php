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
<section class="landing flex-shrink-1 flex flex-col items-center justify-around ">
    <article class="flex flex-col justify-center items-center gap-8 relative">
        <a href="{{ route('guest.product') }}" class="landing-leading bg-green-500 px-4 rounded-full font-bold text-white hover:bg-green-600 transition ease-in delay-150">Shop Now</a>
        <p class="landing-text w-96 text-lg">Lorem ipsum dolor sit amet consectetur, adipisicing elit.
            Earum voluptate officiis cumque, totam aperiam provident maiores maxime impedit voluptates pariatur possimus culpa optio molestias,
            fugiat, exercitationem delectus quidem. Soluta, rerum.</p>
            <div class="bubble-1"></div>
            <div class="bubble-2"></div>
            <div class="bubble-3"></div>
    </article>
    <section></section>
</section>
@endsection
