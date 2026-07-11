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
    <a
        href="{{ route('admin.products.export') }}"
        class="rounded-lg bg-green-600 px-5 py-2.5 text-white hover:bg-green-700">

        Export Excel

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

    <select
        name="sort"
        class="rounded-lg border border-slate-300 px-4 py-2">

        <option value="">Latest</option>

        <option value="oldest" @selected(request('sort')=='oldest' )>
            Oldest
        </option>

        <option value="name_asc" @selected(request('sort')=='name_asc' )>
            Name A-Z
        </option>

        <option value="name_desc" @selected(request('sort')=='name_desc' )>
            Name Z-A
        </option>

        <option value="price_low" @selected(request('sort')=='price_low' )>
            Price Low → High
        </option>

        <option value="price_high" @selected(request('sort')=='price_high' )>
            Price High → Low
        </option>

        <option value="stock" @selected(request('sort')=='stock' )>
            Stock
        </option>

    </select>

    <select
        name="stock"
        class="rounded-lg border border-slate-300 px-4 py-2">

        <option value="">All Stock</option>

        <option
            value="low"
            @selected(request('stock')=='low' )>

            Low Stock

        </option>

        <option
            value="out"
            @selected(request('stock')=='out' )>

            Out Of Stock

        </option>

    </select>

</form>

<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

    <form action="{{ route('admin.products.bulkAction') }}" method="POST">

        @csrf

        <!-- Top Toolbar -->
        <div class="flex flex-col gap-3 border-b p-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex flex-col gap-3 sm:flex-row">

                <select
                    name="action"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                    <option value="">Bulk Action</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="delete">Delete</option>

                </select>

                <button
                    id="bulkApply"
                    type="submit"
                    disabled
                    class="rounded-lg bg-indigo-600 px-5 py-2 text-white disabled:cursor-not-allowed disabled:opacity-50">

                    Apply

                </button>

            </div>

            <span
                id="selectedCount"
                class="rounded-lg bg-slate-100 px-4 py-2 text-sm">

                0 Selected

            </span>

            <div class="text-sm text-slate-500">
                Total: <span class="font-semibold">{{ $products->total() }}</span> Products
            </div>

        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="sticky top-0 bg-slate-100">

                    <tr class="text-slate-700">

                        <th class="px-4 py-3 text-center">
                            <input type="checkbox" id="checkAll">
                        </th>

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

                    <tr class="border-t even:bg-slate-50 hover:bg-indigo-50 transition">

                        <td class="px-4 py-3 text-center">
                            <input
                                type="checkbox"
                                class="rowCheck rounded"
                                name="ids[]"
                                value="{{ $product->id }}">
                        </td>

                        <td class="px-4 py-3">

                            @if($product->thumbnail)

                            <img
                                src="{{ asset('storage/'.$product->thumbnail) }}"
                                class="h-16 w-16 rounded-xl border object-cover">

                            @else

                            <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-slate-100 text-xs text-slate-400">
                                No Image
                            </div>

                            @endif

                        </td>

                        <td class="px-4 py-3">

                            <h4 class="font-semibold text-slate-800">
                                {{ $product->name }}
                            </h4>

                            <p class="text-xs text-slate-500">
                                SKU: {{ $product->sku }}
                            </p>

                        </td>

                        <td class="px-4 py-3">
                            {{ $product->category->name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $product->brand->name }}
                        </td>

                        <td class="px-4 py-3 text-right font-semibold text-indigo-600">
                            ৳ {{ number_format($product->price,2) }}
                        </td>

                        <td class="px-4 py-3 text-center">

                            @if($product->stock==0)

                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                Out of Stock
                            </span>

                            @elseif($product->stock<=5)

                                <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                Low ({{ $product->stock }})
                                </span>

                                @else

                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    {{ $product->stock }}
                                </span>

                                @endif

                        </td>

                        <td class="px-4 py-3 text-center">

                            @if($product->status)

                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                Active
                            </span>

                            @else

                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Inactive
                            </span>

                            @endif

                        </td>

                        <td class="px-4 py-3">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.products.show',$product) }}"
                                    class="text-blue-600 hover:underline">
                                    View
                                </a>

                                |

                                <a
                                    href="{{ route('admin.products.edit',$product) }}"
                                    class="rounded-lg bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-700 hover:bg-indigo-200">

                                    Edit

                                </a>

                                |

                                <form
                                    action="{{ route('admin.products.duplicate', $product) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf

                                    <button
                                        onclick="return confirm('Duplicate this product?')"
                                        class="text-green-600 hover:underline">

                                        Dup

                                    </button>

                                </form>

                                |

                                <button
                                    type="button"
                                    @click="
deleteModal=true;
document.getElementById('deleteForm').action='{{ route('admin.products.destroy',$product) }}';
"
                                    class="rounded-lg bg-red-100 px-3 py-1 text-xs font-medium text-red-700 hover:bg-red-200">

                                    Del

                                </button>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9" class="py-16 text-center text-slate-500">
                            No products found.
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </form>

</div>

<div class="mt-6">

    {{ $products->links() }}

</div>

<script>
    const checkAll = document.getElementById('checkAll');
    const rowChecks = document.querySelectorAll('.rowCheck');
    const count = document.getElementById('selectedCount');
    const apply = document.getElementById('bulkApply');
    const form = document.querySelector('form[action*="bulk-action"]');

    function updateSelection() {

        const checked = document.querySelectorAll('.rowCheck:checked').length;

        count.innerText = checked + ' Selected';

        apply.disabled = checked === 0;
    }

    checkAll?.addEventListener('change', function() {

        rowChecks.forEach(item => item.checked = this.checked);

        updateSelection();
    });

    rowChecks.forEach(item => {

        item.addEventListener('change', updateSelection);

    });

    form?.addEventListener('submit', function(e) {

        const action = document.querySelector('[name="action"]').value;

        if (action === 'delete') {

            if (!confirm('Delete selected products?')) {

                e.preventDefault();

            }

        }

    });

    updateSelection();
</script>

@endsection