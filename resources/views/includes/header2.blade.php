<nav class="font-mono uppercase font-bold text-sm grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8">
    <a href="{{ route('index') }}" class="p-3 {{ Route::currentRouteName() === 'index' ? '' : 'shadow-inner shadow-black/50' }}">Dossier n° x/250</a>
    <a href="{{ route('theory') }}" class="p-3 {{ Route::currentRouteName() === 'theory' ? '' : 'shadow-inner shadow-black/50' }}">Intro théorique</a>
    <a href="{{ route('info') }}" class="p-3 {{ Route::currentRouteName() === 'info' ? '' : 'shadow-inner shadow-black/50' }}">Intro pratique</a>
    <a href="{{ route('stats') }}" class="p-3 {{ Route::currentRouteName() === 'stats' ? '' : 'shadow-inner shadow-black/50' }}">Statistiques discriminations</a>
    <a href="{{ route('id') }}" class="p-3 {{ Route::currentRouteName() === 'id' ? '' : 'shadow-inner shadow-black/50' }}">Formulaire I.D.</a>
    <a href="{{ route('quotas') }}" class="p-3 {{ Route::currentRouteName() === 'quotas' ? '' : 'shadow-inner shadow-black/50' }}">Formulaire quotas privilèges</a>
    <a href="{{ route('brochure') }}" class="p-3 {{ Route::currentRouteName() === 'brochure' ? '' : 'shadow-inner shadow-black/50' }}">Brochure loterie sociale</a>
    <a href="{{ route('vote') }}" class="p-3 {{ Route::currentRouteName() === 'vote' ? '' : 'shadow-inner shadow-black/50' }}">Formulaire vote final</a>
</nav>