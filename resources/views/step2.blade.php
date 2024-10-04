@extends('layouts.front')

@section('content')

<section class="bg-white px-4 md:px-8 py-16 shadow-xl">

    @guest
    <div class="max-w-md font-mono">
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