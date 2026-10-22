@extends('layouts.front')

@section('content')

<section class="sheet p-3 pb-16 shadow-xl">
    <div class="max-w-md font-mono px-2 sm:px-8 py-8 space-y-6">
        <h1 class="text-2xl sm:text-3xl font-serif uppercase">{{ __('content.error_not_found') }}</h1>
        <a href="{{ route('index') }}" class="inline-block uppercase text-sm underline hover:no-underline">{{ __('content.error_back_home') }}</a>
    </div>
</section>

@endsection
