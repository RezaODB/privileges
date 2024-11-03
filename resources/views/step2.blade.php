@extends('layouts.front')

@section('content')

<section class="bg-[#fdf2e3] p-3 pb-16 shadow-xl rounded-3xl">
    <h2 class="text-right text-2xl sm:text-4xl font-light mb-8">{{ Auth::id() ?? 'X' }}/250</h2>
    @guest
    <div class="max-w-md font-mono px-4">
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