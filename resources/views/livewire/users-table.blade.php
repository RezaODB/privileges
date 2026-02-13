<div class="overflow-x-auto overflow-y-auto max-h-[70vh]">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="sticky top-0 z-20 bg-gray-50">
            <tr>
                <th class="px-3 py-2 text-left font-semibold text-gray-700 bg-gray-50">Order</th>
                <th class="px-3 py-2 text-left font-semibold text-gray-700 bg-gray-50">User</th>
                <th class="px-3 py-2 text-left font-semibold text-gray-700 bg-gray-50">Email</th>
                <th class="px-3 py-2 text-left font-semibold text-gray-700 bg-gray-50">Phone</th>
                <th class="px-3 py-2 text-left font-semibold text-gray-700 bg-gray-50">Answers</th>
                <th class="px-3 py-2 text-left font-semibold text-gray-700 bg-gray-50">Votes</th>
                <th class="px-3 py-2 text-center font-semibold text-gray-700 bg-gray-50">Important</th>
                <th class="px-3 py-2 text-center font-semibold text-gray-700 bg-gray-50">Shot</th>
                <th class="px-3 py-2 text-center font-semibold text-gray-700 bg-gray-50">Questionnaire</th>
                <th class="px-3 py-2 text-center font-semibold text-gray-700 bg-gray-50">Interviewed</th>
                <th class="px-3 py-2 text-center font-semibold text-gray-700 bg-gray-50">Eject</th>
                <th class="px-3 py-2 text-right font-semibold text-gray-700 bg-gray-50">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
            @foreach ($this->users as $item)
                @php
                    $answersData = data_get($item->answers, 'answers', []);
                    $votesData = data_get($item->answers, 'votes', []);
                    $answersCount = count($answersData) - (array_key_exists('comment', $answersData) ? 1 : 0) - (array_key_exists('boosters', $answersData) ? 1 : 0);
                    $votesCount = count($votesData) - (array_key_exists('comment', $votesData) ? 1 : 0);
                @endphp
                <tr wire:key="user-row-{{ $item->id }}" class="hover:bg-gray-50 {{ $item->eject ? 'bg-red-50/40' : '' }}">
                    <td class="px-3 py-2 font-semibold text-gray-600">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <a href="{{ route('users.show', $item) }}" class="text-blue-600 hover:underline">{{ $item->lastname . ' ' . $item->name }}</a>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <a href="mailto:{{ $item->email }}" class="underline">{{ $item->email }}</a>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <a href="tel:{{ $item->phone }}" class="underline">{{ $item->phone }}</a>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">{{ $answersCount }}/{{ $this->quotasCount }}</td>
                    <td class="px-3 py-2 whitespace-nowrap">{{ $votesCount }}/{{ $this->votesCount }}</td>
                    <td class="px-3 py-2 text-center">
                        <input
                            type="checkbox"
                            @checked($item->important)
                            wire:change="updateFlag({{ $item->id }}, 'important', $event.target.checked)"
                            wire:loading.attr="disabled"
                            wire:target="updateFlag"
                        >
                    </td>
                    <td class="px-3 py-2 text-center">
                        <input
                            type="checkbox"
                            @checked($item->shot)
                            wire:change="updateFlag({{ $item->id }}, 'shot', $event.target.checked)"
                            wire:loading.attr="disabled"
                            wire:target="updateFlag"
                        >
                    </td>
                    <td class="px-3 py-2 text-center">
                        <input
                            type="checkbox"
                            @checked($item->questionnaire)
                            wire:change="updateFlag({{ $item->id }}, 'questionnaire', $event.target.checked)"
                            wire:loading.attr="disabled"
                            wire:target="updateFlag"
                        >
                    </td>
                    <td class="px-3 py-2 text-center">
                        <input
                            type="checkbox"
                            @checked($item->interviewed)
                            wire:change="updateFlag({{ $item->id }}, 'interviewed', $event.target.checked)"
                            wire:loading.attr="disabled"
                            wire:target="updateFlag"
                        >
                    </td>
                    <td class="px-3 py-2 text-center">
                        <input
                            type="checkbox"
                            @checked($item->eject)
                            wire:change="updateFlag({{ $item->id }}, 'eject', $event.target.checked)"
                            wire:loading.attr="disabled"
                            wire:target="updateFlag"
                        >
                    </td>
                    <td class="px-3 py-2 text-right">
                        <form action="{{ route('users.destroy', $item) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-red-600 text-xs uppercase hover:underline" onclick="return confirm('Delete item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
