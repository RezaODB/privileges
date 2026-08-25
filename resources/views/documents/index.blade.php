<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl 2xl:max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <a href="{{ route('documents.create') }}" class="px-4 py-2 bg-green-600 rounded-md text-white inline-block">Create</a>
                    <p class="text-sm text-gray-500">Les documents apparaissent en haut de chaque onglet du dossier pro, dans leur langue.</p>
                    <div class="divide-y">
                        @foreach ($documents as $item)
                            <div class="flex flex-wrap gap-4 items-center p-1 hover:bg-gray-100">
                                <form action="{{ route('documents.update', $item) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="number" name="order" value="{{ $item->order }}" min="0" max="99" step="1" onchange="this.form.submit()" class="p-1 border-gray-200 shadow rounded-md">
                                </form>
                                <span class="text-gray-600 font-bold uppercase">{{ $item->lang }}</span>
                                <a href="{{ route('documents.edit', $item) }}" class="text-blue-600 hover:underline">{{ $item->label }}</a>
                                <span class="text-gray-500 text-sm">{{ $item->sizeInBytes() > 0 ? round($item->sizeInBytes() / 1048576, 1).' Mo' : 'fichier introuvable' }}</span>
                                <a href="{{ route('pro.document', $item) }}" target="_blank" class="text-blue-600 hover:underline text-sm">Télécharger</a>
                                <form action="{{ route('documents.destroy', $item) }}" method="post" class="ml-auto">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-red-600 text-sm uppercase hover:underline" onclick="return confirm('Supprimer ce document et son fichier?')">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
