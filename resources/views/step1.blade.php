@extends('layouts.front')

@section('content')

<section class="bg-stone-100 px-4 md:px-8 py-16 shadow-xl">

    <div>
        @foreach ($theories as $item)
        <div class="cursor-pointer border-b border-black mb-8" x-data="{ open: false }" x-on:click="open = !open">
            <h1 class="text-4xl font-serif">{{ $item->title }}</h1>
            <div class="mt-8 overflow-hidden relative pb-32" x-bind:class="open ? 'h-full' : 'h-0'">
                <div class="grid grid-cols-1 md:grid-cols-3 items-end gap-16">
                    <div class="prose prose-sm prose-p:font-bold max-w-none order-2 md:order-1">{!! $item->quotes !!}</div>
                    <div class="md:col-span-2 prose prose-sm max-w-none text-justify font-serif order-1 md:order-2">{!! $item->body !!}</div>
                </div>
                <div class="bg-gradient-to-t from-stone-100 h-32 absolute bottom-0 w-full"></div>
            </div>
        </div>
        @endforeach
    </div>
    
</section>

@endsection