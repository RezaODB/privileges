@extends('layouts.front')

@section('content')

<section class="sm:px-4 border-b-2 border-black py-12 sm:py-24 grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
    @guest
    @if (request()->query('login') === 'yes')
    <form action="{{ route('login') }}" method="post" class="grid grid-cols-1 gap-4 font-mono max-w-md">
        @csrf
        <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" class="border-none w-full focus:ring-0" required>
        @error('email')<div class="text-red-500">{{ $message }}</div>@enderror
        <input type="password" name="password" id="password" placeholder="Mot de passe" class="border-none w-full focus:ring-0" required>
        @error('password')<div class="text-red-500">{{ $message }}</div>@enderror
        <input type="hidden" name="remember" value="yes">
        <div class="flex gap-4 items-center mt-4">
            <button type="submit" class="bg-black text-white py-2 px-4 uppercase">{{ __('content.sign_in') }}</button>
            <a href="{{ route('index', ['login' => 'no']) }}" class="underline">{{ __('content.create_account') }}</a>
        </div>
    </form>    
    @else
    <form action="{{ route('register') }}" method="post" class="grid grid-cols-1 gap-4 font-mono max-w-md">
        @csrf
        <input type="text" name="name" id="name" placeholder="{{ __('content.firstname') }}" value="{{ old('name') }}" class="border-none w-full focus:ring-0" required>
        @error('name')<div class="text-red-500">{{ $message }}</div>@enderror
        <input type="text" name="lastname" id="lastname" placeholder="{{ __('content.lastname') }}" value="{{ old('lastname') }}" class="border-none w-full focus:ring-0" required autofocus>
        @error('lastname')<div class="text-red-500">{{ $message }}</div>@enderror
        <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" class="border-none w-full focus:ring-0" required>
        @error('email')<div class="text-red-500">{{ $message }}</div>@enderror
        <input type="password" name="password" id="password" placeholder="Mot de passe" class="border-none w-full focus:ring-0" required>
        @error('password')<div class="text-red-500">{{ $message }}</div>@enderror
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmer le mot de passe" class="border-none w-full focus:ring-0" required>
        @error('password_confirmation')<div class="text-red-500">{{ $message }}</div>@enderror
        <div class="flex gap-4 items-center mt-4">
            <button type="submit" class="bg-black text-white py-2 px-4 uppercase">{{ __('content.create_account') }}</button>
            <a href="{{ route('index', ['login' => 'yes']) }}" class="underline">{{ __('content.already_registered') }}</a>
        </div>
    </form>   
    @endif
    @endguest
    @auth
    <ul class="font-mono max-w-md p-4 bg-white">
        <li>{{ __('content.lastname') }}: {{ Auth::user()->lastname }}</li>
        <li>{{ __('content.firstname') }}: {{ Auth::user()->name }}</li>
        <li>Email: {{ Auth::user()->email }}</li>
        <li>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="underline mt-4">{{ __('content.sign_out') }}</button>    
            </form> 
        </li>
    </ul>   
    @endauth

    <div class="sm:ml-auto">
        <div class="mb-2">
            <span class="uppercase font-medium mr-4">{{ __('content.lang') }}: </span>
            <a href="{{ route('index', ['lang' => 'fr']) }}" class="font-mono hover:underline {{ App::getLocale() === 'fr' ? 'underline' : '' }}">FR</a> /
            <a href="{{ route('index', ['lang' => 'en']) }}" class="font-mono hover:underline {{ App::getLocale() === 'en' ? 'underline' : '' }}">EN</a>
        </div>
        <div class="uppercase font-medium border-2 border-black max-w-md">
            <h1 class="text-3xl p-2 text-center">Les privilèges invisibles</h1>
            <h2 class="text-6xl text-center p-4 border-y-2 border-black"><span class="text-3xl">N°</span> {{ Auth::id() ?? 'x' }}/250</h2>
            <div class="flex">
                <div class="border-r-2 border-black p-4 text-right">
                    <h3 class="text-xl">Étude socio-artistique</h3>
                    <h3 class="text-xl mt-2">Barbara Iweins</h3>
                </div>
                <h3 class="p-4 text-xl mt-2">2024/2025</h3>
            </div>
        </div>
    </div>
</section>

@endsection