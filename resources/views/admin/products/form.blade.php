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
            name="sku"
            value="{{ old('sku',$product->sku ?? '') }}"
            class="w-full rounded-lg border border-slate-300 px-4 py-2.5">

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
                value="{{ $category->id }}">

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

            <option value="">
                Select Brand
            </option>

            @foreach($brands as $brand)

            <option value="{{ $brand->id }}">

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

<textarea
    name="description"
    rows="8"
    class="mt-6 w-full rounded-lg border border-slate-300 p-4"></textarea>

<div class="mt-6 flex gap-8">

    <label>

        <input
            type="checkbox"
            name="status"
            value="1"
            checked>

        Active

    </label>

    <label>

        <input
            type="checkbox"
            name="featured"
            value="1">

        Featured

    </label>

</div>

<div class="mt-8">

    <button
        class="rounded-lg bg-indigo-600 px-6 py-3 text-white hover:bg-indigo-700">

        Save Product

    </button>

</div>