@extends('layouts.admin')

@section('title', 'Brands')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

    <div>
        <h1 class="text-3xl font-bold text-slate-800">Brands</h1>
        <p class="text-slate-500">Manage all brands</p>
    </div>

    <a href="{{ route('admin.brands.trash') }}"
        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">
        Trash
    </a>

    <a href="{{ route('admin.brands.create') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg">
        + Add Brand
    </a>

</div>

<div class="relative mb-6">

    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search Brand..."
        class="w-full md:w-96 rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4
               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">

    <svg
        class="absolute left-4 top-3.5 h-5 w-5 text-slate-400"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />

    </svg>

</div>



<div class="bg-white rounded-xl border shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-slate-50">

                <tr>

                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-slate-600">
                        ID
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-slate-600">
                        Logo
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-slate-600">
                        Brand
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-slate-600">
                        Status
                    </th>

                    <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wide text-slate-600">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($brands as $Brand)

                <tr class="border-t hover:bg-slate-50">

                    <td class="px-6 py-4">{{ $Brand->id }}</td>

                    <td class="px-6 py-4">
                        @if($Brand->logo)
                        <img
                            src="{{ asset('storage/'.$Brand->logo) }}"
                            class="h-12 w-12 rounded-lg border object-cover">
                        @endif
                    </td>

                    <td class="px-6 py-4 font-medium">
                        {{ $Brand->name }}
                    </td>

                    <td class="px-6 py-4">

                        @if($Brand->status)
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                            Active
                        </span>
                        @else
                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                            Inactive
                        </span>
                        @endif

                    </td>

                    <td class="px-6 py-4 text-center">

                        <div class="flex justify-center gap-2">

                            <a
                                href="{{ route('admin.brands.edit',$Brand) }}"
                                class="rounded-lg bg-indigo-100 px-3 py-1.5 text-sm font-medium text-indigo-700 hover:bg-indigo-200">

                                Edit

                            </a>

                            <button
                                type="button"
                                @click="
        deleteModal = true;
        document.getElementById('deleteForm').action='{{ route('admin.brands.destroy', $Brand) }}';
    "
                                class="rounded-lg bg-red-100 px-3 py-1.5 text-red-700 hover:bg-red-200">

                                Delete

                            </button>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center py-10 text-slate-500">
                        <div class="py-12">

                            <div class="text-6xl mb-3">
                                📂
                            </div>

                            <h3 class="text-xl font-semibold text-slate-700">
                                No brands Found
                            </h3>

                            <p class="mt-2 text-slate-500">
                                Click "Add Brand" to create your first Brand.
                            </p>

                        </div>
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-6">
    {{ $brands->links() }}
</div>

@endsection