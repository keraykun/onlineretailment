@extends('layouts.header.app')
@section('content')
    <!---->

<div class="bubble-4"></div>
<div class="bubble-5"></div>
<div class="bubble-6"></div>
<div class="bubble-7"></div>
<section class="shoes overflow-hidden bg-yellow-600 flex flex-col justify-center items-center flex-shrink-1">
<img src="{{ asset('images/sneaker.png') }}" class="shoes-img"  alt="">
<p class="shoes-title">Sneakers </p>
<small>the best shoes in the world</small>
</section>
<div class="landing flex-shrink-1 flex flex-col p-5 items-center justify-around ">
<div class="w-full py-auto mx-auto px-auto">
    <form method="POST" action="{{ route('guest.validator') }}">
        @csrf
    @error('credential')<small class="text-red-600 text-center">{{ $message }}</small>@enderror
    <div class="bg-white shadow-sm rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
        <div class="mb-4">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
            @error('name')<small class="text-red-600">{{ $message }}</small>@enderror
            </label>
            <input name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="name" type="text" placeholder="Name">
        </div>
        <div class="mb-4">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
                @error('email')<small class="text-red-600">{{ $message }}</small>@enderror
            </label>
            <input name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="email" type="text" placeholder="Email">
            </div>
            <div class="mb-4">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                @error('password')<small class="text-red-600">{{ $message }}</small>@enderror
            </label>
            <input name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="password" type="password" placeholder="Password">
            </div>
            <div class="mb-4">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="confirmpassword">
                @error('confirmpassword')<small class="text-red-600">{{ $message }}</small>@enderror
            </label>
            <input name="confirmpassword" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="confirmpassword" type="password" placeholder="Confirm password">
            </div>
            <label class="block text-grey-darker text-sm font-bold mb-2" for="confirmpassword">
                @error('role')<small class="text-red-600">{{ $message }}</small>@enderror
            </label>
            <div class="flex items-center">
                <select name="role" style="color:gray; letter-spacing:1.2px;" class="shadow appearance-none border rounded w-64 mr-5 py-2 px-3 text-grey-darker" name="" id="">
                    <option value="none" selected disabled hidden>Select account</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
                 <button type="submit" class="bg-green-500 py-2 px-4 rounded-lg text-white hover:bg-green-400">Register</button>
            </div>
    </div>
    </form>
</div>
    <div>

@endsection
