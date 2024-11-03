@extends('layouts.front')

@section('content')

<section class="grid grid-cols-1 md:grid-cols-2 items-start gap-8 border-b-2 border-zinc-800 pb-12 px-2 mt-8">

    <div class="md:justify-self-start">
        <div class="uppercase font-medium border-2 border-zinc-800">
            <h1 class="text-3xl sm:text-4xl p-4 text-center">Les privilèges invisibles</h1>
            <h2 class="text-5xl text-center p-4 border-y-2 border-zinc-800"><span class="text-3xl">N°</span> {{ Auth::id() ?? 'x' }}/250</h2>
            <div class="flex text-xl border-b-2 border-zinc-800">
                <a href="https://www.barbaraiweins.be/" target="_blank" class="border-r-2 border-zinc-800 p-4 text-right hover:bg-zinc-800/10">
                    <h3>{{ __('content.socioartystudy') }}</h3>
                    <h2 class="mt-2">Barbara Iweins</h2>
                </a>
                <h3 class="p-4 self-center mx-auto">2024/2025</h3>
            </div>
            <div class="flex text-xl justify-evenly text-center uppercase">
                <a href="{{ route('instructions') }}" class="p-4 hover:bg-zinc-800/10">{{ __('content.instructions') }}</a>
                <a href="{{ route('faq') }}" class="uppercase p-4 border-x-2 border-zinc-800 hover:bg-zinc-800/10">F.A.Q.</a>
                <div class="flex gap-1 p-3 items-center">
                    <a href="{{ route('index', ['lang' => 'fr']) }}" class="{{ App::getLocale() === 'fr' ? 'underline' : '' }}">FR</a>/
                    <a href="{{ route('index', ['lang' => 'en']) }}" class="{{ App::getLocale() === 'en' ? 'underline' : '' }}">EN</a>
                </div>
            </div>
        </div>
        <div class="mt-8">
            <h2 class="font-bold mb-1">CONTACT: </h2>
            <div class="font-mono">
                <a href="mailto:lesprivilegesinvisibles@gmail.com" target="_blank" class="block hover:underline">lesprivilegesinvisibles@gmail.com</a>
                <a href="tel:0032472612641" target="_blank" class="block hover:underline">+32(0)472612641</a>
                <a href="https://www.instagram.com/barbaraiweins/" target="_blank" class="block hover:underline">Instagram</a>
            </div>
        </div>
    </div>

    @guest
    @if (request()->query('login') === 'yes')
    <form action="{{ route('login') }}" method="post" class="font-mono">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 sm:divide-x-2 divide-zinc-800 border-2 border-zinc-800">
            <div class="p-2">
                <label for="email" class="uppercase font-bold text-sm">1. Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="border-none w-full focus:ring-0" required>
                @error('email')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="p-2">
                <label for="password" class="uppercase font-bold text-sm">2. {{ __('content.password') }}</label>
                <input type="password" name="password" id="password" class="border-none w-full focus:ring-0" required>
                @error('password')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <input type="hidden" name="remember" value="yes">
        <div class="flex flex-wrap gap-4 items-center mt-4">
            <button type="submit" class="border-2 border-zinc-800 font-bold py-2 px-4 uppercase">{{ __('content.sign_in') }}</button>
            <a href="{{ route('index', ['login' => 'no']) }}" class="underline">{{ __('content.create_account') }}</a>
            <a href="{{ route('password.request') }}" class="underline">{{ __('content.password_forgotten') }}</a>
        </div>
    </form>    
    @else
    <form action="{{ route('register') }}" method="post" class="font-mono">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 sm:divide-x-2 divide-zinc-800 border-2 border-zinc-800">
            <div class="p-2">
                <label for="lastname" class="uppercase font-bold text-sm">1. {{ __('content.lastname') }}</label>
                <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" class="border-none w-full focus:ring-0" autofocus required>
                @error('lastname')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="p-2">
                <label for="name" class="uppercase font-bold text-sm">2. {{ __('content.firstname') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="border-none w-full focus:ring-0" required>
                @error('name')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 sm:divide-x-2 divide-zinc-800 border-x-2 border-zinc-800">
            <div class="p-2">
                <label for="birthday" class="uppercase font-bold text-sm">3. {{ __('content.birthday') }}</label>
                <input type="date" name="birthday" id="birthday" value="{{ old('birthday') }}" class="border-none w-full focus:ring-0" required>
                @error('birthday')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="p-2">
                <label for="zip" class="uppercase font-bold text-sm">4. {{ __('content.zip') }}</label>
                <input type="text" name="zip" id="zip" value="{{ old('zip') }}" class="border-none w-full focus:ring-0" required>
                @error('zip')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 sm:divide-x-2 divide-zinc-800 border-x-2 border-t-2 border-zinc-800">
            <div class="p-2">
                <label class="uppercase font-bold text-sm">5. {{ __('content.sex') }}</label>
                <div class="flex gap-2 items-center">
                    <input type="radio" id="male" name="sex" value="male" class="border-none text-zinc-800 rounded-none focus:ring-0 checked:bg-none" {{ old('sex') === 'male' ? 'checked' : '' }} required>
                    <label for="male" class="mr-2 text-sm uppercase">{{ __('content.male') }}</label>
                    <input type="radio" id="female" name="sex" value="female" class="border-none text-zinc-800 rounded-none focus:ring-0 checked:bg-none" {{ old('sex') === 'female' ? 'checked' : '' }} required>
                    <label for="female" class="mr-2 text-sm uppercase">{{ __('content.female') }}</label>
                    <input type="radio" id="other" name="sex" value="other" class="border-none text-zinc-800 rounded-none focus:ring-0 checked:bg-none" {{ old('sex') === 'other' ? 'checked' : '' }} required>
                    <label for="other" class="mr-2 text-sm uppercase">{{ __('content.other') }}</label>
                </div>
                @error('sex')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="p-2">
                <label for="phone" class="uppercase font-bold text-sm">6. {{ __('content.phone') }}</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="border-none w-full focus:ring-0" required>
                @error('phone')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 sm:divide-x-2 divide-zinc-800 border-x-2 border-t-2 border-zinc-800">
            <div class="p-2">
                <label for="email" class="uppercase font-bold text-sm">7. Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="border-none w-full focus:ring-0" required>
                @error('email')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 sm:divide-x-2 divide-zinc-800 border-2 border-zinc-800">
            <div class="p-2">
                <label for="password" class="uppercase font-bold text-sm">8. {{ __('content.password') }}</label>
                <input type="password" name="password" id="password" class="border-none w-full focus:ring-0" required autocomplete="new-password">
                @error('password')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="p-2">
                <label for="password_confirmation" class="uppercase font-bold text-sm">9. {{ __('content.password_confirmation') }}</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="border-none w-full focus:ring-0" required autocomplete="new-password">
                @error('password_confirmation')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="flex gap-4 mt-4">
            <input type="checkbox" name="policy" id="policy" class="border-none text-zinc-800 focus:ring-0 checked:bg-none">
            <label for="policy" class="text-sm uppercase">
                @if (app()->isLocale('fr'))
                Je déclare avoir lu et approuvé les <a href="{{ route('policy') }}" class="underline">conditions d'utilisation</a> du site.
                @else
                I declare that I have read and approved the <a href="{{ route('policy') }}" class="underline">terms of use</a> of the site.
                @endif
            </label>
        </div>
        @error('policy')<div class="text-red-500 uppercase text-sm">{{ $message }}</div>@enderror
        <div class="flex gap-4 items-center mt-4">
            <button type="submit" class="border-2 border-zinc-800 font-bold py-2 px-4 uppercase hover:bg-zinc-800/10">{{ __('content.create_account') }}</button>
            <a href="{{ route('index', ['login' => 'yes']) }}" class="underline">{{ __('content.already_registered') }}</a>
        </div>
    </form>   
    @endif
    @endguest
    @auth
    <ul class="font-mono p-4 bg-gray-50">
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

</section>

@endsection