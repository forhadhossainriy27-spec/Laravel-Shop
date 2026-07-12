@extends('layouts.admin')

@section('title','Product Details')

@section('content')


<div class="mx-auto max-w-7xl">

    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>

            <h1 class="text-3xl font-bold">
                {{ $product->name }}
            </h1>

            <p class="text-slate-500">
                SKU : {{ $product->sku }}
            </p>

        </div>

        <div class="flex gap-3">

            <a href="{{ route('admin.products.index') }}"
                class="rounded-lg border px-5 py-2 hover:bg-slate-100">
                ← Back
            </a>

            <a href="{{ route('admin.products.edit',$product) }}"
                class="rounded-lg bg-indigo-600 px-5 py-2 text-white hover:bg-indigo-700">
                Edit Product
            </a>

        </div>

    </div>

    {{-- Product Card --}}
    <div class="grid gap-6 lg:grid-cols-3">

        <div class="rounded-xl border bg-white p-6 shadow-sm">

            @if($product->thumbnail)

            <img
                src="{{ asset('storage/'.$product->thumbnail) }}"
                class="mx-auto h-80 w-full rounded-xl border object-cover">

            @else

            <div class="flex h-80 items-center justify-center rounded-xl border bg-slate-100">

                No Image

            </div>

            @endif

        </div>

        <div class="rounded-xl border bg-white p-6 shadow-sm lg:col-span-2">

            <div class="grid gap-6 sm:grid-cols-2">

                <div>

                    <p class="text-sm text-slate-500">
                        Category
                    </p>

                    <p class="font-semibold">
                        {{ $product->category->name }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Brand
                    </p>

                    <p class="font-semibold">
                        {{ $product->brand->name }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Price
                    </p>

                    <p class="text-2xl font-bold text-indigo-600">
                        ৳ {{ number_format($product->price,2) }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Discount Price
                    </p>

                    <p class="text-xl font-semibold text-green-600">
                        {{ $product->discount_price
                            ? '৳ '.number_format($product->discount_price,2)
                            : 'N/A'
                        }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Stock
                    </p>

                    @if($product->stock==0)

                    <span class="rounded-full bg-red-100 px-3 py-1 text-sm text-red-700">

                        Out Of Stock

                    </span>

                    @elseif($product->stock<=5)

                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-sm text-yellow-700">

                        Low Stock ({{ $product->stock }})

                        </span>

                        @else

                        <span class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">

                            {{ $product->stock }} Available

                        </span>

                        @endif

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Status
                    </p>

                    @if($product->status)

                    <span class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">

                        Active

                    </span>

                    @else

                    <span class="rounded-full bg-red-100 px-3 py-1 text-sm text-red-700">

                        Inactive

                    </span>

                    @endif

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Featured
                    </p>

                    @if($product->featured)

                    <span class="rounded-full bg-indigo-100 px-3 py-1 text-sm text-indigo-700">

                        Yes

                    </span>

                    @else

                    <span class="rounded-full bg-slate-100 px-3 py-1 text-sm">

                        No

                    </span>

                    @endif

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Created
                    </p>

                    <p>

                        {{ $product->created_at->format('d M Y h:i A') }}

                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- Description --}}
    <div class="mt-6 rounded-xl border bg-white p-6 shadow-sm">

        <h2 class="mb-4 text-xl font-bold">

            Description

        </h2>

        <div class="prose max-w-none">

            {!! $product->description ?: '<span class="text-slate-500">No Description</span>' !!}

        </div>

    </div>

    {{-- Gallery --}}
    <div class="mt-6 rounded-xl border bg-white p-6 shadow-sm">

        <h2 class="mb-5 text-xl font-bold">

            Gallery Images

        </h2>

        <div class="grid grid-cols-2 gap-4 md:grid-cols-4 xl:grid-cols-6">

            @forelse($product->images as $image)

            <img
                src="{{ asset('storage/'.$image->image) }}"
                class="h-32 w-full rounded-xl border object-cover transition duration-300 hover:scale-105">

            @empty

            <div class="col-span-full rounded-lg bg-slate-50 p-6 text-center text-slate-500">

                No Gallery Images

            </div>

            @endforelse

        </div>

    </div>
    
<div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6 print:grid-cols-2">

    {{-- Barcode Card --}}
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 text-center">

        <h3 class="text-lg font-bold text-slate-800 mb-1">
            Product Barcode
        </h3>

        <p class="text-sm text-slate-500 mb-5">
            Scan or Print
        </p>

        <div class="flex justify-center">
            {!! DNS1D::getBarcodeHTML($product->sku, 'C128', 2.2, 70) !!}
        </div>

        <div class="mt-4">
            <span class="inline-block bg-slate-100 px-4 py-2 rounded-lg font-mono text-sm tracking-widest">
                {{ $product->sku }}
            </span>
        </div>

    </div>

    {{-- QR Code Card --}}
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 text-center">

        <h3 class="text-lg font-bold text-slate-800 mb-1">
            Product QR Code
        </h3>

        <p class="text-sm text-slate-500 mb-5">
            Open Product Page
        </p>

        <div class="flex justify-center">
            {!! QrCode::size(180)
                ->margin(1)
                ->generate(route('admin.products.show',$product)) !!}
        </div>

        <p class="mt-4 text-xs text-slate-500 break-all">
            {{ route('admin.products.show',$product) }}
        </p>

    </div>

</div>

<div class="mt-6 flex justify-end print:hidden">
    <button
        onclick="window.print()"
        class="px-6 py-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 transition">
        🖨️ Print Barcode & QR
    </button>
</div>


    {{-- Activity --}}
    <div class="bg-white rounded-2xl shadow-sm border mt-8">

        <div class="border-b px-6 py-4">
            <h2 class="text-xl font-bold">
                Activity Timeline
            </h2>
        </div>

        <div class="p-6">

            @forelse($product->activities->sortByDesc('created_at') as $activity)

            <div class="relative pl-8 pb-8 last:pb-0">

                {{-- Line --}}
                @unless($loop->last)
                <div class="absolute left-3 top-6 w-0.5 h-full bg-slate-200"></div>
                @endunless

                {{-- Dot --}}
                <div class="absolute left-0 top-1 h-6 w-6 rounded-full
                    @switch($activity->action)

                        @case('created')
                            bg-green-500
                            @break

                        @case('updated')
                            bg-blue-500
                            @break

                        @case('deleted')
                            bg-red-500
                            @break

                        @case('restored')
                            bg-yellow-500
                            @break

                        @default
                            bg-slate-500

                    @endswitch
                ">
                </div>

                <div class="bg-slate-50 rounded-xl p-4">

                    <div class="flex flex-col md:flex-row md:justify-between gap-2">

                        <div>

                            <h4 class="font-semibold">

                                {{ ucfirst($activity->action) }}

                            </h4>

                            <p class="text-sm text-slate-600 mt-1">

                                {{ $activity->description }}

                            </p>

                        </div>

                        <span class="text-xs text-slate-400">

                            {{ $activity->created_at->format('d M Y h:i A') }}

                        </span>

                    </div>

                    <div class="mt-3 text-sm text-slate-500">

                        👤 {{ $activity->user?->name ?? 'System' }}

                    </div>

                </div>

            </div>

            @empty

            <div class="text-center py-10 text-slate-500">

                No activity found.

            </div>

            @endforelse

        </div>

    </div>

</div>

@endsection