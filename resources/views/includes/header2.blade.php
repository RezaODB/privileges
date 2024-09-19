<nav class="font-mono uppercase font-bold text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8">
    <a href="{{ route('index') }}" class="pt-3 pl-3 pr-2 pb-3 sm:pb-0
        @switch(Route::currentRouteName())
        @case('index') rounded-tr-md bg-gradient-to-bl from-orange-950/20 via-transparent opacity-80 @break
        @case('theory') rounded-tr-md rounded-br-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default rounded-tr-md bg-gradient-to-tl from-transparent via-orange-950/20 to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Dossier n° x/250
    </a>
    <a href="{{ route('theory') }}" class="pt-3 pl-3 pr-2 pb-3 sm:pb-0
        @switch(Route::currentRouteName())
        @case('theory') rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('index') rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('info') rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Intro théorique
    </a>
    <a href="{{ route('info') }}" class="pt-3 pl-3 pr-2 pb-3 sm:pb-0
        @switch(Route::currentRouteName())
        @case('info') rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('theory') rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('stats') rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Intro pratique
    </a>
    <a href="{{ route('stats') }}" class="pt-3 pl-3 pr-2 pb-3 sm:pb-0
        @switch(Route::currentRouteName())
        @case('stats') rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('info') rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('id') rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Statistiques discriminations
    </a>
    <a href="{{ route('id') }}" class="pt-3 pl-3 pr-2 pb-3 sm:pb-0
        @switch(Route::currentRouteName())
        @case('id') rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('stats') rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('quotas') rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Formulaire I.D.
    </a>
    <a href="{{ route('quotas') }}" class="pt-3 pl-3 pr-2 pb-3 sm:pb-0
        @switch(Route::currentRouteName())
        @case('quotas') rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('id') rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('brochure') rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Formulaire quotas privilèges
    </a>
    <a href="{{ route('brochure') }}" class="pt-3 pl-3 pr-2 pb-3 sm:pb-0
        @switch(Route::currentRouteName())
        @case('brochure') rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('quotas') rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('vote') rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Brochure loterie sociale
    </a>
    <a href="{{ route('vote') }}" class="pt-3 pl-3 pr-2 pb-3 sm:pb-0
        @switch(Route::currentRouteName())
        @case('vote') rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('brochure') rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @default rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Formulaire vote final
    </a>
</nav>