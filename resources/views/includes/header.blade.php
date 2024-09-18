<div class="bg-gray-100 h-px"></div>
<nav class="font-mono uppercase font-bold text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8">
    <a href="{{ route('index') }}" class="
        @switch(Route::currentRouteName())
        @case('index') pt-3 pl-3 pr-2 rounded-tr-md bg-gradient-to-bl from-orange-950/20 via-transparent opacity-80 @break
        @case('theory') pt-3 pl-3 pr-2 rounded-tr-md rounded-br-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default pt-3 pl-3 pr-2 rounded-tr-md bg-gradient-to-tl from-transparent via-orange-950/20 to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Dossier n° X/250
    </a>
    <a href="{{ route('theory') }}" class="
        @switch(Route::currentRouteName())
        @case('theory') pt-3 pl-3 pr-2 rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('index') pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('info') pt-3 pl-3 pr-2 rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Intro théorique
    </a>
    <a href="{{ route('info') }}" class="
        @switch(Route::currentRouteName())
        @case('info') pt-3 pl-3 pr-2 rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('theory') pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('stats') pt-3 pl-3 pr-2 rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Intro pratique
    </a>
    <a href="{{ route('stats') }}" class="
        @switch(Route::currentRouteName())
        @case('stats') pt-3 pl-3 pr-2 rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('info') pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('id') pt-3 pl-3 pr-2 rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Statistiques discriminations
    </a>
    <a href="{{ route('id') }}" class="
        @switch(Route::currentRouteName())
        @case('id') pt-3 pl-3 pr-2 rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('stats') pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('quotas') pt-3 pl-3 pr-2 rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Formulaire I.D.
    </a>
    <a href="{{ route('quotas') }}" class="
        @switch(Route::currentRouteName())
        @case('quotas') pt-3 pl-3 pr-2 rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('id') pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('brochure') pt-3 pl-3 pr-2 rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Formulaire quotas privilèges
    </a>
    <a href="{{ route('brochure') }}" class="
        @switch(Route::currentRouteName())
        @case('brochure') pt-3 pl-3 pr-2 rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('quotas') pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @case('vote') pt-3 pl-3 pr-2 rounded-t-md rounded-b-xl bg-gradient-to-tl from-orange-950/40 via-orange-950/20 opacity-60 hover:opacity-80 @break
        @default pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Brochure loterie sociale
    </a>
    <a href="{{ route('vote') }}" class="
        @switch(Route::currentRouteName())
        @case('vote') pt-3 pl-3 pr-2 rounded-t-md bg-gradient-to-b from-orange-950/20 via-transparent opacity-80 @break
        @case('brochure') pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/40 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @break
        @default pt-3 pl-3 pr-2 rounded-t-md rounded-bl-xl bg-gradient-to-tr from-orange-950/30 via-transparent to-orange-950/20 opacity-60 hover:opacity-80 @endswitch
        ">
        Formulaire vote final
    </a>
</nav>