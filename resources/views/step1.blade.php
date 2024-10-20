@extends('layouts.front')

@section('content')

<section class="bg-rose-100 py-16 px-4 sm:px-8 shadow-xl relative">
    <div class="absolute inset-0 mix-blend-luminosity pointer-events-none" style="background-image: url({{ asset('paper.png') }}); background-size: 100% auto"></div>
    <h1 class="relative text-2xl sm:text-4xl font-medium uppercase mb-12">Étude théorique</h1>
    @foreach ($theories as $item)
    <div class="cursor-pointer font-mono relative mb-4" x-data="{ open: false }" x-on:click="open = !open">
        <div class="flex items-baseline justify-between gap-4 border-black border-b-2 pb-4">
            <h1 class="text-xl sm:text-3xl font-sans">{{ $loop->iteration . '. ' . $item->title }}</h1>
            <h2 x-text="open ? '(- Close)' : '(+ Open)'" class="whitespace-nowrap"></h2>
        </div>
        <div class="relative grid duration-500" x-bind:class="open ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
            <div class="overflow-hidden ">
                <div class="py-12 prose max-w-none columns-md gap-12 [column-rule:1px_solid_black] prose-p:text-justify prose-h2:font-sans prose-h2:uppercase prose-h2:font-medium prose-h3:font-sans prose-h3:uppercase prose-h3:font-medium prose-blockquote:border-y-2 prose-blockquote:border-dotted prose-blockquote:border-x-0 prose-blockquote:py-2 prose-blockquote:border-black prose-blockquote:not-italic prose-blockquote:text-lg prose-blockquote:font-bold">{!! $item->body !!}</div>
            </div>
        </div>
    </div>
    @endforeach
</section>

@endsection