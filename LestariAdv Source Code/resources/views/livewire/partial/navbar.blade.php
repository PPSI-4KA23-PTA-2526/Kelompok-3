<header class="fixed top-0 left-0 z-50 w-full bg-white border-b">
    <div class="px-6 mx-auto max-w-7xl">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.svg') }}" class="h-8" alt="Logo">
                </a>
            </div>

            <!-- Menu -->
            <nav class="hidden gap-8 text-sm font-medium text-gray-700 md:flex">
                <a href="{{ route('antrean') }}" class="hover:text-orange-600">Antrean</a>
                <a href="{{ route('produk.index') }}" class="hover:text-orange-600">Belanja</a>
                <a href="{{ route('home') }}#portfolio" class="hover:text-orange-600">Portofolio</a>
                <a href="{{ url('#kontak') }}" class="hover:text-orange-600">Kontak</a>
            </nav>

            <!-- Search Form -->
            <form action="{{ route('produk.index') }}" method="GET" class="relative w-64">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari banner, plakat, dll"
                    class="w-full py-2 pl-4 pr-10 text-sm border rounded-full focus:ring-orange-500 focus:border-orange-500">

                <!-- Preserve category filter if exists -->
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <button type="submit" class="absolute -translate-y-1/2 right-4 top-1/2">
                    <svg class="w-4 h-4 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m1.85-5.65a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                    </svg>
                </button>
            </form>

        </div>
    </div>
</header>
