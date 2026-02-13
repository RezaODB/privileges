<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl 2xl:max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <a href="{{ route('users.export_users') }}" class="px-4 py-2 bg-gray-600 rounded-md text-white inline-block">Export to CSV</a>
                    <div class="overflow-x-auto">
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
                                @foreach ($users as $item)
                                    @php
                                        $answersData = data_get($item->answers, 'answers', []);
                                        $votesData = data_get($item->answers, 'votes', []);
                                        $answersCount = count($answersData) - (array_key_exists('comment', $answersData) ? 1 : 0) - (array_key_exists('boosters', $answersData) ? 1 : 0);
                                        $votesCount = count($votesData) - (array_key_exists('comment', $votesData) ? 1 : 0);
                                    @endphp
                                    <tr class="hover:bg-gray-50 {{ $item->eject ? 'bg-red-50/40' : '' }}">
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
                                        <td class="px-3 py-2 whitespace-nowrap">{{ $answersCount }}/{{ $quotas }}</td>
                                        <td class="px-3 py-2 whitespace-nowrap">{{ $votesCount }}/{{ $votes }}</td>
                                        <td class="px-3 py-2 text-center">
                                            <form action="{{ route('users.flags.update', $item) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="important" value="0">
                                                <input type="hidden" name="shot" value="{{ $item->shot ? 1 : 0 }}">
                                                <input type="hidden" name="questionnaire" value="{{ $item->questionnaire ? 1 : 0 }}">
                                                <input type="hidden" name="interviewed" value="{{ $item->interviewed ? 1 : 0 }}">
                                                <input type="hidden" name="eject" value="{{ $item->eject ? 1 : 0 }}">
                                                <input type="checkbox" name="important" value="1" {{ $item->important ? 'checked' : '' }} onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <form action="{{ route('users.flags.update', $item) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="important" value="{{ $item->important ? 1 : 0 }}">
                                                <input type="hidden" name="shot" value="0">
                                                <input type="hidden" name="questionnaire" value="{{ $item->questionnaire ? 1 : 0 }}">
                                                <input type="hidden" name="interviewed" value="{{ $item->interviewed ? 1 : 0 }}">
                                                <input type="hidden" name="eject" value="{{ $item->eject ? 1 : 0 }}">
                                                <input type="checkbox" name="shot" value="1" {{ $item->shot ? 'checked' : '' }} onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <form action="{{ route('users.flags.update', $item) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="important" value="{{ $item->important ? 1 : 0 }}">
                                                <input type="hidden" name="shot" value="{{ $item->shot ? 1 : 0 }}">
                                                <input type="hidden" name="questionnaire" value="0">
                                                <input type="hidden" name="interviewed" value="{{ $item->interviewed ? 1 : 0 }}">
                                                <input type="hidden" name="eject" value="{{ $item->eject ? 1 : 0 }}">
                                                <input type="checkbox" name="questionnaire" value="1" {{ $item->questionnaire ? 'checked' : '' }} onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <form action="{{ route('users.flags.update', $item) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="important" value="{{ $item->important ? 1 : 0 }}">
                                                <input type="hidden" name="shot" value="{{ $item->shot ? 1 : 0 }}">
                                                <input type="hidden" name="questionnaire" value="{{ $item->questionnaire ? 1 : 0 }}">
                                                <input type="hidden" name="interviewed" value="0">
                                                <input type="hidden" name="eject" value="{{ $item->eject ? 1 : 0 }}">
                                                <input type="checkbox" name="interviewed" value="1" {{ $item->interviewed ? 'checked' : '' }} onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <form action="{{ route('users.flags.update', $item) }}" method="post">
                                                @csrf
                                                @method('patch')
                                                <input type="hidden" name="important" value="{{ $item->important ? 1 : 0 }}">
                                                <input type="hidden" name="shot" value="{{ $item->shot ? 1 : 0 }}">
                                                <input type="hidden" name="questionnaire" value="{{ $item->questionnaire ? 1 : 0 }}">
                                                <input type="hidden" name="interviewed" value="{{ $item->interviewed ? 1 : 0 }}">
                                                <input type="hidden" name="eject" value="0">
                                                <input type="checkbox" name="eject" value="1" {{ $item->eject ? 'checked' : '' }} onchange="this.form.submit()">
                                            </form>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
