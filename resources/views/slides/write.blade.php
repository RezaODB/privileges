<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('sections.slides.index', $section) }}" class="text-blue-600 hover:underline">&larr; Carrousel</a>
                    <form action="{{ route('sections.slides.storeText', $section) }}" method="post" class="mt-4">
                        @csrf
                        @include('slides.text-form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
