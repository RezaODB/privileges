@extends('layouts.front')

@section('content')

<section class="bg-white py-16 px-4 sm:px-8 shadow-xl relative">
    <div class="absolute inset-0 mix-blend-luminosity pointer-events-none brightness-110" style="background-image: url({{ asset('paper.png') }}); background-size: 100% auto"></div>
    <h1 class="relative text-2xl sm:text-4xl font-medium uppercase mb-12">{{ __('content.step2') }}</h1>
    
    @guest
    <div class="max-w-md font-mono relative">
        @if (App::isLocale('en'))
        Please <a href="{{ route('index', ['login' => 'yes']) }}" class="underline">sign in</a> before proceeding to the questionnaire.
        @endif
        @if (App::isLocale('fr'))
        Merci de vous <a href="{{ route('index', ['login' => 'yes']) }}" class="underline">connecter à votre compte</a> afin de répondre au questionnaire.
        @endif
    </div>
    @endguest
    
    @auth
    @livewire('quotas')
    @endauth
</section>

@endsection