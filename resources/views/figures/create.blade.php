<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('chapters.figures.index', $chapter) }}" class="text-blue-600 hover:underline">&larr; {{ $chapter->title }}</a>
                    <form action="{{ route('chapters.figures.store', $chapter) }}" method="post" class="mt-4">
                        @csrf
                        @include('figures.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
