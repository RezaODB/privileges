@props(['podcasts'])

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 md:divide-x divide-zinc-800">
    @foreach ($podcasts as $podcast)
        <div class="{{ $loop->first ? '' : 'md:pl-12' }}">
            <x-podcast-player :podcast="$podcast" :number="str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT)" />
        </div>
    @endforeach
</div>
