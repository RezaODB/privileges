<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl 2xl:max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <form action="{{ route('quotas.store') }}" method="post">
                        @csrf
                        @include('quotas.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>