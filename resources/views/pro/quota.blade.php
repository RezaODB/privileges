<section class="px-2 sm:px-8 mt-16">

    <h2 class="text-3xl uppercase">{{ __('content.form') }}</h2>
    <p class="font-mono max-w-2xl mt-4">{{ __('content.pro_quota_note') }}</p>

    <div class="overflow-x-auto mt-8">
        <table class="relative w-full">
            <thead>
                <tr class="text-xl text-right uppercase font-medium border-b-2 border-zinc-800 sticky top-0 bg-[#fdf2e3]">
                    <td></td>
                    <td class="[writing-mode:vertical-lr] py-3">{{ __('content.always') }}</td>
                    <td class="[writing-mode:vertical-lr] py-3">{{ __('content.often') }}</td>
                    <td class="[writing-mode:vertical-lr] py-3">{{ __('content.sometimes') }}</td>
                    <td class="[writing-mode:vertical-lr] py-3">{{ __('content.rarely') }}</td>
                    <td class="[writing-mode:vertical-lr] py-3">{{ __('content.never') }}</td>
                    <td class="[writing-mode:vertical-lr] py-3">BOOSTERS (3)</td>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @foreach ($quotas as $item)
                    <tr class="py-3">
                        <td class="font-mono py-3 flex gap-4 pr-4">
                            <span class="hidden sm:block font-bold">{{ sprintf('%03d', $loop->iteration) }}</span>
                            <div>{{ $item->{'question_'.app()->getLocale()} ?: $item->question_fr }}</div>
                        </td>
                        @foreach (['always', 'often', 'sometimes', 'rarely', 'never'] as $degree)
                            <td class="px-2">
                                <input type="radio" disabled aria-hidden="true" class="rounded-none w-8 h-3 bg-transparent border-zinc-800/50 focus:ring-0">
                            </td>
                        @endforeach
                        <td class="px-2">
                            <input type="checkbox" disabled aria-hidden="true" class="rounded-full w-6 h-6 mx-2 bg-transparent border-zinc-800/50 focus:ring-0">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</section>
