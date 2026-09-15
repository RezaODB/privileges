@props(['slides'])

<div {{ $attributes }} x-data="{ current: 0, count: {{ $slides->count() }} }" x-on:keydown.arrow-right.window="current = (current + 1) % count" x-on:keydown.arrow-left.window="current = (current - 1 + count) % count">

    <button type="button" class="relative block w-full border-2 border-zinc-800" style="aspect-ratio: {{ $slides->first()->aspectRatio() }}" x-on:click="current = (current + 1) % count">
        @foreach ($slides as $slide)
            <div class="absolute inset-0" x-show="current === {{ $loop->index }}" @unless ($loop->first) x-cloak @endunless>
                @if ($slide->isText())
                    <div class="h-full overflow-auto px-6 py-10 sm:px-10 text-left">
                        @if ($slide->title)
                            <p class="font-serif text-xl sm:text-2xl leading-snug"><mark>{{ $slide->title }}</mark></p>
                        @endif
                        <div class="font-serif text-lg sm:text-xl leading-snug mt-4 prose-p:mt-4 prose-a:underline">{!! $slide->body !!}</div>
                    </div>
                @else
                    <img src="{{ $slide->url() }}" alt="" width="{{ $slide->width }}" height="{{ $slide->height }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" class="w-full h-full object-contain">
                @endif
            </div>
        @endforeach
    </button>

    <div class="flex items-baseline justify-between gap-4 font-mono uppercase text-sm mt-3">
        <button type="button" class="hover:underline" x-on:click="current = (current - 1 + count) % count">&larr; {{ __('content.previous') }}</button>
        <span><span x-text="current + 1"></span>/{{ $slides->count() }}</span>
        <button type="button" class="hover:underline" x-on:click="current = (current + 1) % count">{{ __('content.next') }} &rarr;</button>
    </div>

</div>
