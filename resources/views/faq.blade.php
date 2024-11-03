@extends('layouts.front')

@section('content')

<section class="bg-[#fdf2e3] p-3 pb-16 shadow-xl rounded-3xl">
    <h2 class="text-right text-2xl sm:text-4xl font-light mb-8">{{ Auth::id() ?? 'X' }}/250</h2>
    <div class="px-2 sm:px-8">
        <h1 class="text-3xl sm:text-4xl uppercase pb-8 border-b-2 border-zinc-800">F.A.Q.</h1>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-8 font-mono">
            <div class="h-12 sm:border-r-2 border-zinc-800"></div>
            <div class="sm:col-span-2"></div>
            @foreach ($faqs as $item)
            <h3 class="text-xl sm:text-2xl font-sans sm:border-r-2 border-zinc-800 pb-4">{{ $item->title }}</h3>
            <div class="sm:pl-8 sm:col-span-2 pb-12 prose max-w-none columns-md gap-12 [column-rule:1px_solid_black] prose-a:underline prose-p:text-justify prose-h2:font-sans prose-h2:uppercase prose-h2:font-medium prose-h3:font-sans prose-h3:uppercase prose-h3:font-medium prose-blockquote:border-y prose-blockquote:border-x-0  prose-blockquote:border-black prose-blockquote:-mx-6 prose-blockquote:text-xl prose-blockquote:uppercase prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:not-italic prose-blockquote:text-center prose-blockquote:text-[#374151]">{!! $item->body !!}</div>
            @endforeach
        </div>
    </div>
</section>

@endsection