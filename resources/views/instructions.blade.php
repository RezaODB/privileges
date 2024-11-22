@extends('layouts.front')

@section('content')

<section class="p-4 sm:p-8 bg-[#fdf2e3] rounded-xl">
    <h1 class="uppercase text-3xl">{{ __('content.instructions') }}</h1>
    <form class="font-mono uppercase mt-8 grid grid-cols-3 gap-y-4">
        <label for="check1" class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">1. S'enregister et approuver <a href="{{ route('policy') }}" class="underline whitespace-nowrap">les conditions d'utilisation</a> du site</label>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <span>10min</span>
            <input type="checkbox" id="check1" class="border-none text-zinc-800 focus:ring-0 checked:bg-none" @checked(Auth::user())>
        </div>
        <label for="check2" class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">2. Lire ou écouter <a href="{{ route('step1') }}" class="underline whitespace-nowrap">la partie théorique</a></label>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <span>20min</span>
            <input type="checkbox" id="check2" class="border-none text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <label for="check3" class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">3. Parcourir les étapes 
            <a href="{{ route('step2') }}" class="underline whitespace-nowrap">Quota privilèges</a>, 
            <a href="{{ route('step3') }}" class="underline whitespace-nowrap">Loterie sociale</a>, 
            <a href="{{ route('step4') }}" class="underline whitespace-nowrap">Session photo</a>, 
            <a href="{{ route('step5') }}" class="underline whitespace-nowrap">Cartographie</a> et 
            <a href="{{ route('step6') }}" class="underline whitespace-nowrap">Étude sculpturale</a>
        </label>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <span>30min</span>
            <input type="checkbox" id="check3" class="border-none text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <label for="check4" class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">4. Recevoir la notification du départ de l'étude via <a href="">le groupe Whatsapp</a></label>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <input type="checkbox" id="check4" class="border-none text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <label for="check5" class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">5. Remplir le <a href="{{ route('step2') }}" class="underline whitespace-nowrap">questionnaire quota des privilèges</a></label>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <span>30min</span>
            <input type="checkbox" id="check5" class="border-none text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <label for="check6" class="col-span-2 pb-4 border-b-2 border-dotted border-zinc-800">6. Lire la brochure et remplir le <a href="{{ route('step3') }}" class="underline whitespace-nowrap">bulletin de vote sur la loterie sociale</a></label>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-dotted border-zinc-800">
            <span>30min</span>
            <input type="checkbox" id="check6" class="border-none text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <label for="check7" class="col-span-2 pb-4 border-b-2 border-zinc-800">7. Passer au studio pour la <a href="{{ route('step4') }}" class="underline whitespace-nowrap">session photo</a> et l'enregistrement de notre entretien</label>
        <div class="flex items-center justify-end gap-4 pb-4 border-b-2 border-zinc-800">
            <span>120min</span>
            <input type="checkbox" id="check7" class="border-none text-zinc-800 focus:ring-0 checked:bg-none">
        </div>
        <label class="col-span-2">TOTAL: </label>
        <div class="flex items-center justify-end gap-4">
            <span>240min</span>
        </div>
    </form>
</section>

@endsection