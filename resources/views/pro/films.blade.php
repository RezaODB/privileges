<section class="px-2 sm:px-8 mt-16">

    @if ($section->localizedFilmsTitle())
        <h1 class="text-2xl sm:text-3xl font-serif uppercase border-zinc-800 border-b-2 pb-4 mb-8">{{ $section->localizedFilmsTitle() }}</h1>
    @endif

    <x-film-gallery :films="$films" />

</section>
