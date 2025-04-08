<section class="px-2 sm:px-8 mt-16">
    @if (session('status'))
    <div class="font-mono p-4 bg-white rounded-xl mb-12">
        @if (app()->isLocale('fr'))
        Formulaire sauvegardé. Vous avez répondu à {{ count($answers) - array_key_exists('comment', $answers) - array_key_exists('boosters', $answers) }} questions sur {{ $quotas->count() }}.
        @endif
        @if (app()->isLocale('en'))
        Form saved. You have answered {{ count($answers) - array_key_exists('comment', $answers) - array_key_exists('boosters', $answers) }} of {{ $quotas->count() }} questions.
        @endif
    </div>
    @endif
    <h2 class="text-3xl uppercase">{{ __('content.form') }}</h2>
    <form wire:submit>
        <div class="flex flex-col h-screen">
            <div class="flex-grow overflow-auto">
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
                            <div>
                                <div>{{ $item->{'question_' . app()->getLocale()} }}</div>
                                <div>@error('answers.*') {{ $message }} @enderror</div>
                            </div>
                        </td>
                        <td class="px-2"><input type="radio" wire:model.live="answers.{{ $item->id }}" value="always" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none"></td>
                        <td class="px-2"><input type="radio" wire:model.live="answers.{{ $item->id }}" value="often" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none"></td> 
                        <td class="px-2"><input type="radio" wire:model.live="answers.{{ $item->id }}" value="sometimes" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none"></td> 
                        <td class="px-2"><input type="radio" wire:model.live="answers.{{ $item->id }}" value="rarely" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none"></td> 
                        <td class="px-2"><input type="radio" wire:model.live="answers.{{ $item->id }}" value="never" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none"></td> 
                        <td class="px-2"><input type="checkbox" wire:model.live="boosters" value="{{ $item->id }}" class="rounded-full w-6 h-6 mx-2 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3]" {{ count($boosters) >= 3 && !in_array($item->id, $boosters) ? 'disabled' : '' }}> 
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        {{-- <div class="text-xl uppercase font-medium border-b-2 border-zinc-800 pb-6 flex items-end justify-around">
           
        </div>
        @foreach ($quotas as $item)
        <div class="font-mono py-3 border-b-2 border-zinc-800 border-dotted flex items-start gap-4 pr-4">
            <span class="hidden sm:block font-bold">{{ sprintf('%03d', $loop->iteration) }}</span>
            <div>
                <div>{{ $item->{'question_' . app()->getLocale()} }}</div>
                <div>@error('answers.*') {{ $message }} @enderror</div>
            </div>
        </div>
        <div class="py-3 border-b-2 border-zinc-800 border-dotted flex items-center justify-end gap-4 ml-px">
            <input type="radio" wire:model.live="answers.{{ $item->id }}" value="always" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none"> 
            
        </div>
        @endforeach --}}
        <div class="flex flex-col lg:flex-row gap-x-6 gap-y-4 mt-12">
            <label for="comment" class="text-3xl uppercase">{{ __('content.comment') }}</label>
            <textarea wire:model.live.debounce.1000ms="answers.comment" id="comment" rows="5" class="w-full h-full focus:ring-0 disabled:bg-[#fdf2e3]"></textarea>
        </div>
        <div class="mt-12 text-right">
            <button wire:click="submit" class="border-2 border-zinc-800 font-bold py-2 px-4 uppercase hover:underline">{{ __('content.submit')  }}</button>
        </div>
    </form>
</section>
