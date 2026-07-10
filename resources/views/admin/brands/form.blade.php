<div>
    <label class="block mb-2 font-medium">Name</label>

    <input type="text" name="name" value="{{ old('name', $brand->name ?? '') }}"
        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none">

    @error('name')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div
    x-data="{
        preview: '{{ isset($brand) && $brand->logo ? asset('storage/'.$brand->logo) : '' }}'
    }">

    <label class="block mb-2 font-medium text-slate-700">
        Category logo
    </label>

    <input
        type="file"
        name="logo"
        accept="logo/*"
        @change="
            const file = $event.target.files[0];
            if(file){
                preview = URL.createObjectURL(file);
            }
        "
        class="block w-full rounded-lg border border-slate-300 px-3 py-2">

    @error('logo')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror

    <template x-if="preview">
        <div class="mt-5">
            <img
                :src="preview"
                class="h-36 w-36 rounded-xl border object-cover shadow">
        </div>
    </template>

</div>

<div>
    <label class="block mb-2 font-medium">Status</label>

    <div class="flex items-center gap-3">

        <input
            id="status"
            type="checkbox"
            name="status"
            value="1"
            {{ old('status', $brand->status ?? true) ? 'checked' : '' }}
            class="h-5 w-5 rounded">

        <label for="status" class="font-medium">
            Active
        </label>

    </div>
</div>

<div class="flex gap-3">

    <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">

        Save

    </button>

    <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 px-6 py-2 rounded-lg">

        Cancel

    </a>

</div>