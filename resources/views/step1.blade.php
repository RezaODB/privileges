@extends('layouts.front')

@section('content')

<section class="bg-rose-50 py-16 px-4 sm:px-8 shadow-xl relative">
    <div class="absolute inset-0 mix-blend-luminosity pointer-events-none" style="background-image: url({{ asset('paper.png') }})"></div>
    @foreach ($theories as $item)
    <div class="cursor-pointer font-mono relative mb-4" x-data="{ open: false }" x-on:click="open = !open">
        <div class="flex items-center justify-between gap-4 border-black border-b-2 pb-4">
            <h1 class="text-2xl sm:text-3xl font-semibold font-sans uppercase">{{ $loop->iteration . '. ' . $item->title }}</h1>
            <h2 x-text="open ? '(- Close)' : '(+ Open)'"></h2>
        </div>
        <div class="overflow-hidden relative" x-bind:class="open ? 'h-full' : 'h-0'">
            <div class="py-16 prose max-w-none columns-sm gap-12 [column-rule:1px_solid_black] prose-h2:font-sans prose-h3:font-sans prose-blockquote:font-serif">{!! $item->body !!}</div>
        </div>
    </div>
    @endforeach
</section>

@endsection