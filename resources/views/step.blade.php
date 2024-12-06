@extends('layouts.front')

@section('content')

<section class="bg-[#fdf2e3] p-3 pb-16 shadow-xl rounded-3xl">

    <h2 class="text-right text-2xl sm:text-4xl font-light mb-8">{{ Auth::user()->order ?? 'X' }}/250</h2>

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
    <div class="font-mono mb-4 px-2 sm:px-8" x-data="{ open: {{ Route::currentRouteName() === 'step5' ? 'true' : 'false' }} }">
        <div class="flex items-baseline justify-between gap-4 border-zinc-800 border-b-4 pb-4 cursor-pointer" x-on:click="open = !open">
            <h1 class="text-2xl sm:text-3xl font-sans uppercase">{{ $item->title }}</h1>
            <h2 x-text="open ? '(- Close)' : '(+ Open)'" class="whitespace-nowrap"></h2>
        </div>
        <div x-show="open" x-collapse>
            <div class="flex lg:divide-x-2 divide-zinc-800">
                <div class="h-12 flex-1"></div>
                <div class="h-12 flex-1"></div>
            </div>
            <div class="pb-12 prose max-w-none columns-md gap-12 [column-rule:2px_solid_#27272a] prose-h1:break-after-avoid prose-h2:break-after-avoid prose-h3:break-after-avoid prose-ol:ml-4 prose-li:text-justify prose-a:underline prose-p:text-justify prose-h2:font-sans prose-h2:text-2xl prose-h2:uppercase prose-h2:font-normal prose-h2:border-b-2 prose-h2:border-zinc-800 prose-h2:pb-4 prose-h2:-mx-6 prose-h2:px-6 prose-h3:font-sans prose-h3:uppercase prose-h3:font-medium prose-h3:text-lg prose-blockquote:border-y-2 prose-blockquote:border-x-0 prose-blockquote:border-zinc-800 prose-blockquote:-mx-6 prose-blockquote:text-xl prose-blockquote:uppercase prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:not-italic prose-blockquote:text-center prose-blockquote:text-[#374151] overflow-hidden">{!! $item->body !!}</div>
        </div>
    </div>
    @endforeach
    @if (Route::currentRouteName() === 'step2')
    @livewire('quotas')
    @endif
    @if (Route::currentRouteName() === 'step3')
    @livewire('votes')
    @endif
    @endauth
</section>

@endsection