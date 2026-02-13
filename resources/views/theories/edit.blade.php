<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl 2xl:max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <form action="{{ route('theories.update', $theory) }}" method="post">
                        @csrf
                        @method('patch')
                        @include('theories.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>