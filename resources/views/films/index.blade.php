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
                    <a href="{{ route('sections.films.create', $section) }}" class="px-4 py-2 bg-green-600 rounded-md text-white inline-block">Create</a>
                    <p class="text-sm text-gray-500">La galerie s'affiche sous les blocs de contenu de cet onglet.</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-4">
                        @foreach ($films as $item)
                            <div class="border rounded-md p-2 space-y-2">
                                <div class="aspect-square overflow-hidden bg-gray-100 rounded">
                                    @if ($item->posterUrl())
                                        <img src="{{ $item->posterUrl() }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <video src="{{ $item->url() }}" preload="metadata" muted class="w-full h-full object-cover"></video>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('films.update', $item) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <input type="number" name="order" value="{{ $item->order }}" min="0" max="99" step="1" onchange="this.form.submit()" class="w-16 p-1 border-gray-200 shadow rounded-md">
                                    </form>
                                    <a href="{{ route('films.edit', $item) }}" class="text-blue-600 hover:underline text-sm truncate">{{ $item->title_fr ?: 'Sans titre' }}</a>
                                </div>
                                <form action="{{ route('films.destroy', $item) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-red-600 text-sm uppercase hover:underline" onclick="return confirm('Supprimer ce film et ses fichiers?')">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
