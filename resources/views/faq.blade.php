@extends('layouts.front')

@section('content')

<section class="bg-[#fdf2e3] p-3 pb-16 shadow-xl rounded-3xl">
    <h2 class="text-right text-2xl sm:text-4xl font-light mb-8">{{ Auth::id() ?? 'X' }}/250</h2>
    <div class="px-2 sm:px-8">
        <h1 class="text-3xl sm:text-4xl uppercase pb-4 border-b-2 border-zinc-800">F.A.Q.</h1>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-4 font-mono">
            <div class="h-8 sm:border-r-2 border-zinc-800"></div>
            <div class="sm:col-span-2"></div>
            @foreach ($faqs as $item)
            <h3 class="text-xl font-sans uppercase font-medium sm:border-r-2 border-zinc-800 pb-4 sm:pr-4">{{ $item->title }}</h3>
            <div class="sm:pl-4 sm:col-span-2 pb-8 prose max-w-none prose-a:underline prose-h2:font-sans prose-h2:uppercase prose-h2:font-medium prose-h3:font-sans prose-h3:uppercase prose-h3:font-medium">{!! $item->body !!}</div>
            @endforeach
        </div>
    </div>
</section>

@endsection