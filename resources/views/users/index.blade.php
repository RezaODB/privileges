<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="divide-y">
                        @foreach ($users as $item)
                        <div class="flex gap-4 items-center p-1 hover:bg-gray-100 overflow-scroll">
                            <span class="font-bold text-gray-600">{{ $item->order ?? '0' }}</span>
                            <a href="{{ route('users.show', $item) }}" class="text-blue-600 whitespace-nowrap hover:underline">{{ $item->lastname . ' ' . $item->name }}</a>
                            <a href="mailto:{{ $item->email }}" class="whitespace-nowrap underline">{{ $item->email }}</a>
                            <a href="tel:{{ $item->phone }}" class="whitespace-nowrap underline">{{ $item->phone }}</a>
                            <span class="bg-slate-100 text-slate-600 uppercase px-2 whitespace-nowrap rounded text-sm">Réponses: {{ count($item->answers->answers) - array_key_exists('comment', $item->answers->answers) - array_key_exists('boosters', $item->answers->answers) }}/{{ $quotas }}</span>
                            <span class="bg-slate-100 text-slate-600 uppercase px-2 whitespace-nowrap rounded text-sm">Votes: {{ count($item->answers->votes) - array_key_exists('comment', $item->answers->votes) }}/{{ $votes }}</span>
                            {{-- <span class="bg-slate-300 text-slate-800 uppercase px-2 whitespace-nowrap rounded text-sm">Loterie: {{ data_get(array_count_values($item->answers->votes), 'yes') ?? 0 }} POUR</span> --}}
                            <form action="{{ route('users.destroy', $item) }}" method="post" class="ml-auto">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-red-600 text-sm uppercase hover:underline" onclick="return confirm('Delete item?')">Delete</button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
