<div class="grid grid-cols-1 gap-4">

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <input type="text" name="value_fr" placeholder="Le chiffre (FR) — ex. 6 %" value="{{ old('value_fr', $figure->value_fr) }}" class="w-full border-gray-200 shadow rounded-md" required>
            @error('value_fr')<div class="text-red-500">{{ $message }}</div>@enderror
        </div>
        <div>
            <input type="text" name="value_en" placeholder="The figure (EN) — optional" value="{{ old('value_en', $figure->value_en) }}" class="w-full border-gray-200 shadow rounded-md">
            @error('value_en')<div class="text-red-500">{{ $message }}</div>@enderror
        </div>
        <p class="text-sm text-gray-500 sm:col-span-2">Court&nbsp;: <code>6 %</code>, <code>132 ans</code>, <code>+5 000 h</code>. Laissez l'anglais vide pour reprendre le fran&ccedil;ais.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <textarea name="label_fr" rows="3" placeholder="Ce que le chiffre compte (FR)" class="w-full border-gray-200 shadow rounded-md" required>{{ old('label_fr', $figure->label_fr) }}</textarea>
            @error('label_fr')<div class="text-red-500">{{ $message }}</div>@enderror
        </div>
        <div>
            <textarea name="label_en" rows="3" placeholder="What it counts (EN) — optional" class="w-full border-gray-200 shadow rounded-md">{{ old('label_en', $figure->label_en) }}</textarea>
            @error('label_en')<div class="text-red-500">{{ $message }}</div>@enderror
        </div>
        <p class="text-sm text-gray-500 sm:col-span-2">Une ou deux lignes sous le chiffre, par exemple &laquo;&nbsp;d'enfants d'origine ouvri&egrave;re &agrave; l'ENA&nbsp;&raquo;.</p>
    </div>

    <button type="submit" class="px-4 py-2 bg-green-600 rounded-md text-white justify-self-start">Submit</button>

</div>
