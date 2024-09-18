@extends('layouts.front')

@section('content')

<section class="max-w-screen-xl mx-auto px-2 border-b-2 border-black py-12 sm:py-24 grid sm:grid-cols-2 gap-8 items-start">
    <form action="{{ route('register') }}" method="post" class="grid grid-cols-1 gap-4 font-mono max-w-md">
        @csrf
        <input type="text" name="lastname" id="lastname" placeholder="Nom" class="border-none w-full focus:ring-0" required autofocus>
        <input type="text" name="firstname" id="firstname" placeholder="Prénom" class="border-none w-full focus:ring-0" required>
        <input type="email" name="email" id="email" placeholder="Email" class="border-none w-full focus:ring-0" required>
        <input type="password" name="password" id="password" placeholder="Mot de passe" class="border-none w-full focus:ring-0" required>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmer le mot de passe" class="border-none w-full focus:ring-0" required>
        <div class="flex gap-4 items-center">
            <button type="submit" class="bg-black text-white py-2 px-4 uppercase">Soumettre</button>
            <a href="" class="underline">Déjà inscrit?</a>
        </div>
    </form>

    <div class="uppercase font-medium border-2 border-black max-w-md ml-auto">
        <h1 class="text-3xl p-2 text-center">Les privilèges invisibles</h1>
        <h2 class="text-6xl text-center p-4 border-y-2 border-black"><span class="text-3xl">N°</span> x /250</h2>
        <div class="flex">
            <div class="border-r-2 border-black p-4 text-right">
                <h3 class="text-xl">Étude socio-artistique</h3>
                <h3 class="text-xl mt-2">Barbara Iweins</h3>
            </div>
            <h3 class="p-4 text-xl mt-2">2024/2025</h3>
        </div>
    </div>
</section>

@endsection