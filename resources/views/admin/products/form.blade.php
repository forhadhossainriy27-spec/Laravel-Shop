@if ($errors->any())
    <div class="mb-5 rounded-lg bg-red-100 p-4 text-red-700">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

    <div>

        <label class="mb-2 block font-medium">
            Product Name
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name',$product->name ?? '') }}"
            class="w-full rounded-lg border border-slate-300 px-4 py-2.5">

    </div>

    <div>

        <label class="mb-2 block font-medium">
            SKU
        </label>

<input
    type="text"
    value="{{ $product->sku ?? 'Auto Generate' }}"
    class="w-full rounded-lg border border-slate-300 bg-slate-100 px-4 py-2.5"
    readonly>

    </div>

</div>


<div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">

    <div>

        <label class="mb-2 block font-medium">
            Category
        </label>

        <select
            name="category_id"
            class="w-full rounded-lg border border-slate-300 px-4 py-2.5">

            <option value="">
                Select Category
            </option>

            @foreach($categories as $category)

            <option
                value="{{ $category->id }}"
                {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>

            @endforeach

        </select>

    </div>

    <div>

        <label class="mb-2 block font-medium">
            Brand
        </label>
<select
    name="brand_id"
    class="w-full rounded-lg border border-slate-300 px-4 py-2.5">

    <option value="">Select Brand</option>

    @foreach($brands as $brand)

        <option
            value="{{ $brand->id }}"
            {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>

            {{ $brand->name }}

        </option>

    @endforeach

</select>

    </div>

</div>

<div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">

    <div>

        <label class="mb-2 block font-medium">
            Price
        </label>

        <input
            type="number"
            value="{{ old('price', $product->price ?? '') }}"
            step="0.01"
            name="price"
            class="w-full rounded-lg border border-slate-300 px-4 py-2.5">

    </div>

    <div>

        <label class="mb-2 block font-medium">
            Discount Price
        </label>

        <input
            type="number"
            value="{{ old('discount_price', $product->discount_price ?? '') }}"
            step="0.01"
            name="discount_price"
            class="w-full rounded-lg border border-slate-300 px-4 py-2.5">

    </div>

    <div>

        <label class="mb-2 block font-medium">
            Stock
        </label>

        <input
            type="number"
            value="{{ old('stock', $product->stock ?? '') }}"
            name="stock"
            class="w-full rounded-lg border border-slate-300 px-4 py-2.5">

    </div>

</div>

<div class="mt-6">

    <label class="mb-2 block font-medium">
        Thumbnail
    </label>

    <input
        type="file"
        name="thumbnail"
        accept="image/*"
        class="w-full rounded-lg border border-slate-300 px-4 py-2.5">

</div>

@if(!empty($product?->thumbnail))

<div class="mt-4">

    <img
        src="{{ asset('storage/'.$product->thumbnail) }}"
        class="h-32 w-32 rounded-lg border object-cover">

</div>

@endif

<div class="mt-6">

    <label class="mb-2 block font-medium">
        Gallery Images
    </label>

    <input
        type="file"
        name="gallery[]"
        multiple
        accept="image/*"
        class="w-full rounded-lg border border-slate-300 px-4 py-2.5">

</div>

@if(isset($product))

<div class="mt-8">

    <h3 class="mb-4 font-semibold">

        Gallery

    </h3>

    <div class="grid grid-cols-2 gap-4 md:grid-cols-6">

        @foreach($product->images as $image)

        <div class="relative">

            <img
                src="{{ asset('storage/'.$image->image) }}"
                class="h-28 w-full rounded-lg border object-cover">
<button
    type="button"
    onclick="deleteGalleryImage({{ $image->id }})"
    class="absolute right-2 top-2 rounded-full bg-red-600 px-2 py-1 text-xs text-white hover:bg-red-700">

    ✕

</button>

        </div>

        @endforeach

    </div>

</div>

@endif

<textarea
    name="description"
    rows="8"
    class="mt-6 w-full rounded-lg border border-slate-300 p-4">{{ old('description', $product->description ?? '') }}</textarea>

<div class="mt-6 flex gap-8">

    <label>

<input
    type="checkbox"
    name="status"
    value="1"
    {{ old('status', $product->status ?? true) ? 'checked' : '' }}>

        Active

    </label>

    <label>

<input
    type="checkbox"
    name="featured"
    value="1"
    {{ old('featured', $product->featured ?? false) ? 'checked' : '' }}>

        Featured

    </label>

</div>

<div class="mt-8">

<button
    type="submit"
    class="rounded-lg bg-indigo-600 px-6 py-3 text-white hover:bg-indigo-700">
    Save Product
</button>

</div>
