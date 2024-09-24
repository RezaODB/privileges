<div class="grid grid-cols-1 gap-4">

    <textarea name="question_fr" rows="3" placeholder="Question FR" class="border-gray-200 shadow rounded-md" required>{{ old('question_fr') ?? $quota->question_fr }}</textarea>
    @error('question_fr')<div class="text-red-500">{{ $message }}</div>@enderror
    
    <textarea name="question_en" rows="3" placeholder="Question EN" class="border-gray-200 shadow rounded-md" required>{{ old('question_en') ?? $quota->question_en }}</textarea>
    @error('question_en')<div class="text-red-500">{{ $message }}</div>@enderror
   
    <button type="submit" class="px-4 py-2 bg-green-600 rounded-md text-white justify-self-start">Submit</button>

</div>