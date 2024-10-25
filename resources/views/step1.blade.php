@extends('layouts.front')

@section('content')

<section class="bg-[#f3e3d3] p-2 pb-16 shadow-xl relative">
    <h2 class="text-right text-2xl sm:text-4xl font-light mb-8">{{ Auth::id() ?? 'X' }}/250</h2>
    @foreach ($theories as $item)
    <div class="font-mono mb-8 px-2 sm:px-8" x-data="{ open: false }">
        <div class="flex items-baseline justify-between gap-4 border-black border-b-4 pb-4 cursor-pointer" x-on:click="open = !open">
            <h1 class="text-2xl sm:text-4xl font-sans uppercase">{{ $item->title }}</h1>
            <h2 x-text="open ? '(- Close)' : '(+ Open)'" class="whitespace-nowrap"></h2>
        </div>
        <div class="grid duration-500" x-bind:class="open ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
            <div class="overflow-hidden">
                <div class="flex lg:divide-x divide-black">
                    <div class="h-12 flex-1"></div>
                    <div class="h-12 flex-1"></div>
                </div>
                <div class="pb-12 prose max-w-none columns-md gap-12 [column-rule:1px_solid_black] prose-a:underline prose-p:text-justify prose-h2:font-sans prose-h2:uppercase prose-h2:font-medium prose-h3:font-sans prose-h3:uppercase prose-h3:font-medium prose-blockquote:border-y prose-blockquote:border-x-0  prose-blockquote:border-black prose-blockquote:-mx-6 prose-blockquote:text-xl prose-blockquote:uppercase prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:not-italic prose-blockquote:text-center prose-blockquote:text-[#374151]">{!! $item->body !!}</div>
            </div>
        </div>
    </div>
    @endforeach
</section>

@endsection