@props(['title', 'body', 'number' => null, 'summary' => null, 'children' => null, 'films' => null, 'open' => false])

@php($subChapters = $children ?? collect())

<div class="font-mono mb-4 px-2 sm:px-8" x-data="{ open: {{ $open ? 'true' : 'false' }} }">

    <div class="flex flex-wrap items-baseline gap-x-8 gap-y-2 border-zinc-800 border-b-2 pb-4 cursor-pointer" x-on:click="open = !open">
        @if ($number)
            <span class="text-lg sm:text-xl sm:min-w-12">{{ $number }}</span>
        @endif
        <h1 class="text-2xl sm:text-3xl font-serif uppercase">{{ $title }}</h1>
        @if ($summary)
            <p class="text-sm sm:w-72 sm:shrink-0 sm:ml-auto">{{ $summary }}</p>
        @endif
        <h2 x-text="open ? '(- Close)' : '(+ Open)'" class="whitespace-nowrap {{ $summary ? '' : 'ml-auto' }}"></h2>
    </div>

    <div x-show="open" x-collapse>

        <div class="flex lg:divide-x divide-zinc-800">
            <div class="h-12 flex-1"></div>
            <div class="h-12 flex-1"></div>
        </div>

        <x-prose class="pb-12">{!! $body !!}</x-prose>

        @if ($films && $films->isNotEmpty())
            <x-film-gallery :films="$films" class="pb-12" />
        @endif

        @if ($subChapters->isNotEmpty())
            <div x-data="{ child: null }" class="pb-12">

                <div class="flex flex-col sm:flex-row divide-y sm:divide-y-0 sm:divide-x divide-zinc-800 border-t-2 border-zinc-800 pt-6">
                    @foreach ($subChapters as $subChapter)
                        <button type="button" class="group flex-1 flex flex-col items-start text-left py-4 sm:py-0 sm:px-6 sm:first:pl-0 sm:last:pr-0" x-on:click="child = child === {{ $subChapter->id }} ? null : {{ $subChapter->id }}">
                            @if ($subChapter->number)
                                <div class="text-sm mb-1">{{ $subChapter->number }}</div>
                            @endif
                            <div class="font-serif uppercase text-lg leading-tight group-hover:underline">{{ $subChapter->title }}</div>
                            @if ($subChapter->summary)
                                <div class="text-sm mt-2">{{ $subChapter->summary }}</div>
                            @endif
                            <div class="text-lg mt-auto pt-6" x-text="child === {{ $subChapter->id }} ? '&darr;' : '&rarr;'"></div>
                        </button>
                    @endforeach
                </div>

                @foreach ($subChapters as $subChapter)
                    <div x-show="child === {{ $subChapter->id }}" x-collapse x-cloak>
                        <x-prose class="pt-8">{!! $subChapter->body !!}</x-prose>
                        @php($subChapterFilms = $subChapter->displayedFilms())
                        @if ($subChapterFilms->isNotEmpty())
                            <x-film-gallery :films="$subChapterFilms" />
                        @endif
                    </div>
                @endforeach

            </div>
        @endif

    </div>

</div>
