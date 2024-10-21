@extends('layouts.front')

@section('content')

<section class="bg-white py-16 px-4 sm:px-8 shadow-xl relative">
    <div class="absolute inset-0 mix-blend-luminosity pointer-events-none brightness-110" style="background-image: url({{ asset('paper.png') }}); background-size: 100% auto"></div>
    <h1 class="relative text-2xl sm:text-4xl font-medium uppercase mb-12">Étude théorique</h1>
    @foreach ($theories as $item)
    <div class="font-mono relative mb-4" x-data="{ open: false }">
        <div class="flex items-baseline justify-between gap-4 border-black border-b-4 pb-4 cursor-pointer" x-on:click="open = !open">
            <h1 class="text-xl sm:text-3xl font-sans">{{ $loop->iteration . '. ' . $item->title }}</h1>
            <h2 x-text="open ? '(- Close)' : '(+ Open)'" class="whitespace-nowrap"></h2>
        </div>
        <div class="relative grid duration-500" x-bind:class="open ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
            <div class="overflow-hidden">
                <div class="flex divide-x divide-black">
                    <div class="h-12 flex-1"></div>
                    <div class="h-12 flex-1"></div>
                </div>
                <div class="pb-12 prose max-w-none columns-md gap-12 [column-rule:1px_solid_black] prose-a:underline prose-p:text-justify prose-h2:font-sans prose-h2:pb-4 prose-h2:-mx-6 prose-h2:px-6 prose-h2:uppercase prose-h2:font-medium prose-h2:border-b-4 prose-h2:border-black prose-h3:font-sans prose-h3:uppercase prose-h3:font-medium prose-blockquote:border-y prose-blockquote:font-serif prose-blockquote:text-2xl prose-blockquote:border-x-0 prose-blockquote:py-2 prose-blockquote:-mx-6 prose-blockquote:px-6 prose-blockquote:border-black prose-blockquote:not-italic">{!! $item->body !!}</div>
            </div>
        </div>
    </div>
    @endforeach
</section>

@endsection