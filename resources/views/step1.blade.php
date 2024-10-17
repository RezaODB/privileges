@extends('layouts.front')

@section('content')

<section class="bg-stone-100 py-16 shadow-xl">
    @foreach ($theories as $item)
    <div class="cursor-pointer border-b border-black mb-8" x-data="{ open: false }" x-on:click="open = !open">
        <div class="flex items-center justify-between gap-4 px-4 md:px-8">
            <h1 class="text-2xl sm:text-4xl font-serif">{{ $item->title }}</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="duration-300 shrink-0" x-bind:class="open ? 'rotate-45' : ''" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
            </svg>
        </div>
        <div class="mt-8 overflow-hidden relative pb-32" x-bind:class="open ? 'h-full' : 'h-0'">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
                <div class="prose max-w-none order-2 md:order-1">{!! $item->quotes !!}</div>
                <div class="md:col-span-2 prose prose-img:ml-auto prose-img:-mr-4 sm:prose-img:-mr-8 max-w-none text-justify font-serif order-1 md:order-2 mr-4 sm:mr-8">{!! $item->body !!}</div>
            </div>
            <div class="bg-gradient-to-t from-stone-100 h-32 absolute bottom-0 w-full"></div>
        </div>
    </div>
    @endforeach
</section>

@endsection