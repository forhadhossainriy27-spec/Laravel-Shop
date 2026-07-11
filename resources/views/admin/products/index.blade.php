@extends('layouts.admin')

@section('title','Products')

@section('content')

<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">

    <div>
        <h1 class="text-3xl font-bold">Products</h1>
        <p class="text-slate-500">Manage all products</p>
    </div>

    <a href="{{ route('admin.products.create') }}"
        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-white hover:bg-indigo-700">
        + Add Product
    </a>

</div>

<form method="GET" class="mb-6 grid gap-4 md:grid-cols-6">

    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search name / SKU"
        class="rounded-lg border border-slate-300 px-4 py-2">

    <select
        name="category"
        class="rounded-lg border border-slate-300 px-4 py-2">

        <option value="">All Categories</option>

        @foreach($categories as $category)

        <option
            value="{{ $category->id }}"
            @selected(request('category')==$category->id)>

            {{ $category->name }}

        </option>

        @endforeach

    </select>

    <select
        name="brand"
        class="rounded-lg border border-slate-300 px-4 py-2">

        <option value="">All Brands</option>

        @foreach($brands as $brand)

        <option
            value="{{ $brand->id }}"
            @selected(request('brand')==$brand->id)>

            {{ $brand->name }}

        </option>

        @endforeach

    </select>

    <select
        name="status"
        class="rounded-lg border border-slate-300 px-4 py-2">

        <option value="">Status</option>
        <option value="1" @selected(request('status')==='1' )>Active</option>
        <option value="0" @selected(request('status')==='0' )>Inactive</option>

    </select>

    <select
        name="featured"
        class="rounded-lg border border-slate-300 px-4 py-2">

        <option value="">Featured</option>
        <option value="1" @selected(request('featured')==='1' )>Yes</option>
        <option value="0" @selected(request('featured')==='0' )>No</option>

    </select>

    <button
        class="rounded-lg bg-indigo-600 py-2 text-white hover:bg-indigo-700">

        Filter

    </button>
    <a
        href="{{ route('admin.products.index') }}"
        class="rounded-lg border border-slate-300 px-4 py-2 text-center hover:bg-slate-100">

        Reset

    </a>

</form>

<div class="overflow-x-auto rounded-xl border bg-white shadow-sm">

    <table class="min-w-full">

        <thead class="bg-slate-50">

            <tr>

                <th class="px-4 py-3 text-left">Image</th>
                <th class="px-4 py-3 text-left">Product</th>
                <th class="px-4 py-3 text-left">Category</th>
                <th class="px-4 py-3 text-left">Brand</th>
                <th class="px-4 py-3 text-right">Price</th>
                <th class="px-4 py-3 text-center">Stock</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Action</th>

            </tr>

        </thead>

        <tbody>

            @forelse($products as $product)

            <tr class="border-t">

                <td class="px-4 py-3">

                    @if($product->thumbnail)

                    <img
                        src="{{ asset('storage/'.$product->thumbnail) }}"
                        class="h-14 w-14 rounded-lg border object-cover">

                    @endif

                </td>

                <td class="px-4 py-3">

                    <div class="font-semibold">
                        {{ $product->name }}
                    </div>

                    <div class="text-xs text-slate-500">
                        {{ $product->sku }}
                    </div>

                </td>

                <td class="px-4 py-3">
                    {{ $product->category->name }}
                </td>

                <td class="px-4 py-3">
                    {{ $product->brand->name }}
                </td>

                <td class="px-4 py-3 text-right">
                    ৳ {{ number_format($product->price,2) }}
                </td>

                <td class="px-4 py-3 text-center">
                    {{ $product->stock }}
                </td>

                <td class="px-4 py-3 text-center">

                    @if($product->status)
                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs text-green-700">
                        Active
                    </span>
                    @else
                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs text-red-700">
                        Inactive
                    </span>
                    @endif

                </td>

                <td class="px-4 py-3 text-center">

                    <a href="{{ route('admin.products.edit',$product) }}"
                        class="text-indigo-600 hover:underline">

                        Edit

                    </a>

                    |

                    <button
                        type="button"
                        @click="
deleteModal=true;
document.getElementById('deleteForm').action='{{ route('admin.products.destroy',$product) }}';
"
                        class="text-red-600">

                        Delete

                    </button>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8" class="py-12 text-center text-slate-500">

                    No products found.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

<div class="mt-6">

    {{ $products->links() }}

</div>

@endsection