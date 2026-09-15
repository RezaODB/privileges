@extends('layouts.front')

@section('content')

<section class="sheet p-3 pb-16 shadow-xl">

    <h2 class="text-right text-2xl sm:text-4xl font-serif mb-8">{{ Auth::user()->order ?? 'X' }}/250</h2>

    @guest
    <div class="max-w-md font-mono px-2 sm:px-8">
        @if (App::isLocale('en'))
        Please <a href="{{ route('index', ['login' => 'yes']) }}" class="underline">sign in</a> before proceeding to the page.
        @endif
        @if (App::isLocale('fr'))
        Merci de vous <a href="{{ route('index', ['login' => 'yes']) }}" class="underline">connecter à votre compte</a> afin de poursuivre la lecture.
        @endif
    </div>
    @endguest

    @auth
    @foreach ($items as $item)
    <x-chapter :title="$item->title" :body="$item->body" />
    @endforeach
    @if (Route::currentRouteName() === 'step2')
    @livewire('quotas')
    @endif
    @if (Route::currentRouteName() === 'step5')
    @livewire('votes')
    @endif
    @endauth
</section>

@endsection