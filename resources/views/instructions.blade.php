@extends('layouts.front')

@section('content')

<section class="sheet p-3 pb-16 shadow-xl">

    <h2 class="text-right text-2xl sm:text-4xl font-serif mb-8">{{ Auth::user()->order ?? 'X' }}/250</h2>

    <livewire:completion>

</section>

@endsection