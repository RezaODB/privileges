@props(['chapter', 'slides' => null, 'podcasts' => null])

@php($films = $chapter->displayedFilms())

<section class="font-mono px-2 sm:px-8 py-12 border-t-2 border-zinc-800 first:border-t-0 first:pt-0">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 items-start">

        <div>
            @if ($chapter->number)
                <p class="text-sm mb-1">{{ $chapter->number }} &mdash;</p>
            @endif

            <h1 class="text-3xl sm:text-4xl font-serif uppercase leading-tight">{{ $chapter->title }}</h1>

            @if ($chapter->subtitle)
                <p class="font-serif text-lg mt-3"><mark>{{ $chapter->subtitle }}</mark></p>
            @endif

            @if ($chapter->summary)
                <p class="text-sm mt-4 whitespace-pre-line">{{ $chapter->summary }}</p>
            @endif
        </div>

        <div class="lg:col-span-2">

            @if (trim(strip_tags($chapter->body)) !== '')
                <x-prose class="mb-8 columns-1">{!! $chapter->body !!}</x-prose>
            @endif

            @switch ($chapter->kind)

                @case (App\Enums\BlockKind::Slides)
                    @if ($slides && $slides->isNotEmpty())
                        <x-slide-carousel :slides="$slides" class="max-w-md" />
                    @endif
                    @break

                @case (App\Enums\BlockKind::Films)
                    @if ($films->isNotEmpty())
                        <x-film-gallery :films="$films" :visible="$chapter->films_visible" />
                    @endif
                    @break

                @case (App\Enums\BlockKind::Figures)
                    @if ($chapter->figures->isNotEmpty())
                        <x-figure-grid :figures="$chapter->figures" />
                    @endif
                    @break

                @case (App\Enums\BlockKind::Podcasts)
                    @if ($podcasts && $podcasts->isNotEmpty())
                        <x-podcast-players :podcasts="$podcasts" />
                    @endif
                    @break

            @endswitch

        </div>

    </div>

</section>
