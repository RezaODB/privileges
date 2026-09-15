<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl 2xl:max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('sections.index') }}" class="text-blue-600 hover:underline">&larr; Onglets</a>
                        <h2 class="font-bold uppercase">{{ $section->title_fr }}</h2>
                        <a href="{{ route('pro.show', $section) }}" target="_blank" class="text-blue-600 hover:underline">Voir la page &rarr;</a>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('sections.slides.write', $section) }}" class="px-4 py-2 bg-green-600 rounded-md text-white inline-block">&Eacute;crire une slide</a>
                        <a href="{{ route('sections.slides.create', $section) }}" class="px-4 py-2 bg-gray-600 rounded-md text-white inline-block">Envoyer des images</a>
                    </div>
                    <p class="text-sm text-gray-500">
                        Le carrousel s'affiche en haut de l'onglet. Adresse à mettre derrière l'image dans un email&nbsp;:
                        <code>{{ route('pro.show', $section) }}#carrousel</code>
                    </p>
                    @foreach ($slides as $lang => $items)
                        <h3 class="font-bold uppercase pt-4">{{ $lang === 'en' ? 'Anglais' : 'Français' }} <span class="font-normal text-gray-500">({{ $items->count() }})</span></h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-4">
                            @foreach ($items as $item)
                                <div class="border rounded-md p-2 space-y-2">
                                    @if ($item->isText())
                                        <a href="{{ route('slides.edit', $item) }}" class="block aspect-[4/5] overflow-hidden bg-amber-50 rounded p-2 text-xs leading-snug">
                                            @if ($item->title)
                                                <span class="bg-yellow-200">{{ $item->title }}</span>
                                            @endif
                                            <span class="block mt-1 text-gray-600">{{ Str::limit(strip_tags($item->body), 160) }}</span>
                                        </a>
                                    @else
                                        <a href="{{ route('slides.edit', $item) }}"><img src="{{ $item->url() }}" alt="" class="w-full bg-gray-100 rounded"></a>
                                    @endif
                                    <form action="{{ route('slides.update', $item) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <input type="number" name="order" value="{{ $item->order }}" min="0" max="99" step="1" onchange="this.form.submit()" class="w-16 p-1 border-gray-200 shadow rounded-md">
                                    </form>
                                    <form action="{{ route('slides.destroy', $item) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="text-red-600 text-sm uppercase hover:underline" onclick="return confirm('Supprimer cette image?')">Delete</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
