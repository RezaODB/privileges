@extends('layouts.front')

@section('content')

@guest
<div class="bg-white sm:mx-4 mt-12 p-4 max-w-md font-mono">
    @if (App::isLocale('en'))
    Please <a href="{{ route('index') }}" class="underline">sign in</a> before proceeding to the questionnaire.
    @endif
    @if (App::isLocale('fr'))
    Merci de vous <a href="{{ route('index') }}" class="underline">connecter à votre compte</a> afin de répondre au questionnaire.
    @endif
</div>
@endguest

@auth
@livewire('quotas')
@endauth

@endsection