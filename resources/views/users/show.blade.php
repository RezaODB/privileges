<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl 2xl:max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-600 rounded-md text-white inline-block">Back to users</a>
                        <a href="{{ route('users.export', $user) }}" class="px-4 py-2 bg-green-600 rounded-md text-white">Export to CSV</a>
                    </div>
                    <div class="divide-y">
                       <div class="flex gap-4"><span class="w-60"></span>#{{ $user->order }}</div>
                       <div class="flex gap-4"><span class="w-60">LASTNAME: </span>{{ $user->lastname }}</div>
                       <div class="flex gap-4"><span class="w-60">GIVEN NAME: </span>{{ $user->name }}</div>
                       <div class="flex gap-4"><span class="w-60">EMAIL: </span><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
                       <div class="flex gap-4"><span class="w-60">PHONE: </span><a href="tel:{{ $user->phone }}">{{ $user->phone }}</a></div>
                       <div class="flex gap-4"><span class="w-60">DATE OF BIRTH: </span>{{ $user->birthday->isoFormat('DD MMMM YYYY') }}</div>
                       <div class="flex gap-4"><span class="w-60">SEX: </span>{{ Str::ucfirst($user->sex) }}</div>
                       <div class="flex gap-4"><span class="w-60">POSTAL CODE: </span>{{ $user->zip }}</div>
                       <div class="flex gap-4"><span class="w-60">VIDEO RECORDING: </span>{{ $user->video ? 'NO' : 'YES' }}</div>
                       <br>
                       <div class="flex gap-4"><span class="w-60">ANSWERS: </span>{{ count($user->answers->answers) - array_key_exists('comment', $user->answers->answers) - array_key_exists('boosters', $user->answers->answers) }}/{{ $quotas->count() }}</div>
                       <div class="flex gap-4"><span class="w-60">COMMENT: </span>{{ data_get($user->answers->answers, 'comment') }}</div>
                       {{-- <br>
                       <div class="flex gap-4"><span class="w-60">VOTES: </span>{{ count($user->answers->votes) - array_key_exists('comment', $user->answers->votes) }}/{{ $votes }}</div>
                       <div class="flex gap-4"><span class="w-60">LOTERIE: </span>{{ data_get(array_count_values($user->answers->votes), 'yes') ?? 0 }} IN FAVOR</div>
                       <div class="flex gap-4"><span class="w-60">COMMENT: </span>{{ data_get($user->answers->votes, 'comment') }}</div> --}}
                    </div>
                    <h2 class="font-bold">QUOTAS: </h2>
                    <div class="divide-y">
                        @foreach ($quotas as $quota)
                        <div>
                            {{ $quota->question_fr }}: {{ Str::upper(data_get($user->answers->answers, $quota->id)) }}
                            <span class="font-bold">{{ in_array($quota->id, data_get($user->answers->answers, 'boosters', [])) ? 'BOOSTER' : '' }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
