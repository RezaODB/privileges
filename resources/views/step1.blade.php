@extends('layouts.front')

@section('content')

<section class="bg-stone-100 px-4 md:px-8 py-16 shadow-xl">
    <div class="flex gap-8 items-start justify-between" x-data="{ title: 0 }">
        <div class="space-y-8">
            @foreach ($theories as $item)
            <h1 class="uppercase border-b border-black pb-2" id="title{{ $loop->index }}" x-intersect.margin.-200px="title = {{ $loop->index }}">{{ $item->title }}</h1>
            <div class="prose text-justify max-w-none mt-8 prose-blockquote:text-2xl prose-blockquote:font-serif prose-blockquote:not-italic prose-blockquote:border-l-0 prose-blockquote:max-w-lg prose-blockquote:pl-0 prose-blockquote:ml-auto prose-blockquote:text-right md:prose-blockquote:-mr-12">{!! $item->body !!}</div>
            @endforeach
        </div>
        <div class="sticky top-4">
            <ul class="border-l-4 border-black space-y-4">
                @foreach ($theories as $item)
                <li class="flex items-center gap-4">
                    <div class="bg-black w-8 h-1"></div>
                    <a href="#title{{ $loop->index }}" class="uppercase hover:font-bold" x-bind:class="title === {{ $loop->index }} ? 'font-bold' : ''" x-on:click="title = {{ $loop->index }}">{{ $item->title }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

@endsection