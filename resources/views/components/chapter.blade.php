@props(['title', 'body', 'open' => false])

<div class="font-mono mb-4 px-2 sm:px-8" x-data="{ open: {{ $open ? 'true' : 'false' }} }">
    <div class="flex items-baseline justify-between gap-4 border-zinc-800 border-b-2 pb-4 cursor-pointer" x-on:click="open = !open">
        <h1 class="text-2xl sm:text-3xl font-serif uppercase">{{ $title }}</h1>
        <h2 x-text="open ? '(- Close)' : '(+ Open)'" class="whitespace-nowrap"></h2>
    </div>
    <div x-show="open" x-collapse>
        <div class="flex lg:divide-x divide-zinc-800">
            <div class="h-12 flex-1"></div>
            <div class="h-12 flex-1"></div>
        </div>
        <div class="pb-12 prose max-w-none columns-md gap-12 [orphans:2] [widows:2] [column-rule:1px_solid_#27272a] prose-headings:break-after-avoid prose-headings:break-inside-avoid prose-ol:ml-4 prose-li:text-justify prose-a:underline prose-p:text-justify prose-h2:font-mono prose-h2:text-2xl prose-h2:uppercase prose-h2:font-normal prose-h2:border-b prose-h2:border-zinc-800 prose-h2:pb-4 prose-h2:-mx-6 prose-h2:px-6 prose-h3:font-mono prose-h3:uppercase prose-h3:font-medium prose-h3:text-lg prose-blockquote:border-y prose-blockquote:border-x-0 prose-blockquote:border-zinc-800 prose-blockquote:-mx-6 prose-blockquote:text-xl prose-blockquote:uppercase prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:not-italic prose-blockquote:text-center prose-blockquote:text-[#374151] overflow-hidden">{!! $body !!}</div>
    </div>
</div>
