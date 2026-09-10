@extends('layouts.front')

@section('content')

<section class="grid grid-cols-1 md:grid-cols-2 items-start gap-8 px-2 mt-8">

    <div class="md:justify-self-start uppercase font-medium border-2 border-zinc-800">
        <h1 class="text-3xl sm:text-4xl p-4 text-center">Les privilèges invisibles</h1>
        <h2 class="text-5xl text-center p-4 border-y-2 border-zinc-800"><span class="text-3xl">N°</span> X/250</h2>
        <div class="flex text-xl border-b-2 border-zinc-800">
            <div class="border-r-2 border-zinc-800 p-4 text-right">
                <h3>{{ __('content.socioartystudy') }}</h3>
                <h2>Barbara Iweins</h2>
            </div>
            <div class="flex mx-auto p-4 gap-1 justify-center items-center text-3xl">
                <a href="{{ route('pro.index', ['lang' => 'fr']) }}" class="{{ App::getLocale() === 'fr' ? 'underline' : 'hover:underline' }}">FR</a>/
                <a href="{{ route('pro.index', ['lang' => 'en']) }}" class="{{ App::getLocale() === 'en' ? 'underline' : 'hover:underline' }}">EN</a>
            </div>
        </div>
        <h3 class="text-xl text-center uppercase p-4">{{ __('content.dates') }}</h3>
    </div>

    <x-contacts />

</section>

@endsection
