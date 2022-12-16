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
        <form method="POST" action="{{ route('guest.authenticate') }}">
            @csrf
        @error('credential')<small class="text-red-600 text-center">{{ $message }}</small>@enderror
        <div class="bg-white shadow-sm rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
            <div class="mb-4">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                @error('email')<small class="text-red-600">{{ $message }}</small>@enderror
                </label>
                <input name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="email" type="text" placeholder="Email">
            </div>
            <div class="mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                @error('password')<small class="text-red-600">{{ $message }}</small>@enderror
                </label>
                <input name="password" class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" id="password" type="password" placeholder="******************">
                <p class="text-red text-xs italic">Please choose a password.</p>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" type="button">
                Sign In
                </button>
                <div class="flex gap-5 items-center">
                <button type="submit" class="bg-green-500 py-2 px-4 rounded-lg text-white hover:bg-green-400">Login</button>
                <a class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker" href="#">
                    Forgot Password?
                </a>
                </div>
            </div>
        </div>
        </form>
    </div>
<section>

 @endsection
