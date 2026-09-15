@php($uploadLimit = min(
    (int) filter_var(ini_get('upload_max_filesize'), FILTER_SANITIZE_NUMBER_INT),
    (int) filter_var(ini_get('post_max_size'), FILTER_SANITIZE_NUMBER_INT)
))

<div class="grid grid-cols-1 gap-4">

    <div>
        <label for="lang" class="block font-medium mb-1">Langue</label>
        <select name="lang" id="lang" class="border-gray-200 shadow rounded-md">
            <option value="fr" @selected(old('lang', $podcast->lang ?? 'fr') === 'fr')>Français</option>
            <option value="en" @selected(old('lang', $podcast->lang ?? 'fr') === 'en')>Anglais</option>
        </select>
        <p class="text-sm text-gray-500 mt-1">Chaque langue a sa propre liste&nbsp;: un podcast français ne s'affiche pas sur la page anglaise.</p>
    </div>
    @error('lang')<div class="text-red-500">{{ $message }}</div>@enderror

    <input type="text" name="title" placeholder="Titre — ex. Cadre théorique" value="{{ old('title', $podcast->title) }}" class="border-gray-200 shadow rounded-md" required>
    @error('title')<div class="text-red-500">{{ $message }}</div>@enderror

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <input type="text" name="guest" placeholder="Avec… — facultatif" value="{{ old('guest', $podcast->guest) }}" class="w-full border-gray-200 shadow rounded-md">
            @error('guest')<div class="text-red-500">{{ $message }}</div>@enderror
        </div>
        <div>
            <input type="text" name="duration" placeholder="Durée — ex. 24 min" value="{{ old('duration', $podcast->duration) }}" class="w-full border-gray-200 shadow rounded-md">
            @error('duration')<div class="text-red-500">{{ $message }}</div>@enderror
        </div>
        <p class="text-sm text-gray-500 sm:col-span-2">&laquo;&nbsp;Avec Nathalie Achard&nbsp;&raquo; s'affiche sous le titre, la durée &agrave; sa droite. La dur&eacute;e est saisie &agrave; la main&nbsp;: rien ne la calcule.</p>
    </div>

    <div>
        <label class="block font-medium mb-1">Fichier audio</label>
        <input type="file" name="file" accept="audio/mpeg,audio/mp4" data-max-mb="{{ $uploadLimit }}" class="block" @unless ($podcast->exists) required @endunless>
        <p class="text-sm text-gray-500 mt-1">
            MP3 ou M4A. Ce serveur accepte les fichiers jusqu'&agrave; <strong>{{ $uploadLimit }} Mo</strong>.
            @if ($podcast->exists)
                Laissez vide pour conserver l'audio actuel.
            @endif
        </p>
        <p data-file-too-big class="text-sm text-red-500 mt-1 hidden">Ce fichier dépasse la limite du serveur, l'envoi échouera.</p>
    </div>
    @error('file')<div class="text-red-500">{{ $message }}</div>@enderror

    <button type="submit" class="px-4 py-2 bg-green-600 rounded-md text-white justify-self-start">Submit</button>

</div>

<script>
    document.querySelector('input[name="file"]')?.addEventListener('change', function () {
        var limit = parseInt(this.dataset.maxMb, 10) * 1024 * 1024;
        var warning = document.querySelector('[data-file-too-big]');
        var tooBig = this.files.length > 0 && this.files[0].size > limit;
        warning.classList.toggle('hidden', !tooBig);
    });
</script>
