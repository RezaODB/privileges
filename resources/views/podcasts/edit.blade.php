<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('podcasts.index') }}" class="text-blue-600 hover:underline">&larr; Podcasts</a>
                    <form action="{{ route('podcasts.update', $podcast) }}" method="post" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        @method('patch')
                        @include('podcasts.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
