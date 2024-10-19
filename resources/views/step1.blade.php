@extends('layouts.front')

@section('content')

<section class="bg-white py-16 px-4 sm:px-8 shadow-xl relative">
    <div class="absolute inset-0 opacity-30 mix-blend-luminosity pointer-events-none" style="background-image: url({{ asset('paper.png') }})"></div>
    @foreach ($theories as $item)
    <div class="cursor-pointer font-mono relative mb-4" x-data="{ open: false }" x-on:click="open = !open">
        <div class="flex items-center justify-between gap-4 border-black border-b-2 pb-4">
            <h1 class="text-2xl sm:text-3xl font-semibold font-sans uppercase">{{ $loop->iteration . '. ' . $item->title }}</h1>
            <h2 x-text="open ? '(- Close)' : '(+ Open)'"></h2>
        </div>
        <div class="overflow-hidden relative" x-bind:class="open ? 'h-full' : 'h-0'">
            <div class="py-16 prose max-w-none first-letter:text-7xl first-letter:font-bold first-letter:mr-3 first-letter:float-left first-letter:font-serif columns-sm gap-12 [column-rule:1px_solid_black] prose-h2:uppercase prose-h2:font-sans prose-h2:border-b-2 prose-h2:border-black prose-h3:uppercase prose-h3:font-sans prose-blockquote:font-serif">{!! $item->body !!}</div>
        </div>
    </div>
    @endforeach
</section>

@endsection