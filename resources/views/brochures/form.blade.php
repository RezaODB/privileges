<div class="grid grid-cols-1 gap-4">

    <select name="lang" class="justify-self-start border-gray-200 shadow rounded-md">
        <option value="fr" {{ old('lang') ?? $brochure->lang === 'fr' ? 'selected' : '' }}>FR</option>
        <option value="en" {{ old('lang') ?? $brochure->lang === 'en' ? 'selected' : '' }}>EN</option>
    </select>
    @error('lang')<div class="text-red-500">{{ $message }}</div>@enderror

    <input type="text" name="category" placeholder="Category" value="{{ old('category') ?? $brochure->category }}" class="border-gray-200 shadow rounded-md" required>
    @error('category')<div class="text-red-500">{{ $message }}</div>@enderror

    <input type="text" name="title" placeholder="Title" value="{{ old('title') ?? $brochure->title }}" class="border-gray-200 shadow rounded-md" required>
    @error('title')<div class="text-red-500">{{ $message }}</div>@enderror

    <textarea name="body">{{ old('body') ?? $brochure->body }}</textarea>
    @error('body')<div class="text-red-500">{{ $message }}</div>@enderror

    <button type="submit" class="px-4 py-2 bg-green-600 rounded-md text-white justify-self-start">Submit</button>

</div>