@extends('layouts.admin')

@section('title', 'Trash brands')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold">Trash brands</h1>

    <a href="{{ route('admin.brands.index') }}"
       class="bg-slate-600 text-white px-4 py-2 rounded-lg">
        Back
    </a>
</div>

<div class="bg-white rounded-xl shadow border overflow-x-auto">

    <table class="w-full">

        <thead class="bg-slate-100">
            <tr>
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-center">Action</th>
            </tr>
        </thead>

        <tbody>

        @forelse($brands as $Brand)

            <tr class="border-t">

                <td class="px-6 py-4">
                    {{ $Brand->name }}
                </td>

                <td class="px-6 py-4 text-center">

                    <form
                        action="{{ route('admin.brands.restore',$Brand->id) }}"
                        method="POST"
                        class="inline">

                        @csrf
                        @method('PATCH')

                        <button class="text-green-600">
                            Restore
                        </button>

                    </form>

                    |

                    <form
                        action="{{ route('admin.brands.forceDelete',$Brand->id) }}"
                        method="POST"
                        class="inline"
                        onsubmit="return confirm('Permanently delete?')">

                        @csrf
                        @method('DELETE')

                        <button class="text-red-600">
                            Delete Forever
                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="2" class="text-center py-10">
                    Trash is empty.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

<div class="mt-6">
    {{ $brands->links() }}
</div>

@endsection