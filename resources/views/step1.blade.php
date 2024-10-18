@extends('layouts.front')

@section('content')

<section class="bg-white py-16 px-4 sm:px-8 shadow-xl relative">
    <div class="absolute inset-0 opacity-30 mix-blend-luminosity pointer-events-none" style="background-image: url({{ asset('paper.png') }})"></div>
    @foreach ($theories as $item)
    <div class="cursor-pointer relative mb-16" x-data="{ open: false }" x-on:click="open = !open">
        <div class="flex items-center justify-between gap-4 border-black border-b-2 pb-4">
            <h1 class="text-2xl sm:text-3xl font-serif">{{ $item->title }}</h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="duration-300 shrink-0" x-bind:class="open ? 'rotate-45' : ''" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
            </svg>
        </div>
        <div class="mt-12 overflow-hidden relative pb-32 font-mono" x-bind:class="open ? 'h-full' : 'h-0'">
            <div class="prose max-w-none first-letter:text-7xl first-letter:font-bold first-letter:mr-3 first-letter:float-left first-letter:font-serif columns-sm gap-12 [column-rule:1px_solid_black]">{!! $item->body !!}</div>
            {{-- <div>{!! $item->quotes !!}</div> --}}
            <div class="bg-gradient-to-t from-stone-100 h-32 absolute bottom-0 w-full"></div>
        </div>
    </div>
    @endforeach
</section>

@endsection