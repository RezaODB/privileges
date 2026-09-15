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
                    <a href="{{ route('sections.chapters.create', $section) }}" class="px-4 py-2 bg-green-600 rounded-md text-white inline-block">Create</a>
                    <div class="divide-y">
                        @foreach ($chapters as $item)
                            <x-chapter-row :chapter="$item" />
                            @foreach ($item->children as $child)
                                <x-chapter-row :chapter="$child" nested />
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
