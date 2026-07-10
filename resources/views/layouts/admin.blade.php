<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Admin')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-100 antialiased">

    <div x-data="{
        sidebar:false,
        deleteModal:false,
        deleteUrl:''
    }" class="min-h-screen flex">

        {{-- Mobile Overlay --}}
        <div x-show="sidebar" x-transition.opacity @click="sidebar=false"
            class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-cloak></div>

        @include('admin.partials.sidebar')

        <div class="flex-1 flex flex-col min-h-screen">

            @include('admin.partials.navbar')

            <main class="flex-1 p-4 md:p-6">
                @if(session('success'))

                <div x-data="{show:true}" x-show="show" x-transition
                    class="mb-5 flex items-center justify-between rounded-lg border border-green-200 bg-green-100 px-5 py-4 text-green-800">

                    <span>{{ session('success') }}</span>

                    <button @click="show=false" class="font-bold">

                        ✕

                    </button>

                </div>

                @endif

                @if(session('error'))

                <div x-data="{show:true}" x-show="show" x-transition
                    class="mb-5 flex items-center justify-between rounded-lg border border-red-200 bg-red-100 px-5 py-4 text-red-700">

                    <span>{{ session('error') }}</span>

                    <button @click="show=false">

                        ✕

                    </button>

                </div>

                @endif

                @yield('content')
            </main>

        </div>
    <div
        x-show="deleteModal"
        x-transition
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

        <div
            @click.outside="deleteModal=false"
            class="w-full max-w-md rounded-xl bg-white shadow-xl">

            <div class="border-b px-6 py-4">

                <h2 class="text-xl font-bold">
                    Delete Category
                </h2>

            </div>

            <div class="p-6">

                <p class="text-slate-600">
                    Are you sure you want to delete this category?
                </p>

            </div>

            <div class="flex justify-end gap-3 border-t px-6 py-4">

                <button
                    @click="deleteModal=false"
                    class="rounded-lg border px-5 py-2">

                    Cancel

                </button>

                <form
                    :action="deleteUrl"
                    method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                        class="rounded-lg bg-red-600 px-5 py-2 text-white hover:bg-red-700">

                        Delete

                    </button>

                </form>

            </div>

        </div>

    </div>
    </div>

</body>

</html>