<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="divide-y">
                        @foreach ($users as $item)
                        <div class="flex gap-4 items-center p-1 hover:bg-gray-100">
                            <span class="font-bold text-gray-600">{{ $loop->iteration }}</span>
                            <h1>{{ $item->name . ' ' . $item->lastname }}</h1>
                            <span class="bg-green-100 text-green-600 uppercase px-2 whitespace-nowrap rounded text-sm">Réponses: {{ count($item->answers->answers) }}/{{ $total }}</span>
                            <span class="bg-blue-100 text-blue-600 uppercase px-2 whitespace-nowrap rounded text-sm">Quota: {{ round(data_get(array_count_values($item->answers->answers), 'yes') / $total * 100) }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
