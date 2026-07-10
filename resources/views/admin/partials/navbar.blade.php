<header class="sticky top-0 z-20 h-16 bg-white border-b flex items-center justify-between px-6">

    <button @click="sidebar=!sidebar" class="lg:hidden rounded p-2 hover:bg-slate-100">

        ☰

    </button>

    <div>

        <h2 class="font-bold text-xl">
            @yield('title')
        </h2>

    </div>

    <div x-data="{open:false}" class="relative">

        <button @click="open=!open" class="flex items-center gap-2">

            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" class="w-10 h-10 rounded-full">

            <span>{{ auth()->user()->name }}</span>

        </button>

        <div x-show="open" @click.outside="open=false" x-transition
            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border">

            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button class="w-full text-left px-4 py-3 hover:bg-gray-100">

                    Logout

                </button>

            </form>

        </div>

    </div>

</header>