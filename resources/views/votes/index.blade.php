<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl 2xl:max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('votes.create') }}" class="px-4 py-2 bg-green-600 rounded-md text-white">Create</a>
                    </div>
                    <div class="divide-y">
                        @foreach ($votes as $item)
                            <div class="flex gap-4 items-center p-1 hover:bg-gray-100">
                                <span class="font-bold text-gray-600">{{ $loop->iteration }}</span>
                                <form action="{{ route('votes.update', $item) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="number" name="order" value="{{ $item->order }}" min="0" max="999" step="1" onchange="this.form.submit()" class="p-1 border-gray-200 shadow rounded-md">
                                </form>
                                <a href="{{ route('votes.edit', $item) }}" class="text-blue-600 hover:underline">{{ Str::limit($item->question_fr, 100) }}</a>
                                <form action="{{ route('votes.destroy', $item) }}" method="post" class="ml-auto">
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