@extends('layouts.admin')

@section('title','Product Trash')

@section('content')

<h1 class="mb-6 text-3xl font-bold">
    Product Trash
</h1>

<div class="overflow-x-auto rounded-xl bg-white shadow">

    <table class="min-w-full">

        <thead>

            <tr>

                <th class="px-4 py-3 text-left">Name</th>
                <th class="px-4 py-3">Category</th>
                <th class="px-4 py-3">Brand</th>
                <th class="px-4 py-3">Deleted</th>
                <th class="px-4 py-3">Action</th>

            </tr>

        </thead>

        <tbody>

            @forelse($products as $product)

            <tr class="border-t">

                <td class="px-4 py-3">
                    {{ $product->name }}
                </td>

                <td class="px-4 py-3">
                    {{ $product->category?->name }}
                </td>

                <td class="px-4 py-3">
                    {{ $product->brand?->name }}
                </td>

                <td class="px-4 py-3">
                    {{ $product->deleted_at->diffForHumans() }}
                </td>

                <td class="px-4 py-3">

                    {{-- Restore & Delete buttons next step --}}
                    <div class="flex gap-2">

                        <form
                            action="{{ route('admin.products.restore',$product->id) }}"
                            method="POST">

                            @csrf
                            @method('PATCH')

                            <button
                                class="rounded-lg bg-green-600 px-3 py-2 text-white hover:bg-green-700">

                                Restore

                            </button>

                        </form>

                        <form
                            action="{{ route('admin.products.forceDelete',$product->id) }}"
                            method="POST"
                            onsubmit="return confirm('Permanently delete this product?')">

                            @csrf
                            @method('DELETE')

                            <button
                                class="rounded-lg bg-red-600 px-3 py-2 text-white hover:bg-red-700">

                                Delete Forever

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="5" class="py-10 text-center text-slate-500">
                    Trash is empty.
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