@extends('layouts.front')

@section('content')

<section class="sheet p-3 pb-16 shadow-xl">

    <div class="flex flex-wrap items-baseline justify-between gap-x-8 gap-y-2 font-mono uppercase text-sm px-2 sm:px-8 pt-2 mb-8">
        <div class="flex flex-wrap gap-x-6 gap-y-2">
            @foreach ($documents as $document)
                <a href="{{ route('pro.document', $document) }}" class="hover:underline">{{ $document->label }} (PDF)</a>
            @endforeach
        </div>
        <div class="flex gap-1 ml-auto">
            <a href="{{ route('pro.show', ['section' => $section, 'lang' => 'fr']) }}" class="{{ App::getLocale() === 'fr' ? 'underline' : 'hover:underline' }}">FR</a>/
            <a href="{{ route('pro.show', ['section' => $section, 'lang' => 'en']) }}" class="{{ App::getLocale() === 'en' ? 'underline' : 'hover:underline' }}">EN</a>
        </div>
    </div>

    @php($claimed = $chapters->where('open', true)->pluck('kind')->filter()->map->value->all())

    @if ($section->hasHeader())
        @include('pro.header')
    @endif

    @if ($slides->isNotEmpty() && ! in_array('slides', $claimed, true))
        @include('pro.slides')
    @endif

    @foreach ($chapters as $chapter)
        @if ($chapter->open)
            <x-block :chapter="$chapter" :slides="$slides" />
        @else
            <x-chapter :title="$chapter->title" :body="$chapter->body" :number="$chapter->number" :summary="$chapter->summary" :children="$chapter->children" :films="$chapter->displayedFilms()" />
        @endif
    @endforeach

    @if ($section->shows_podcasts && ! in_array('podcasts', $claimed, true))
        @include('pro.podcasts')
    @endif

    @if ($films->isNotEmpty() && ! in_array('films', $claimed, true))
        @include('pro.films')
    @endif

    @if ($quotas->isNotEmpty())
        @include('pro.quota')
    @endif

    @if ($chapters->isEmpty() && $films->isEmpty() && $quotas->isEmpty() && $slides->isEmpty() && ! $section->shows_podcasts)
        <div class="max-w-md font-mono px-2 sm:px-8 py-8">{{ __('content.pro_empty') }}</div>
    @endif

</section>

@endsection
