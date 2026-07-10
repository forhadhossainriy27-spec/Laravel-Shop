@extends('layouts.admin')

@section('title', 'Categories')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

    <div>
        <h1 class="text-3xl font-bold text-slate-800">Categories</h1>
        <p class="text-slate-500">Manage all categories</p>
    </div>

    <a href="{{ route('admin.categories.trash') }}"
        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">
        Trash
    </a>

    <a href="{{ route('admin.categories.create') }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg">
        + Add Category
    </a>

</div>

<form method="GET" class="mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search category..."
        class="w-full md:w-80 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
</form>



<div class="bg-white rounded-xl border shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-slate-100">

                <tr>
                    <th class="px-6 py-4 text-left">ID</th>
                    <th class="px-6 py-4 text-left">Name</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-center">Action</th>
                </tr>

            </thead>

            <tbody>

                @forelse($categories as $category)

                <tr class="border-t hover:bg-slate-50">

                    <td class="px-6 py-4">{{ $category->id }}</td>

                    <td class="px-6 py-4 font-medium">
                        {{ $category->name }}
                    </td>

                    <td class="px-6 py-4">

                        @if($category->status)
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

                        <a href="{{ route('admin.categories.edit', $category) }}"
                            class="text-indigo-600 hover:text-indigo-800 font-medium">
                            Edit
                        </a>

                        <span class="mx-2">|</span>

<button
    @click="
        deleteModal=true;
        deleteUrl='{{ route('admin.categories.destroy',$category) }}'
    "
    class="text-red-600 hover:text-red-700">

    Delete

</button>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="text-center py-10 text-slate-500">
                        No categories found.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-6">
    {{ $categories->links() }}
</div>

@endsection