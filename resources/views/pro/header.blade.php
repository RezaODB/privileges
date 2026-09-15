<header class="px-2 sm:px-8 mb-12">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 items-start">

        <div class="lg:col-span-2">

            @if ($section->number)
                <p class="font-mono text-sm mb-1">{{ $section->number }} &mdash;</p>
            @endif

            <h1 class="font-serif uppercase text-3xl sm:text-5xl leading-tight">{{ $section->localizedTitle() }}</h1>

            @if ($section->localizedSubtitle())
                <p class="font-serif text-lg sm:text-xl mt-4"><mark>{{ $section->localizedSubtitle() }}</mark></p>
            @endif

            @if ($section->localizedIntro())
                <p class="font-serif mt-4 max-w-md whitespace-pre-line">{{ $section->localizedIntro() }}</p>
            @endif

        </div>

        @if ($section->localizedQuote())
            <div>
                <p class="font-mono text-sm whitespace-pre-line">{{ $section->localizedQuote() }}</p>
                <hr class="border-zinc-800 border-t-0 border-b mt-3">
            </div>
        @endif

    </div>

</header>
