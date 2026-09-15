@props(['films', 'visible' => null])

@php($hidden = $visible ? $films->count() - $visible : 0)

{{-- Written out in full: Tailwind only ships classes it can find in the source. --}}
@php($columns = match ((int) $visible) {
    1 => 'sm:grid-cols-1',
    2 => 'sm:grid-cols-2',
    3 => 'sm:grid-cols-3',
    4 => 'sm:grid-cols-4',
    5 => 'sm:grid-cols-5',
    default => 'sm:grid-cols-3 lg:grid-cols-5',
})

<div x-data="{ src: null, caption: null, all: false }" x-on:keydown.escape.window="src = null">

    <div class="grid grid-cols-2 {{ $columns }} gap-4">
        @foreach ($films as $film)
            <button type="button" class="group text-left" x-on:click="src = @js($film->url()); caption = @js($film->localizedTitle())" @if ($visible && $loop->index >= $visible) x-show="all" x-cloak @endif>
<div class="relative aspect-square overflow-hidden border-2 border-zinc-800">
                    {{-- Behind the frame: a .mov Chrome cannot decode draws nothing at all,
                         which used to leave an empty square on the page. --}}
                    <div class="absolute inset-0 flex items-center justify-center text-3xl">&#9654;</div>
                    @if ($film->posterUrl())
                        <img src="{{ $film->posterUrl() }}" alt="{{ $film->localizedTitle() }}" loading="lazy" class="relative w-full h-full object-cover">
                    @else
                        <video src="{{ $film->url() }}" preload="metadata" muted playsinline class="relative w-full h-full object-cover"></video>
                    @endif
                </div>
                @if ($film->localizedTitle())
                    <div class="font-mono text-sm mt-2 group-hover:underline">{{ $film->localizedTitle() }}</div>
                @endif
            </button>
        @endforeach
    </div>

    @if ($hidden > 0)
        <button type="button" class="font-mono uppercase text-sm mt-6 ml-auto block hover:underline" x-on:click="all = ! all">
            <span x-show="! all">{{ __('content.see_all_films') }} &rarr;</span>
            <span x-show="all" x-cloak>{{ __('content.see_fewer_films') }} &larr;</span>
        </button>
    @endif

    <div x-cloak x-show="src" x-on:click="src = null" class="fixed inset-0 z-50 bg-black/85 flex flex-col items-center justify-center gap-4 p-4">
        <video x-bind:src="src" controls autoplay loop playsinline class="max-h-[80vh] max-w-full" x-on:click.stop></video>
        <p class="font-mono uppercase text-sm text-white" x-text="caption"></p>
        <button type="button" class="font-mono uppercase text-sm text-white underline">(close)</button>
    </div>

</div>
