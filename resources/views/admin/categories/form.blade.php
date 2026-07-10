<div>
    <label class="block mb-2 font-medium">Name</label>

    <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}"
        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none">

    @error('name')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block mb-2 font-medium">Image</label>

    <input type="file" name="image" class="w-full rounded-lg border-gray-300">

    @error('image')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    @if(!empty($category?->image))
    <img src="{{ asset('storage/'.$category->image) }}" class="w-28 h-28 mt-3 rounded-lg border object-cover">
    @endif
</div>

<div>
    <label class="block mb-2 font-medium">Status</label>

    <select name="status" class="w-full rounded-lg border-gray-300">

        <option value="1" @selected(old('status',1)==1)>Active</option>
        <option value="0" @selected(old('status')==='0' )>Inactive</option>

    </select>
</div>

<div class="flex gap-3">

    <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">

        Save

    </button>

    <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 px-6 py-2 rounded-lg">

        Cancel

    </a>

</div>