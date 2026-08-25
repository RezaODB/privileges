<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl 2xl:max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('sections.create') }}" class="px-4 py-2 bg-green-600 rounded-md text-white inline-block">Create</a>
                        <a href="{{ route('pro.index') }}" target="_blank" class="text-blue-600 hover:underline">Voir le dossier pro &rarr;</a>
                    </div>
                    <div class="divide-y">
                        @foreach ($sections as $item)
                            <div class="flex flex-wrap gap-4 items-center p-1 hover:bg-gray-100">
                                <form action="{{ route('sections.update', $item) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="number" name="order" value="{{ $item->order }}" min="0" max="99" step="1" onchange="this.form.submit()" class="p-1 border-gray-200 shadow rounded-md">
                                </form>
                                <a href="{{ route('sections.edit', $item) }}" class="text-blue-600 hover:underline">{{ $item->title_fr }}</a>
                                <span class="text-gray-500">{{ $item->title_en }}</span>
                                <code class="text-gray-500 text-sm">/pro/{{ $item->slug }}</code>
                                <a href="{{ route('sections.chapters.index', $item) }}" class="text-blue-600 hover:underline">{{ $item->chapters_count }} bloc(s) de contenu</a>
                                <a href="{{ route('sections.films.index', $item) }}" class="text-blue-600 hover:underline">{{ $item->films_count }} film(s)</a>
                                <form action="{{ route('sections.update', $item) }}" method="post" class="ml-auto">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="published" value="0">
                                    <label class="flex items-center gap-2 text-sm uppercase text-gray-600">
                                        <input type="checkbox" name="published" value="1" @checked($item->published) onchange="this.form.submit()" class="rounded border-gray-300">
                                        En ligne
                                    </label>
                                </form>
                                <form action="{{ route('sections.destroy', $item) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-red-600 text-sm uppercase hover:underline" onclick="return confirm('Supprimer cet onglet et tout son contenu?')">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
