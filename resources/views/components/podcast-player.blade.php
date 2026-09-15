@props(['podcast', 'number' => null])

@php($bars = $podcast->waveform())

<div
    class="font-mono"
    x-data="{
        playing: false,
        progress: 0,
        toggle() {
            const audio = this.$refs.audio;
            if (audio.paused) {
                document.querySelectorAll('audio').forEach((other) => other !== audio && other.pause());
                audio.play();
            } else {
                audio.pause();
            }
        },
        seek(ratio) {
            const audio = this.$refs.audio;
            if (audio.duration) {
                audio.currentTime = ratio * audio.duration;
            }
        },
    }"
>

    @if ($number)
        <div class="text-sm mb-1">{{ $number }}</div>
    @endif

    <h2 class="font-serif uppercase text-lg leading-tight">{{ $podcast->title }}</h2>

    <div class="flex items-baseline justify-between gap-4 text-sm mt-1">
        <span>{{ $podcast->guest }}</span>
        <span>{{ $podcast->duration }}</span>
    </div>

    <div class="flex items-center gap-4 mt-4">

        <button
            type="button"
            class="shrink-0 text-xl leading-none w-6"
            x-on:click="toggle()"
            x-bind:aria-label="playing ? @js(__('content.pause')) : @js(__('content.play'))"
            x-text="playing ? '&#9646;&#9646;' : '&#9654;'"
        ></button>

        <svg
            viewBox="0 0 {{ count($bars) * 2.5 }} 40"
            preserveAspectRatio="none"
            class="h-10 flex-1 cursor-pointer"
            role="presentation"
            x-on:click="seek(($event.offsetX / $event.currentTarget.clientWidth))"
        >
            @foreach ($bars as $index => $height)
                <rect
                    x="{{ $index * 2.5 }}"
                    y="{{ (40 - $height * 0.4) / 2 }}"
                    width="0.9"
                    height="{{ $height * 0.4 }}"
                    fill="currentColor"
                    x-bind:opacity="progress * {{ count($bars) }} > {{ $index }} ? 1 : 0.3"
                ></rect>
            @endforeach
        </svg>

    </div>

    <audio
        x-ref="audio"
        src="{{ $podcast->url() }}"
        preload="none"
        x-on:play="playing = true"
        x-on:pause="playing = false"
        x-on:ended="playing = false; progress = 0"
        x-on:timeupdate="progress = $event.target.duration ? $event.target.currentTime / $event.target.duration : 0"
        class="hidden"
    ></audio>

</div>
