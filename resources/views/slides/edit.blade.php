<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('sections.slides.index', $section) }}" class="text-blue-600 hover:underline">&larr; Carrousel</a>
                    @if ($slide->isText())
                        <form action="{{ route('slides.update', $slide) }}" method="post" class="mt-4">
                            @csrf
                            @method('patch')
                            @include('slides.text-form')
                        </form>
                    @else
                        <p class="mt-4 text-gray-600">Cette slide est une image&nbsp;: pour la changer, supprimez-la et renvoyez-en une autre.</p>
                        <img src="{{ $slide->url() }}" alt="" class="mt-4 max-w-md bg-gray-100 rounded">
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
