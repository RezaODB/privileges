@extends('layouts.front')

@section('content')

<section class="bg-stone-100 px-4 md:px-8 py-16 shadow-xl divide-y divide-black" x-data="{ open: false }">
    
    @foreach ($brochures as $item)
    <div class="py-4" x-on:click="open = {{ $loop->index }}">
        <button class="flex flex-col sm:flex-row items-center gap-4 w-full">
            <div class="w-4 h-4 rounded-full bg-black shrink-0"></div>
            <h2 class="uppercase font-bold">{{ $item->category }}</h2>
            <span class="hidden sm:block">|</span>
            <h1 class="uppercase font-mono">{{ $item->title }}</h1>
            <div class="w-4 h-4 rounded-full bg-black shrink-0 ml-auto hidden sm:block"></div>
        </button>
        <div class="py-8" x-show="open === {{ $loop->index }}" x-transition.duration.500ms>
            <h1 class="uppercase font-title text-4xl sm:text-5xl lg:text-7xl font-medium mb-8">{{ $item->title }}</h1>
            <div class="prose font-mono marker:text-black columns-lg max-w-none [column-rule:solid] gap-16 prose-h2:border-b-4 prose-h2:border-black prose-h2:font-sans prose-h3:font-sans prose-h3:font-normal">{!! $item->body !!}</div>
        </div>
    </div>
    @endforeach

</section>

@endsection