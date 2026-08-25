<section class="px-2 sm:px-8 mt-16" x-data="{ src: null, caption: null }" x-on:keydown.escape.window="src = null">

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach ($films as $film)
            <button type="button" class="group text-left" x-on:click="src = @js($film->url()); caption = @js($film->localizedTitle())">
                <div class="aspect-square overflow-hidden border-2 border-zinc-800">
                    @if ($film->posterUrl())
                        <img src="{{ $film->posterUrl() }}" alt="{{ $film->localizedTitle() }}" loading="lazy" class="w-full h-full object-cover">
                    @else
                        <video src="{{ $film->url() }}" preload="metadata" muted playsinline class="w-full h-full object-cover"></video>
                    @endif
                </div>
                @if ($film->localizedTitle())
                    <div class="font-mono text-sm mt-2 group-hover:underline">{{ $film->localizedTitle() }}</div>
                @endif
            </button>
        @endforeach
    </div>

    <div x-cloak x-show="src" x-on:click="src = null" class="fixed inset-0 z-50 bg-black/85 flex flex-col items-center justify-center gap-4 p-4">
        <video x-bind:src="src" controls autoplay loop playsinline class="max-h-[80vh] max-w-full" x-on:click.stop></video>
        <p class="font-mono uppercase text-sm text-white" x-text="caption"></p>
        <button type="button" class="font-mono uppercase text-sm text-white underline">(close)</button>
    </div>

</section>
