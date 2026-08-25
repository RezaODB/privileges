@extends('layouts.front')

@section('content')

<section class="bg-[#fdf2e3] p-3 pb-16 shadow-xl rounded-3xl">

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

    @foreach ($chapters as $chapter)
        <x-chapter :title="$chapter->title" :body="$chapter->body" :open="$loop->first" />
    @endforeach

    @if ($films->isNotEmpty())
        @include('pro.films')
    @endif

    @if ($quotas->isNotEmpty())
        @include('pro.quota')
    @endif

    @if ($chapters->isEmpty() && $films->isEmpty() && $quotas->isEmpty())
        <div class="max-w-md font-mono px-2 sm:px-8 py-8">{{ __('content.pro_empty') }}</div>
    @endif

</section>

@endsection
