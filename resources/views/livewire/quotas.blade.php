<form wire:submit class="grid grid-cols-[1fr_auto] px-2 sm:px-8 mt-16" wire:submit="submit">
    <h2 class="text-3xl uppercase border-b-2 border-zinc-800 pb-4 self-end">{{ __('content.form') }}</h2>
    <div class="text-xl uppercase font-medium border-b-2 border-zinc-800 pb-6 flex items-end justify-around">
        <h3 class="[writing-mode:vertical-lr]">{{ __('content.always') }}</h3>
        <h3 class="[writing-mode:vertical-lr]">{{ __('content.often') }}</h3>
        <h3 class="[writing-mode:vertical-lr]">{{ __('content.sometimes') }}</h3>
        <h3 class="[writing-mode:vertical-lr]">{{ __('content.rarely') }}</h3>
        <h3 class="[writing-mode:vertical-lr]">{{ __('content.never') }}</h3>
        <h3 class="[writing-mode:vertical-lr]">BOOSTERS (3)</h3>
    </div>
    @foreach ($quotas as $item)
    <div class="font-mono py-3 border-b-2 border-zinc-800 border-dotted flex items-start gap-4 pr-4">
        <span class="hidden sm:block font-bold">{{ sprintf('%03d', $loop->iteration) }}</span>
        {{ $item->{'question_' . app()->getLocale()} }}
        <div>@error('answers.*') {{ $message }} @enderror</div>
    </div>
    <div class="py-3 border-b-2 border-zinc-800 border-dotted flex items-center justify-end gap-4 ml-px">
        <input type="radio" wire:model.live="answers.{{ $item->id }}" value="always" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none"> 
        <input type="radio" wire:model.live="answers.{{ $item->id }}" value="often" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none"> 
        <input type="radio" wire:model.live="answers.{{ $item->id }}" value="sometimes" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none"> 
        <input type="radio" wire:model.live="answers.{{ $item->id }}" value="rarely" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none"> 
        <input type="radio" wire:model.live="answers.{{ $item->id }}" value="never" class="rounded-none w-8 h-3 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3] disabled:border-none"> 
        <input type="checkbox" wire:model.live="boosters" value="{{ $item->id }}" class="rounded-full w-6 h-6 mx-2 text-zinc-800 checked:bg-none focus:ring-0 disabled:bg-[#fdf2e3]" {{ count($boosters) >= 3 && !in_array($item->id, $boosters) ? 'disabled' : '' }}> 
    </div>
    @endforeach
    <div class="flex flex-col lg:flex-row gap-x-6 gap-y-4 mt-12 col-span-2">
        <label for="comment" class="text-3xl uppercase">{{ __('content.comment') }}</label>
        <textarea wire:model.live.debounce.1000ms="answers.comment" id="comment" rows="5" class="w-full h-full focus:ring-0 disabled:bg-[#fdf2e3]"></textarea>
    </div>
    <div class="col-span-2 mt-12 text-right">
        <button type="submit" class="border-2 border-zinc-800 font-bold py-2 px-4 uppercase hover:underline">{{ __('content.submit')  }}</button>
    </div>
</form>