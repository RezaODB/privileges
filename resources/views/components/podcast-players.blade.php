<div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-mono">
    <div>
        <h2 class="uppercase mb-2">{{ __('content.podcast_theory') }}</h2>
        <audio src="{{ asset(App::isLocale('en') ? 'theoryEN.mp3' : 'theory.mp3') }}" controls preload="none" class="w-full"></audio>
    </div>
    <div>
        <h2 class="uppercase mb-2">{{ __('content.podcast_practice') }}</h2>
        <audio src="{{ asset(App::isLocale('en') ? 'practiceEN.mp3' : 'practice.mp3') }}" controls preload="none" class="w-full"></audio>
    </div>
</div>
