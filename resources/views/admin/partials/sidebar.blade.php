<aside class="fixed lg:static inset-y-0 left-0 z-40
           w-64 bg-slate-900 text-white
           transform transition duration-300
           -translate-x-full
           lg:translate-x-0" :class="sidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

    <div class="h-16 flex items-center justify-center border-b border-slate-700">

        <h1 class="text-xl font-bold">
            Laravel Shop
        </h1>

    </div>

    <nav class="p-4 space-y-2">

        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 transition
   {{ request()->routeIs('admin.dashboard')
        ? 'bg-indigo-600 text-white'
        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m0-8H5m7 0h7" />
            </svg>

            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 transition
   {{ request()->routeIs('admin.categories.*')
        ? 'bg-indigo-600 text-white'
        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            Categories
        </a>

        <a href="#" class="block rounded-lg px-4 py-3 hover:bg-slate-800">
            Brands
        </a>

        <a href="#" class="block rounded-lg px-4 py-3 hover:bg-slate-800">
            Products
        </a>

        <a href="#" class="block rounded-lg px-4 py-3 hover:bg-slate-800">
            Orders
        </a>

    </nav>

</aside>