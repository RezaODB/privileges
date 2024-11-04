@extends('layouts.front')

@section('content')

<section class="bg-[#fdf2e3] p-3 pb-16 shadow-xl rounded-3xl">

    <h2 class="text-right text-2xl sm:text-4xl font-light mb-8">{{ Auth::id() ?? 'X' }}/250</h2>

    @foreach ($items as $item)
    <div class="font-mono mb-4 px-2 sm:px-8" x-data="{ open: false }">
        <div class="flex items-baseline justify-between gap-4 border-zinc-800 border-b-2 pb-4 cursor-pointer" x-on:click="open = !open">
            <h1 class="text-2xl sm:text-3xl font-sans uppercase">
                @if ($item->category)
                <span class="font-mono text-base">{{ $item->category }}: </span>
                @endif
                {{ $item->title }}
            </h1>
            <h2 x-text="open ? '(- Close)' : '(+ Open)'" class="whitespace-nowrap"></h2>
        </div>
        <div class="grid duration-500" x-bind:class="open ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
            <div class="overflow-hidden">
                <div class="flex lg:divide-x-2 divide-zinc-800">
                    <div class="h-12 flex-1"></div>
                    <div class="h-12 flex-1"></div>
                </div>
                <div class="pb-12 prose max-w-none columns-md gap-12 [column-rule:2px_solid_black] prose-a:underline prose-p:text-justify prose-h2:font-sans prose-h2:uppercase prose-h2:font-medium prose-h3:font-sans prose-h3:uppercase prose-h3:font-medium prose-blockquote:border-y-2 prose-blockquote:border-x-0  prose-blockquote:border-zinc-800 prose-blockquote:-mx-6 prose-blockquote:text-xl prose-blockquote:uppercase prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:not-italic prose-blockquote:text-center prose-blockquote:text-[#374151]">{!! $item->body !!}</div>
            </div>
        </div>
    </div>
    @endforeach

    @guest
    <div class="max-w-md font-mono px-2 sm:px-8">
        @if (App::isLocale('en'))
        Please <a href="{{ route('index', ['login' => 'yes']) }}" class="underline">sign in</a> before proceeding to the vote.
        @endif
        @if (App::isLocale('fr'))
        Merci de vous <a href="{{ route('index', ['login' => 'yes']) }}" class="underline">connecter à votre compte</a> afin de répondre au questionnaire.
        @endif
    </div>
    @endguest
    
    @auth
    @livewire(Route::currentRouteName() === 'step2' ? 'quotas' : 'votes')
    @endauth
</section>

@endsection