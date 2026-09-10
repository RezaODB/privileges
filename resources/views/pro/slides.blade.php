<section id="carrousel" class="px-2 sm:px-8 mb-16" x-data="{ current: 0, count: {{ $slides->count() }} }" x-on:keydown.arrow-right.window="current = (current + 1) % count" x-on:keydown.arrow-left.window="current = (current - 1 + count) % count">

    <div class="max-w-md mx-auto">

        <button type="button" class="relative block w-full border-2 border-zinc-800" style="aspect-ratio: {{ $slides->first()->aspectRatio() }}" x-on:click="current = (current + 1) % count">
            @foreach ($slides as $slide)
                <img src="{{ $slide->url() }}" alt="" width="{{ $slide->width }}" height="{{ $slide->height }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" class="absolute inset-0 w-full h-full object-contain" x-show="current === {{ $loop->index }}" @unless ($loop->first) x-cloak @endunless>
            @endforeach
        </button>

        <div class="flex items-baseline justify-between gap-4 font-mono uppercase text-sm mt-3">
            <button type="button" class="hover:underline" x-on:click="current = (current - 1 + count) % count">&larr; {{ __('content.previous') }}</button>
            <span><span x-text="current + 1"></span>/{{ $slides->count() }}</span>
            <button type="button" class="hover:underline" x-on:click="current = (current + 1) % count">{{ __('content.next') }} &rarr;</button>
        </div>

    </div>

</section>
