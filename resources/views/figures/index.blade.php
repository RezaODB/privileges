<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl 2xl:max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('sections.chapters.index', $chapter->section) }}" class="text-blue-600 hover:underline">&larr; Blocs de contenu</a>
                        <h2 class="font-bold uppercase">{{ $chapter->title }}</h2>
                        <a href="{{ route('pro.show', $chapter->section) }}" target="_blank" class="text-blue-600 hover:underline">Voir la page &rarr;</a>
                    </div>
                    <a href="{{ route('chapters.figures.create', $chapter) }}" class="px-4 py-2 bg-green-600 rounded-md text-white inline-block">Create</a>
                    <p class="text-sm text-gray-500">
                        Les <strong>8 premiers</strong> s'affichent sur la page&nbsp;; les suivants apparaissent quand le visiteur clique sur la fl&egrave;che.
                        Pour qu'ils s'affichent, le bloc doit &ecirc;tre r&eacute;gl&eacute; sur &laquo;&nbsp;Les chiffres du bloc&nbsp;&raquo;.
                    </p>
                    <div class="divide-y">
                        @foreach ($figures as $item)
                            <div class="flex gap-4 items-center p-1 hover:bg-gray-100 {{ $loop->index === 8 ? 'border-t-4 border-amber-400' : '' }}">
                                <form action="{{ route('figures.update', $item) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="number" name="order" value="{{ $item->order }}" min="0" max="99" step="1" onchange="this.form.submit()" class="p-1 border-gray-200 shadow rounded-md">
                                </form>
                                <a href="{{ route('figures.edit', $item) }}" class="text-blue-600 hover:underline font-bold">{{ $item->value_fr }}</a>
                                <span class="text-gray-600 text-sm truncate">{{ $item->label_fr }}</span>
                                <form action="{{ route('figures.destroy', $item) }}" method="post" class="ml-auto">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-red-600 text-sm uppercase hover:underline" onclick="return confirm('Supprimer ce chiffre?')">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                    @if ($figures->count() > 8)
                        <p class="text-sm text-amber-700">Le trait orange marque la limite&nbsp;: tout ce qui est en dessous n'appara&icirc;t qu'apr&egrave;s un clic sur la fl&egrave;che.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
