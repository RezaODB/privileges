@props(['proLink' => false])

<div {{ $attributes->merge(['class' => 'mt-8']) }}>
    <h2 class="font-bold mb-1">CONTACT: </h2>
    <div class="font-mono">
        <a href="mailto:lesprivilegesinvisibles@gmail.com" target="_blank" class="block hover:underline">lesprivilegesinvisibles@gmail.com</a>
        <a href="tel:0032472612641" target="_blank" class="block hover:underline">+32(0)472612641</a>
        <a href="https://www.barbaraiweins.be/" target="_blank" class="block hover:underline">www.barbaraiweins.be</a>
        <a href="https://www.instagram.com/barbaraiweins/" target="_blank" class="block hover:underline">Instagram</a>
        @if ($proLink)
            <a href="{{ route('pro.index') }}" class="mt-2 block hover:underline">{{ __('content.pro_link') }} &rarr;</a>
        @endif
        <a href="https://flechette.be/" target="_blank" class="mt-2 block hover:underline">Made by Fléchette © {{ date('Y') }}</a>
    </div>
</div>
