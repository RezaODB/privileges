@extends('layouts.front')

@section('content')

<section class="bg-orange-100 px-4 md:px-8 py-16 shadow-xl space-y-8">
    @foreach ($theories as $item)
    <h1 class="max-w-2xl uppercase border-b border-black pb-2 mx-auto">{{ $item->title }}</h1>
    <div class="prose mt-8 mx-auto max-w-2xl prose-blockquote:text-2xl prose-blockquote:font-serif prose-blockquote:not-italic prose-blockquote:border-l-0 prose-blockquote:max-w-lg prose-blockquote:pl-0 {{ $loop->even ? 'prose-blockquote:ml-auto prose-blockquote:text-right lg:prose-blockquote:-mr-12' : 'prose-blockquote:mr-auto lg:prose-blockquote:-ml-12' }}">{!! $item->body !!}</div>
    @endforeach
</section>

@endsection