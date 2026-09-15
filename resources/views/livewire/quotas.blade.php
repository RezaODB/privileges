<section class="px-2 sm:px-8 mt-16">
    <div class="font-mono p-4 bg-white rounded-xl mb-12">
        @if (session('status'))
        <div class="font-bold mb-1">{{ __('content.form_saved') }}</div>
        @endif
        @if ($this->savedCount > 0)
        {{ __('content.answers_saved', ['count' => $this->savedCount, 'total' => $quotas->count()]) }}
        @else
        {{ __('content.answers_none_saved') }}
        @endif
    </div>
    <h2 class="text-3xl font-serif uppercase">{{ __('content.form') }}</h2>
    <form wire:submit="submit" action="{{ route('answers.store') }}" method="POST">
        @csrf
        <div class="flex flex-col h-screen">
            <div class="flex-grow overflow-auto">
              <table class="relative w-full">
                <thead>
                  <tr class="text-xl text-right uppercase font-medium border-b-2 border-zinc-800">
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
                    @php($chosen = data_get($answers, $item->id))
                    <tr class="py-3">
                        <td class="font-mono py-3 flex gap-4 pr-4">
                            <span class="hidden sm:block font-bold">{{ sprintf('%03d', $loop->iteration) }}</span>
                            <div>
                                <div>{{ $item->{'question_' . app()->getLocale()} }}</div>
                                <div>@error('answers.*') {{ $message }} @enderror</div>
                            </div>
                        </td>
                        @foreach (['always', 'often', 'sometimes', 'rarely', 'never'] as $scale)
                        <td class="px-2"><input type="radio" name="answers[{{ $item->id }}]" value="{{ $scale }}" @checked($chosen === $scale) wire:model.live="answers.{{ $item->id }}" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-transparent disabled:border-none"></td>
                        @endforeach
                        <td class="px-2"><input type="checkbox" name="boosters[]" value="{{ $item->id }}" @checked(in_array($item->id, $boosters)) wire:model.live="boosters" class="rounded-full w-6 h-6 mx-2 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-transparent" {{ count($boosters) >= 3 && !in_array($item->id, $boosters) ? 'disabled' : '' }}>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        <div class="flex flex-col lg:flex-row gap-x-6 gap-y-4 mt-12">
            <label for="comment" class="text-3xl font-serif uppercase">{{ __('content.comment') }}</label>
            <textarea name="comment" wire:model.blur="answers.comment" id="comment" rows="5" class="w-full h-full focus:ring-0 disabled:bg-transparent">{{ data_get($answers, 'comment') }}</textarea>
        </div>
        <div class="mt-12 flex flex-col sm:flex-row items-end sm:items-center justify-end gap-4">
            <span class="font-mono text-sm">{{ __('content.answers_saved', ['count' => $this->savedCount, 'total' => $quotas->count()]) }}</span>
            <button type="submit" class="border-2 border-zinc-800 font-bold py-2 px-4 uppercase hover:underline">{{ __('content.submit')  }}</button>
        </div>
    </form>
</section>
