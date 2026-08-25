@php($participantLinks = [
    ['route' => 'users.index', 'pattern' => 'users.*', 'label' => 'Participants'],
    ['route' => 'theories.index', 'pattern' => 'theories.*', 'label' => 'Théorie'],
    ['route' => 'intros.index', 'pattern' => 'intros.*', 'label' => 'Quota'],
    ['route' => 'quotas.index', 'pattern' => 'quotas.*', 'label' => 'Questionnaire'],
    ['route' => 'brochures.index', 'pattern' => 'brochures.*', 'label' => 'Loterie'],
    ['route' => 'votes.index', 'pattern' => 'votes.*', 'label' => 'Vote'],
    ['route' => 'photos.index', 'pattern' => 'photos.*', 'label' => 'Photo'],
    ['route' => 'maps.index', 'pattern' => 'maps.*', 'label' => 'Cartographie'],
    ['route' => 'sculptures.index', 'pattern' => 'sculptures.*', 'label' => 'Sculpture'],
    ['route' => 'faqs.index', 'pattern' => 'faqs.*', 'label' => 'FAQ'],
])

@php($proLinks = [
    ['route' => 'sections.index', 'pattern' => 'sections.*|chapters.*|films.*', 'label' => 'Onglets'],
    ['route' => 'documents.index', 'pattern' => 'documents.*', 'label' => 'Documents'],
])

<aside x-bind:class="open ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col bg-white border-r border-gray-200 overflow-y-auto transform transition-transform duration-200 lg:translate-x-0">

    <div class="flex items-start justify-between gap-2 px-4 py-5 border-b border-gray-200">
        <div>
            <div class="font-semibold leading-tight">Les privilèges invisibles</div>
            <a href="{{ route('index') }}" target="_blank" class="text-sm text-blue-600 hover:underline">Voir le site &rarr;</a>
        </div>
        <button type="button" x-on:click="open = false" class="lg:hidden -me-2 p-2 text-gray-400 hover:text-gray-600" aria-label="Fermer le menu">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 py-4 space-y-6">
        <div>
            <div class="px-4 pb-1 text-xs uppercase tracking-wider text-gray-400">Participants</div>
            @foreach ($participantLinks as $link)
                <x-responsive-nav-link :href="route($link['route'])" :active="request()->routeIs(explode('|', $link['pattern']))">{{ $link['label'] }}</x-responsive-nav-link>
            @endforeach
        </div>

        <div>
            <div class="px-4 pb-1 text-xs uppercase tracking-wider text-gray-400">Dossier pro</div>
            @foreach ($proLinks as $link)
                <x-responsive-nav-link :href="route($link['route'])" :active="request()->routeIs(explode('|', $link['pattern']))">{{ $link['label'] }}</x-responsive-nav-link>
            @endforeach
        </div>
    </nav>

    <div class="border-t border-gray-200 py-4">
        <div class="px-4 pb-2">
            <div class="font-medium text-sm text-gray-800">{{ Auth::user()->name }}</div>
            <div class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
        </div>
        <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">{{ __('Profile') }}</x-responsive-nav-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-responsive-nav-link>
        </form>
    </div>

</aside>
