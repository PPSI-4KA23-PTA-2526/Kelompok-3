<header class="fixed top-0 left-0 w-full z-50 bg-white border-b">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.svg') }}" class="h-8" alt="Logo">
                </a>
            </div>


            <!-- Menu -->
            <nav class="hidden md:flex gap-8 text-sm font-medium text-gray-700">
                <a href="{{ route('antrean') }}" class="hover:text-orange-600">Antrean</a>
                <a href="{{ route('produk.index') }}" class="hover:text-orange-600">Belanja</a>
                <a href="#" class="hover:text-orange-600">Portofolio</a>
                <a href="#" class="hover:text-orange-600">Kontak</a>
            </nav>

            <!-- Search -->
            <div class="relative w-64">
                <input type="text" placeholder="Cari banner, plakat, dll"
                    class="w-full rounded-full border py-2 pl-4 pr-10 text-sm focus:ring-orange-500">
                <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m1.85-5.65a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                </svg>
            </div>

        </div>
    </div>
</header>
