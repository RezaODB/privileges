<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('quotas.create') }}" class="px-4 py-2 bg-green-600 rounded-md text-white">Create</a>
                        <a href="{{ route('export') }}" class="px-4 py-2 bg-gray-600 rounded-md text-white">Export to CSV</a>
                    </div>
                    <div class="divide-y">
                        @foreach ($quotas as $item)
                            <div class="flex gap-4 items-center p-1 hover:bg-gray-100 text-sm">
                                <span class="font-bold text-gray-600">{{ $loop->iteration }}</span>
                                <div class="flex flex-col gap-0 justify-center items-center">
                                    <form action="{{ route('quotas.update', $item) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="order" value="{{ $item->order - 1 }}">
                                        <button class="text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('quotas.update', $item) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="order" value="{{ $item->order + 1 }}">
                                        <button class="text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <span class="bg-green-100 text-green-600 uppercase font-bold px-2 whitespace-nowrap rounded">{{ $item->category }}</span>
                                <a href="{{ route('quotas.edit', $item) }}" class="text-blue-600 hover:underline">{{ Str::limit($item->question_fr, 100, '...') }}</a>
                                <form action="{{ route('quotas.destroy', $item) }}" method="post" class="ml-auto">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-red-600 uppercase hover:underline" onclick="return confirm('Delete item?')">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>