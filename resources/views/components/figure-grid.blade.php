@props(['figures', 'visible' => 8])

@php($hidden = $figures->count() - $visible)

<div x-data="{ all: false }">

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-y-10">
        @foreach ($figures as $figure)
            <div
                class="border-l border-zinc-800 pl-5 [&:nth-child(2n+1)]:border-l-0 [&:nth-child(2n+1)]:pl-0 sm:[&:nth-child(2n+1)]:border-l sm:[&:nth-child(2n+1)]:pl-5 sm:[&:nth-child(4n+1)]:border-l-0 sm:[&:nth-child(4n+1)]:pl-0"
                @if ($loop->index >= $visible) x-show="all" x-cloak @endif
            >
                <div class="font-serif text-3xl sm:text-4xl leading-none">{{ $figure->localizedValue() }}</div>
                <div class="font-mono text-sm mt-3 pr-4">{{ $figure->localizedLabel() }}</div>
            </div>
        @endforeach
    </div>

    @if ($hidden > 0)
        <button type="button" class="font-mono uppercase text-sm mt-10 ml-auto block hover:underline" x-on:click="all = ! all">
            <span x-show="! all">{{ __('content.see_all_figures') }} &rarr;</span>
            <span x-show="all" x-cloak>{{ __('content.see_fewer_figures') }} &larr;</span>
        </button>
    @endif

</div>
